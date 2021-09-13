<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../static/img/discussion.png">
  <title>Forum | <?php echo $currentPage; ?></title>
  <link rel="stylesheet" href="../static/bs/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../static/css/styles.css" />
</head>

<body>
  <?php session_start(); ?>
  <?php if(isset($_SESSION['message'])): ?>
  <div style="margin-top: 10px; text-align:center;" class="row">
    <div class="col-lg-4 col-lg-offset-4">
      <div class="alert alert-<?=$_SESSION['msg_type']; ?>">
        <?php 
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        ?>
      </div>
    </div>
  </div>
  <?php endif ?>

  <?php
  
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require_once '../vendor/autoload.php';
  require_once 'config.php';

  $mail = new PHPMailer();

  $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username   = $user_email;                    
  $mail->Password   = $user_password;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
  $mail->Port = 465;

  $mail->setFrom($user_email);
  $mail->addReplyTo("no-reply@bico.com");

  