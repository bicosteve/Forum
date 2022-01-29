<?php $currentPage = 'Login'; ?>
<?php require_once 'includes/header.php'; ?>


<?php
require_once '../db/db.php';
require_once 'functions/loginfunc.php';


if (isset($_SESSION['username'])) {
  header('location:index.php');
}

if (isset($_POST['login']) == 'POST') {

  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  if (validateEmail($email) != true) {
    $email_err = 'This field is required and must be an email.';
  }

  if (validatePassword($password) != true) {
    $password_err = 'This field is required';
  }

  if (!isset($email_err) && !isset($password_err)) {
    try {
      $stmt = $db->prepare("SELECT * FROM forum_users WHERE email=:email");
      $stmt->execute(['email' => $email]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$row) {
        $user_err = 'Incorrect user or password!';
      }

      if (!isset($user_err)) {
        if ($email == $row['email'] && password_verify($password, $row['password'])) {
          $_SESSION['userid'] = $row['userid'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['message'] = 'You are logged in';
          $_SESSION['msg_type'] = 'success';
          header('location: index.php');
        } else {
          $login_err = 'Incorrect password or email';
        }
      }
    } catch (Exception $e) {
      $error = $e->getMessage();
      if (isset($error)) {
        echo $error;
      }
    }
  }
}

?>


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
          <form action="login.php" method="POST" role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" />
              <?php echo isset($email_err) ? "<span class='text-danger'>{$email_err}</span>" : "" ?>
              <?php echo isset($user_err) ? "<span class='text-danger'>{$user_err}</span>" : "" ?>
              <?php echo isset($login_err) ? "<span class='text-danger'>{$login_err}</span>" : "" ?>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" />
              <?php echo isset($password_err) ? "<span class='text-danger'>{$password_err}</span>" : "" ?>
              <?php echo isset($login_err) ? "<span class='text-danger'>{$login_err}</span>" : "" ?>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="login">
                Login <i class="glyphicon glyphicon-arrow-right"></i>
              </button>
              <a href="register.php" class="btn btn-link pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> Go to
                Register
              </a>
            </div>
            <div class="form-group">
              <a href="reset-password.php" class="btn btn-link">
                <i class="glyphicon glyphicon-plus-sign"></i> Forgot Password?
              </a>
            </div>
          </form>
        </div>
      </div>
      <?php require_once 'includes/footer.php' ?>