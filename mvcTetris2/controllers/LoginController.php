<?php

class LoginController extends Controller
{
  public function __construct($name)
  {
    parent::__construct($name);
  }

  public function index()
  {
    if (Session::get('loggedIn')) header('Location: ' . ROOT . 'home'); // jei vartotojas prisijunges, nukreipk i home
    $this->view->args['form'] = 'login';
    parent::index();
  }

  public function login()
  {
    if (Session::get('loggedIn')) header('Location: ' . ROOT . 'home');
    if (!empty([$_POST]) && isset($_POST, $_POST['login'])) { // cia paspaudziame login forma
      $data = [
        'user' => $_POST['user'],
        'pass' => $_POST['pass']
      ];
      // TODO: validation
      $loginResult = $this->model->login($data);
      if ($loginResult != false) {
        Session::set('id', $loginResult['id']);
        Session::set('role', $loginResult['role']);
        Session::set('loggedIn', true);
        if ($loginResult['role'] == 'reader') {  // jei user yra sujungtas su readeriu , t.y. jei pavyko patruraukti visus duomenis
          Session::set('name', $loginResult['name']);
          Session::set('surname', $loginResult['surname']);
          Session::set('email', $loginResult['email']);
          Session::set('phone', $loginResult['phone']);
        }
        header('Location: ' . ROOT . 'home');
      } else {
        // nelabai pavyko prisijungti, bičiuli
        // TODO:  pranešimas apie blogą prisijungimą
        header('Location: ' . ROOT . 'login');
      }

    } else {
      header('Location: ' . ROOT . 'login');
    }
  }


  public function logout()
  {
    Session::redirectToLogin();
  }

  public function registerForm()
  {
    if (Session::get('loggedIn')) header('Location: ' . ROOT . 'home');
    $this->view->args['form'] = 'register';
    parent::index();
  }

  public function forgot()
  {
    if (Session::get('loggedIn')) header('Location: ' . ROOT . 'home');
    $this->view->args['form'] = 'forgot';
    parent::index();
  }

  public function register()
  {
    if (!empty([$_POST]) && isset($_POST['register'])) {
      $loginValidation = new ValidationInput($_POST['login']);
      $loginValidation
        ->empty()
        ->length(6, 32);

      $passValidation = new ValidationInput($_POST['pass']);
      $passValidation
        ->empty()
        ->minCapitals(1)
        ->containsNumbers(1)
        ->length(8, 32);

      $repPassValidation = new ValidationInput($_POST['rep-pass']);
      $repPassValidation->equals($passValidation->value());

      $roleValidation = new ValidationInput($_POST['role']);
      $roleValidation->oneOf(['moderator', 'librarian', 'reader']);

      // Ar yra klaida nors vienam laukelyje?
      if (!$loginValidation->success() || !$passValidation->success() ||
        !$repPassValidation->success() || !$roleValidation->success()) {
        // Reiškmės laukeliams užpildyti
        $this->view->args['login'] = $loginValidation->value();
        $this->view->args['pass'] = $passValidation->value();
        $this->view->args['rep-pass'] = $repPassValidation->value();
        $this->view->args['role'] = $roleValidation->value();

        // Sukuriamas klaidų masyvas skirtas klaidoms, jeigu įvedimo laukelio reikšmė neatitiko reikalavimų
        if (!$loginValidation->success()) $this->view->args['loginErrors'] = $loginValidation->getErrors();
        if (!$passValidation->success()) $this->view->args['passErrors'] = $passValidation->getErrors();
        if (!$repPassValidation->success()) $this->view->args['repPassErrors'] = $repPassValidation->getErrors();
        if (!$roleValidation->success()) $this->view->args['roleErrors'] = $roleValidation->getErrors();
        $this->registerForm();
      } else {
        // Bandome sukurti naują vartotoją ir išsaugome rezultatą
        $createUserResult = $this->model->createUser([
          'login' => $loginValidation->value(),
          'pass' => $passValidation->value(),
          'role' => $roleValidation->value()
        ]);
        
        if ($createUserResult !== false) {
          // Jei sėkmingai sukūrėme, nukriapiame į prisijungimą su duomenimis
          Session::set('id', $createUserResult);
          Session::set('role', $roleValidation->value());
          Session::set('loggedIn', true);
          header('Location: ' . ROOT . 'home');
        } else {
          // Jei naujo vartotojo sukūrimas nepavyko, gražiname į registraciją, dėl užimto vartotojo
          $this->view->args['login'] = $loginValidation->value();
          $this->view->args['pass'] = $passValidation->value();
          $this->view->args['rep-pass'] = $repPassValidation->value();
          $this->view->args['role'] = $roleValidation->value();

          $this->view->args['loginErrors'] = ['Sorry, this username is taken :('];
          $this->registerForm();
        }
      }
    } else {
      header('Location: ' . ROOT . 'login');
    }
  }
}