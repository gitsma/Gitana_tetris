<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo ucfirst($this->name) ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo ROOT ?>style/fonts/font-awsome/css/all.css">
  <link rel="stylesheet" href="navbar.css"
  <?php
  $pathToCss = "style/css/$this->name.css";
  if (file_exists($pathToCss)) {
    echo '<link rel="stylesheet" href="' . ROOT . $pathToCss . '">';
  }
  ?>
</head>

<body>
 



