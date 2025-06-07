<?php $currentPage = 'Reset Password'; ?>
<?php require_once './includes/header.php'; ?>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../db/db.php';
require_once 'functions/loginfunc.php';
require_once 'includes/config.php';

if (isset($_SESSION['username'])) {
  header('location: index.php');
}

if (isset($_POST['reset'])) {
  try {
    $email = trim($_POST['email']);
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = $app_url . "new_password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date('U') + 1800;

    if (validateEmail($email) != true) {
      $incorrect_email = "This field is required & must be a valid email";
    }

    if (!isset($incorrect_email)) {
      $stmt = $db->prepare("SELECT email FROM forum_users WHERE email = ?");
      $stmt->execute([$email]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$row) {
        $email_err = 'Incorrect user. Create an account to continue';
      }
    }

    if (!isset($email_err) && !isset($incorrect_email)) {
      try {
        //deleting existing token
        $delete_stmt = $db->prepare("DELETE FROM password_reset WHERE reset_email = ?");
        $result = $delete_stmt->execute([$email]);

        if (!$result) {
          $_SESSION['message'] = "Query failed";
          $_SESSION['msg_type'] = "danger";
          exit();
        }

        $query = "INSERT INTO password_reset(reset_email,reset_selector,reset_token,reset_expire) VALUES(?,?,?,?)";
        $hashed_token = password_hash($token, PASSWORD_DEFAULT);
        $insert_stmt = $db->prepare($query);
        $r = $insert_stmt->execute([$email, $selector, $hashed_token, $expires]);

        if (!$r) {
          $_SESSION['message'] = "Failed  to set token";
          $_SESSION['msg_type'] = 'danger';
          exit();
        }
        //mail config
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.mail.yahoo.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Username = $user_email;
        $mail->Password = $user_password;

        $mail->From = $user_email;
        $mail->FromName = 'Forum App';
        $mail->AddAddress($email, "$email");
        $mail->IsHTML(true);

        //Email body
        $mail->Subject = 'Reset Your Password For Forum App';
        $mail->Body    = 'You made a password reset request? Here is a link to your password reset' . '<a href="' . $url . '">' . $url . '</a>' . '<p>Ignore if you did not make the request';
        $mail->AltBody = 'This is a password reset request. Ignore if you did not make the request';

        if (!$mail->Send()) {
          $_SESSION['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
          $_SESSION['msg_type'] = 'danger';
          exit();
        } else {
          $_SESSION['message'] = 'Reset mail has been sent';
          $_SESSION['msg_type'] = 'success';
          header('location: login.php');
        }
      } catch (Exception $er) {
        echo "Email could not be sent. Mailer error {$mail->ErrorInfo}";
      }
    }
  } catch (Exception $er) {
    $error = $er->getMessage();
    if (isset($error)) {
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
      <div style="text-align: center; margin:0;padding:5px;">
        <p style="font-size: 110%; color:grey;">Check your mail for a password reset link.</p>
      </div>
      <div class="row pad">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="" method="POST" role="form">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" name="email" id="email" class="form-control" placeholder="Enter email address " />
              <?php echo isset($email_err) ? "<span class='text-danger'>{$email_err}</span>" : "" ?>
              <?php echo isset($incorrect_email) ? "<span class='text-danger'>{$incorrect_email}</span>" : "" ?>
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