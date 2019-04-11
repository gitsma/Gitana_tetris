<?php
require "views/common/head.php";
require "views/common/navbar.php";
echo '
<div class="content">
  <div class="container">';
    require "views/$this->name/index.php";
echo '
  </div>
</div>';
require "views/common/footer.php";