<?php $currentPage = 'Profile'; ?>
<?php require_once 'includes/header.php'; ?>

<?php
require_once '../db/db.php';

if(!isset($_SESSION['username'])){
  header('location: login.php');
}

if(isset($_GET['profile'])){
  try{
    $userid = (int) $_GET['profile'];
    $stmt = $db->prepare("SELECT userid,username,email,join_date FROM users WHERE userid = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch();

    $count = $db->prepare("SELECT COUNT(*) AS userposts FROM posts WHERE posts.userid = ?");
    $count->execute([$userid]);
    $posts = $count->fetch();
  }catch(Exception $er){
    $error = $er->getMessage();
    if(isset($error)){
      echo $error;
    }
  }
} else {
  try{
    $userid = (int) $_SESSION['userid'];
    $stmt = $db->prepare("SELECT userid,username,email,join_date FROM users WHERE userid = ?");
    $stmt->execute([$userid]);
    $user = $stmt->fetch();

    $count = $db->prepare("SELECT COUNT(*) AS userposts FROM posts WHERE posts.userid = ?");
    $count->execute([$userid]);
    $posts = $count->fetch();
  }catch(Exception $er){
    $error = $er->getMessage();
    echo $error;
  }
}

?>

<div class="pageTitle"><?php echo ucfirst($user['username']); ?></div>
<div class="row pad">
  <div class="col-sm-6 col-sm-offset-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">My Info</h3>
      </div>
      <div class="panel-body">Below are my basic info</div>
      <ul class="list-group">
        <li class="list-group-item">
          Name:
          <strong class="pull-right"><?php echo ucfirst($user['username']); ?></strong>
        </li>
        <li class="list-group-item">
          Email:
          <strong class="pull-right"><?php echo $user['email']; ?></strong>
        </li>
        <li class="list-group-item">
          Username: <strong class="pull-right"><?php echo $user['username']; ?></strong>
        </li>
        <li class="list-group-item">
          <?php if(!$posts): ?>
          Num of Posts: <strong class="pull-right"><?php echo 0; ?></strong>
          <?php else: ?>
          Num of Posts: <strong class="pull-right"><?php echo $posts['userposts']; ?></strong>
          <?php endif; ?>
        </li>
        <li class="list-group-item">
          Join Date:
          <strong class="pull-right"><?php echo $user['join_date']; ?></strong>
        </li>
        <!-- <li style="margin:10px 0;" class="list-group-item btn btn-primary">
          <a style="padding:10px 0;" class="pull-right">
            <a style="text-decoration:none; text-align:center; padding-bottom:10px;" href="index.php"
              class="pull-right">Home</a>
          </a>
        </li> -->
      </ul>

    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>