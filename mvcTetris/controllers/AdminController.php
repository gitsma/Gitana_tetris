<?php

class AdminController extends Controller
{
  public function __construct($name)
  {
    parent::__construct($name);
    if (!Session::get('loggedIn') || Session::get('role') != 'admin') {
      header('Location: ' . ROOT . 'login');
    }
  }

  public function index(){
    $this->view->args['header'] = 'All users';
    $this->view->args['users'] = $this->model->getUsers();
    parent::index();
  }
}