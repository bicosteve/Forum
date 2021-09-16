<?php $currentPage = 'New Password'; ?>
<?php require_once 'includes/header.php' ?>


<?php 

require_once '../db/db.php';
require_once 'functions/registerfunc.php';

if(isset($_POST['create_new_password'])){
  $form_selector = $_POST['selector'];
  $form_validator = $_POST['validator'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];

  if(checkPassword($password) !== true){
    $password_error = "This is a required field";
  }

  if(checkPassword2($password2) !== true){
    $password2_error = "This is a required field";
  }

  if(comparePassword($password,$password2) !== true){
    $match_err = "The passwords do not match";
  }

  if(!isset($password_err) && !isset($password2_err) && !isset($match_err)){
    $current_date = date('U');
    
    $select_query = "SELECT * FROM password_reset WHERE reset_selector = ? AND reset_expire >= ?";
    $stmt = $db->prepare($select_query);
    $stmt->execute([$form_selector,$current_date]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row){
      $_SESSION['message'] = 'Expired token';
      $_SESSION['msg_type'] = 'warning';
      header('location: reset-password.php');
    } else {
      //converting token to binary data
      $binary_token = hex2bin( $form_validator);
      //token check,comparing db token with binary token.Returns boolean
      $token_check = password_verify($binary_token,$row['reset_token']);

      if(!$token_check){
        $_SESSION['message'] = 'Token failed. Submit another request';
        $_SESSION['msg_type'] = 'warning';
        header('location: reset-password.php');
      } elseif($token_check){
        $token_email = $row['reset_email'];
        $user_stmt = $db->prepare("SELECT username,email FROM users WHERE email = ?");
        $user_stmt->execute([$token_email]);
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);

        $hashed_password = password_hash($password,PASSWORD_DEFAULT);

        $update_stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update_stmt->execute([$hashed_password,$token_email]);
        $_SESSION['message'] = 'Succesfully changed password';
        $_SESSION['msg_type'] = 'success';
        header('location: login.php');
      } else {
        $_SESSION['message'] = 'Something went wrong. Try again';
        $_SESSION['msg_type'] = 'warning';
        header('location: index.php');
      } 
    }
  } 
}
?>

<div class="container-fluid">
  <div class="row">
    <?php
    $selector = $_GET['selector'];
    $validator = $_GET['validator'];
    ?>

    <?php if(empty($selector) || empty($validator)): ?>
    <p style="color: red; text-align:center;"> We cannot validate your requrest </p>
    <?php else: ?>
    <?php if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false): ?>
    <div class="col-lg-4 col-lg-offset-4" id="loginBlock">
      <div class="logo">
        <div>
          <a href="index.php">Forum</a>
        </div>
      </div>
      <div class="pageTitle">New Password</div>
      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="new_password.php" method="POST" role="form">
            <input type="hidden" name="selector" value="<?php echo $selector; ?>">
            <input type="hidden" name="validator" value="<?php echo $validator; ?>">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" />
              <?php echo isset($password_err)?"<span class='text-danger'>{$password_err}</span>":"" ?>
            </div>

            <div class="form-group">
              <label for="password">Confirm Password</label>
              <input type="password" name="password2" id="password" class="form-control"
                placeholder="Confirm password" />
              <?php echo isset($password2_err)?"<span class='text-danger'>{$password2_err}</span>":"" ?>
              <?php echo isset($match_err)?"<span class='text-danger'>{$match_err}</span>":"" ?>
            </div>
            <div class="form-group">
              <button name="create_new_password" type="submit" class="btn btn-primary">
                Reset Password <i class="glyphicon glyphicon-arrow-right"></i>
              </button>
              <a href="login.php" class="btn btn-link pull-right">
                <i class="glyphicon glyphicon-plus-sign"></i> Login
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php require_once 'includes/footer.php' ?>