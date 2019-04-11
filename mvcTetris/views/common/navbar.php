<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="<?php echo ROOT ?>home">TETERIS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ROOT ?>istorija">Žaidimo istorija</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ROOT ?>taisykles">Taisyklės</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ROOT ?>susisiekite">Susisiekite</a>
        </li>
      </ul>
      <ul class="navbar-nav float-right">
        <li class="nav-item">
          <?php
          if (Session::get('loggedIn')) {
            ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ROOT ?>playersOnline">Players Online</a>
        </li>

        <?php

      }
      if (Session::get('loggedIn')) {
        ?>
        <li class="nav-item">
          <a class="nav-link user-profile-link" href="<?php echo ROOT ?>home">
            <?php 
            if (Session::get('name') && Session::get('surname')) {
              {{}}?>
            <span><?php echo Session::get('name') ?></span>
            <span><?php echo Session::get('surname') ?></span>
          </a>
        </li>
        <?php
      }
    }



      echo '<li class="nav-item">';
      if (Session::get('loggedIn')) echo '<a class="nav-link" href="' . ROOT . 'login/logout">Logout</a>';
      else echo '<a class="nav-link" href="' . ROOT . 'login">Login</a>';
      echo '</li>';
      ?>
      </ul>
    </div>
  </div>
</nav>