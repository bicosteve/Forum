<?php $currentPage = 'Reset Password'; ?>
<?php require_once 'includes/header.php'; ?>


<?php
require_once '../db/db.php';
require_once 'functions/loginfunc.php';

if(isset($_SESSION['username'])){
  header('location: index.php');
}

if(isset($_POST['reset'])){
  try{
    $email = trim($_POST['email']);

    if(validateEmail($email) != true){
      $incorrect_email = "This field is required & must be a valid email";
    }

    if(!isset($incorrect_email)){
      $stmt = $db->prepare("SELECT email FROM users WHERE email = ?");
      $stmt->execute([$email]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if(!$row){
        $email_err = 'Incorrect user!';
      }
    }

    if(!isset($email_err)){
      try{
        $mail->addAddress($email);
        $mail->isHTML();
        $mail->Subject = "Sending from Forum App";
        $mail->Body = "You tried to chage your password";
        if($mail->send()){
          echo "Email sent";
        }else{
          echo "Sorry something went wrong";
        } 
      }catch(Exception $er){
        echo "Email could not be sent. Mailer error {$mail->ErrorInfo}";
      }
    }

  }catch(Exception $er){
    $error = $er->getMessage();
    if(isset($error)){
      echo $error;
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
      <div class="pageTitle">Reset Password</div>
      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="" method="POST" role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email address " />
              <?php echo isset($email_err)?"<span class='text-danger'>{$email_err}</span>":"" ?>
              <?php echo isset($incorrect_email)?"<span class='text-danger'>{$incorrect_email}</span>":"" ?>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary" name="reset">
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