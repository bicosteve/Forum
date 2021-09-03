<?php $currentPage = 'Login'; ?>
<?php 
require_once '../db/db.php';



?>
<?php require_once 'includes/header.php'; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-lg-offset-4" id="loginBlock">
      <div class="logo">
        <div>
          <a href="index.php">Forum</a>
        </div>
      </div>
      <div class="pageTitle">Login</div>

      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="" method="POST" role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email"
                required="required" autofocus />
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password"
                required="required" />
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Login <i class="glyphicon glyphicon-arrow-right"></i>
              </button>
              <a href="register.php" class="btn btn-link pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> Go to
                Register
              </a>
            </div>
            <div class="form-group">
              <a href="reset.php" class="btn btn-link">
                <i class="glyphicon glyphicon-plus-sign"></i> Forgot Password?
              </a>
            </div>
          </form>
        </div>
      </div>
      <?php require_once 'includes/footer.php' ?>