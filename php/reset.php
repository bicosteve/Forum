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
      <div class="pageTitle">Reset Password</div>
      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="" method="POST" role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email address "
                required="required" autofocus />
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Send Request <i class="glyphicon glyphicon-arrow-right"></i>
              </button>
              <a href="login.php" class="btn btn-link pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> Go to
                Login
              </a>
            </div>
          </form>
        </div>
      </div>
      <?php require_once 'includes/footer.php' ?>