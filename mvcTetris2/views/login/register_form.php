<form action="<?php echo ROOT ?>login/register" method="post">
  <h1 class="text-primary hand-writen display-4 text-center">Register</h1>
  <div class="form-group mb-4">
    <i class="fa fa-user"></i>
    <input class="form-control <?php if (isset($this->args['loginErrors'])) echo 'is-invalid'; ?>"
      type="text" class="form-control" placeholder="Username" required="required" name="login"
      value="<?php echo isset($this->args['login']) ? $this->args['login'] : ''; ?>"
    >
    <?php
      if (isset($this->args['loginErrors'])) {
        echo '<div class="invalid-feedback">';
        foreach ($this->args['loginErrors'] as $error) echo '<div>' . $error . '</div>';
        echo '</div>';
      }
    ?>
  </div>
  <div class="form-group mb-4">
    <i class="fa fa-lock"></i>
    <input class="form-control <?php if (isset($this->args['passErrors'])) echo 'is-invalid'; ?>" 
      type="password"  placeholder="Password" required="required" name="pass"
      value="<?php echo isset($this->args['pass']) ? $this->args['pass'] : ''; ?>"
    >
    <?php
      if (isset($this->args['passErrors'])) {
        echo '<div class="invalid-feedback">';
        foreach ($this->args['passErrors'] as $error) echo '<div>' . $error . '</div>';
        echo '</div>';
      }
    ?>
  </div>
  <div class="form-group mb-4">
    <i class="fa fa-lock"></i>
    <input class="form-control <?php if (isset($this->args['repPassErrors'])) echo 'is-invalid'; ?>"
      type="password" placeholder="Repeat password" required="required" name="rep-pass"
      value="<?php echo isset($this->args['rep-pass']) ? $this->args['rep-pass'] : ''; ?>"
    >
    <?php
      if (isset($this->args['repPassErrors'])) {
        echo '<div class="invalid-feedback">';
        foreach ($this->args['repPassErrors'] as $error) echo '<div>' . $error . '</div>';
        echo '</div>';
      }
    ?>
  </div>
  <div class="form-group mb-4">
    <label for="role">Please select preferable role</label>
    <select name="role" id="role" 
      class="form-control <?php if (isset($this->args['roleErrors'])) echo 'is-invalid'; ?>"
    >
      <option <?php if(isset($this->args['role']) && $this->args['role'] === 'reader') echo 'selected'; ?> value="reader">Reader</option>
      <option <?php if(isset($this->args['role']) && $this->args['role'] === 'librarian') echo 'selected'; ?> value="librarian">Librarian</option>
      <option <?php if(isset($this->args['role']) && $this->args['role'] === 'moderator') echo 'selected'?> value="moderator">Moderator</option>
    </select>
    <?php
      if (isset($this->args['roleErrors'])) {
        echo '<div class="invalid-feedback">';
        foreach ($this->args['roleErrors'] as $error) echo '<div>' . $error . '</div>';
        echo '</div>';
      }
    ?>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary btn-block btn-lg" value="Register">
    <input type="hidden" name="register">
  </div>
  <div class="my-3">
    <a class="text-primary text-bold" href="login/login">Back to login</a>
    <a class="text-primary text-bold d-block float-right" href="login/forgot">Forgot password?</a>
  </div>
</form>