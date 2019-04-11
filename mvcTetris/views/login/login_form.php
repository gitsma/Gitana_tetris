<form action="login/login" method="post">
  <h1 class="text-primary hand-writen display-4 text-center">Login</h1>
  <div class="form-group">
    <i class="fa fa-user"></i>
    <input type="text" class="form-control" placeholder="Username" required="required" name="user">
  </div>
  <div class="form-group">
    <i class="fa fa-lock"></i>
    <input type="password" class="form-control" placeholder="Password" required="required" name="pass">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
    <input type="hidden" name="login">
  </div>
  <div class="my-3">
    <a class="text-primary text-bold" href="login/registerForm">Not Registerd?</a>
    <a class="text-primary text-bold d-block float-right" href="login/forgot">Forgot password?</a>
  </div>
</form>