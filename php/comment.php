<?php $currentPage = "Comment"; ?>
<?php require_once 'includes/header.php' ?>

<?php
require_once '../db/db.php';

if(!isset($_SESSION['userid'])){
  header('location: login.php');
}

if(isset($_GET['comment_post'])){
try{
    $postid = (int) $_GET['comment_post'];
    $q = "SELECT postid, post,post_date,description,posts.userid,username FROM posts INNER JOIN users ON users.userid = posts.userid WHERE postid = ?";
    $stmt = $db->prepare($q);
    $stmt->execute([$postid]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
  }catch(Exception $er){
    $error = $er->getMessage();
  }
}


//submitting comments to db
if(isset($_POST['submit']) == 'POST'){
  $comment = trim($_POST['comment']);
  $postid = (int) $_POST['post_id'];
  $userid = (int) $_SESSION['userid'];
  $today = date('Y-m-d');

  if(empty($comment)){
    $comment_err = "This field is required";
  }

  if(!isset($comment_err)){
    try{
      $query = "INSERT INTO comments(comment,userid,postid,comment_date) VALUES (?,?,?,?)";
      $stmt = $db->prepare($query);
      $stmt->execute([$comment,$userid,$postid,$today]);

      $_SESSION['message'] = "Succefully commented";
      $_SESSION['msg_type'] = 'success';

      header('location: thread.php');

    }catch(Exception $er){
      $error = $er->getMessage();
      if(isset($error)){
        echo $error;
      }
    }
  } else {
    $_SESSION['message'] = "Failed to comment";
    $_SESSION['msg_type'] = 'danger';
  }

}

?>

<div class="container">
  <div class="pageTitle">
    <a href=""><?php echo $post['post']; ?></a>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <a href="index.php" class="btn btn-default btn-sm">
        <i class="glyphicon glyphicon-arrow-left"></i> Back to Threads
      </a>
    </div>
  </div>

  <div class="row pad">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <span class="mr-3"><i class="glyphicon glyphicon-user"></i> <a
                  href="profile.php?profile=<?php echo $post['userid']; ?>"
                  class="user_profile"><?php echo $post['username']; ?>
                </a></span>
              <small class="text-muted"> &#9679; <?php echo $post['post_date']; ?></small>
            </div>
            <div class="col-lg-12">
              <p class="big"><?php echo $post['post']; ?></p>
            </div>
            <div class="col-lg-12">
              <?php echo $post['description']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row pad">
    <div class="col-lg-12 pad">
      <div class="panel panel-primary">
        <div class="panel-heading big">
          <i class="glyphicon glyphicon-comment"></i> Post Reply
        </div>
        <div class="panel-body pad" id="_reply">
          <form action="comment.php" method="POST" role="form" id="theForm">
            <input type="hidden" name="post_id" value="<?php echo $post['postid']; ?>">
            <div class="form-group">
              <textarea name="comment" id="reply" class="form-control" rows="5" placeholder="Post Reply"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">
              <i class="glyphicon glyphicon-save"></i> Submit
            </button>
            &nbsp;
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php' ?>