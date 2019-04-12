<?php 

class Session
{

  public static function init()
  {
    @session_start(); // eta isjungia warningus. siuo atveju todel, kad gali buti jog jau yra sukurta sesija, taigi palaiko senaja
  }

  public static function set($name, $value)
  {
    $_SESSION[$name] = $value;
  }

  public static function get($name)
  {
    return $_SESSION[$name] ?? false;
  }

  public static function destroy()
  {
    session_destroy();
  }

  public static function redirectToLogin()
  {
    Session::destroy();
    header('Location: ' . ROOT . 'login');
    exit();
  }
}