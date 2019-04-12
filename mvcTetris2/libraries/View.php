<?php
class View
{
  private $name;
  public $args;

  public function __construct($name)
  {
    $this->name = $name;
    $this->args = [];
  }

  public function render(){
    include 'views/common/template.php';
  }
}