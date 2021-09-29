<?php $currentPage = 'Register'; ?>
<?php require_once 'includes/header.php'; ?>

<?php
require_once '../db/db.php';
require_once 'functions/registerfunc.php';

if(isset($_SESSION['username'])){
  header('location:index.php');
}

if(isset($_POST['register']) == 'POST'){
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $password2 = trim($_POST['password2']);

  if(checkUsername($username) != true){
    $username_err = 'Required field and can only be letters and numbers.';
  }

  if(checkEmail($email) != true){
    $email_err = 'This field is required and must be email.';
  }

  if(checkPassword($password) != true){
    $password_err = 'This field is required.';
  }

  if(checkPassword2($password2) != true){
    $password2_err = 'This field is required.';
  }

  if(comparePassword($password,$password2) != true){
    $match_err = 'Passwords do not match';
  }

  if(!isset($username_err) && !isset($email_err) && !isset($password_err) && !isset($password2_err) && !isset($match_err)){
    try{
      $stmt = $db->prepare("SELECT email FROM users WHERE email=:email");
      $stmt->execute(['email'=>$email]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if($row && $row['email'] == $email){
        $register_err = "This email is taken";
      }

      if(!isset($register_err)){
        $hashed_password = password_hash($password,PASSWORD_DEFAULT);
        $today = date("Y-m-d");
        $query = "INSERT INTO users(username,email,join_date,password) VALUES (:username,:email,:join_date,:password)";
        $insert_stmt = $db->prepare($query);
        $arr = ['username'=>$username,'email'=>$email,'join_date'=>$today,'password'=>$hashed_password];
        $insert_stmt->execute($arr);
        $_SESSION['message'] = 'Successfully registered';
        $_SESSION['msg_type'] = 'success';
        header('refresh:1; login.php');
      } else {
        $_SESSION['message'] = 'Fail to register';
        $_SESSION['msg_type'] = 'danger';

      }
    }catch(Exception $e){
      $err = $e->getMessage();
      if(isset($err)){
        echo $err;
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
      <div class="pageTitle">Register</div>
      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="register.php" method="POST" role="form">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" />
              <?php echo isset($username_err)?"<span class='text-danger'>{$username_err}</span>":"" ?>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" />
              <?php echo isset($email_err)?"<span class='text-danger'>{$email_err}</span>":"" ?>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" />
              <?php echo isset($password_err)?"<span class='text-danger'>{$password_err}</span>":"" ?>
            </div>

            <div class="form-group">
              <label for="password2">Confirm Password</label>
              <input type="password" name="password2" id="password2" class="form-control"
                placeholder="Confirm password" />
              <?php echo isset($password2_err)?"<span class='text-danger'>{$password2_err}</span>":"" ?>
              <?php echo isset($match_err)?"<span class='text-danger'>{$match_err}</span>":"" ?>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="register">
                Register <i class="glyphicon glyphicon-arrow-right"></i>
              </button>
              <a href="login.php" class="btn btn-link pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> Go to
                Login
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php require_once 'includes/footer.php' ?>