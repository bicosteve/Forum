<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="/public/img/discussion.png">
  <title>Forum | <?php echo $currentPage; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/public/css/styles.css" />
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