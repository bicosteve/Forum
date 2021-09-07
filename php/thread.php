<?php $currentPage = 'Thread'; ?>
<?php 
require_once '../db/db.php';
require_once 'functions/commentfunc.php';

session_start();

try{
  $query = 'SELECT posts.userid,postid, post,description,post_date,username,users.userid FROM posts INNER JOIN users ON posts.userid = users.userid ORDER BY post_date DESC';
  $stmt = $db->query($query);
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(Exception $er){
  $err = $er->getMessage();
  if(isset($err)){
    echo $err;
  }
}


if(isset($_POST['submit']) == 'POST'){
  $comment = trim($_POST['comment']);
  $postid = (int) trim($_POST['postid']);
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
      
      header('location:index.php');

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
<?php require_once 'includes/header.php'; ?>
<div class="container">
  <div class="pageTitle">
    <a href="">General Thread</a>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <a href="index.php" class="btn btn-default btn-sm">
        <i class="glyphicon glyphicon-arrow-left"></i> Back to Threads
      </a>
    </div>
  </div>

  <?php if($posts): ?>
  <?php foreach($posts as $post): ?>
  <div class="row pad">
    <div class="col-lg-12">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <span class="mr-3"><i class="glyphicon glyphicon-user"></i> <a href="profile.php"
                  class="user_profile"><?php echo $post['username']; ?>
                </a></span>
              <small class="text-muted"> &#9679; <?php echo $post['post_date']; ?></small>
            </div>
            <div class="col-lg-12">
              <p class="big"><?php echo $post['post']; ?></p>
            </div>
            <div style="margin-bottom:5px;" class="col-lg-12 mb-3">
              <?php echo $post['description']; ?>
            </div>
            <div class="col-lg-12">
              <?php if(isset($_SESSION['userid']) == $post['userid']): ?>
              &nbsp;
              <a href="#_reply"><i class="glyphicon glyphicon-pencil my-2"></i> Edit</a>
              &nbsp;
              <a href="#_reply"><i class="glyphicon glyphicon-remove my-2"></i> Delete</a>
              <?php endif; ?>
            </div>
          </div>
          <?php if(isset($_SESSION['userid'])): ?>
          <div class="row pad">
            <div class="col-lg-12 pad">
              <div class="panel panel-primary">
                <div class="panel-heading big">
                  <i class="glyphicon glyphicon-comment"></i> Post Reply
                </div>
                <div class="panel-body pad" id="_reply">
                  <input type="hidden" name="postid" value="<?php echo $post['postid']; ?>">
                  <form action="thread.php" method="POST" role="form" id="theForm">
                    <div class="form-group">
                      <textarea name="comment" id="reply" class="form-control" rows="5" required="required"
                        placeholder="Post Reply"></textarea>
                      <?php echo isset($comment_err)?"<span class='text-danger'>{$comment_err}</span>":"" ?>
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
          <?php else: ?>
          <a href="login.php" class="btn btn-primary">
            Login To Reply
          </a>
          <?php endif; ?>
          <small style="display:block;margin: 5px 0;" class="text-muted"> [ 2 ] &#9679;
            Replies</small>
          <div class="panel panel-primary reply" id="r1" style="border-radius: 10px">
            <div class="panel-body">
              <div class="row reply">
                <div class="col-lg-9">
                  <div class="reply-msg">I love this thread</div>
                </div>
                <div class="col-lg-3">
                  <div class="reply-details">
                    <i class="glyphicon glyphicon-calendar"></i> 26 June, 2017 &nbsp; <br />
                    <i class="glyphicon glyphicon-user"></i> Alexander McQuinn
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php else: ?>
  <p>No posts here yet</p>
  <?php endif; ?>
</div>
<?php require_once 'includes/footer.php' ?>