<?php

class Controller
{
  protected $view;
  protected $model;

  protected function __construct($name) // controlerio vardas
  {

    $pathToView = "views/$name/index.php"; // kad pagal skiltu suformuotu kelia iiki vaizdo
    if (file_exists($pathToView)) {
      $this->view = new View($name);
    }

    $pathToModel = "models/" . ucfirst($name) . "Model.php"; // jeigu yra modelis, ji itrauk ir idek modelio klases objekta
    if (file_exists($pathToModel)) {
      include $pathToModel;
      $modelName = ucfirst($name) . "Model";
      $this->model = new $modelName();
    }
    Session::init();
  }

  public function index()
  {
    $this->view->render();
  }
}
