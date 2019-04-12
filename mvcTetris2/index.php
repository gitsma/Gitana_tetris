<?php
include 'config.php';
function __autoload($classname) // autoload veikia tik tada, kai ji yra reikalinga.
{
  require_once "libraries/" . $classname . ".php";
}

$app = new App(); // uzkrauna klases tik tada, kai yra nezinomos klases
