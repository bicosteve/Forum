<?php

require_once '../db/db.php';

if(isset($_GET['one_post'])){
  $postid = (int) $_GET['one_post'];
  try{
    $stmt = $db->prepare("SELECT postid,post,description,post_date,posts.userid,username FROM posts INNER JOIN users ON users.userid = posts.userid WHERE postid = ?");
    $stmt->execute([$postid]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($post);
  }catch(Exception $er){
    if(isset($er)){
      echo $er->getMessage();
    }
  }

  try{
    $comment_query = "SELECT comments.commentid, comments.userid, comment,comment_date,username FROM comments INNER JOIN users ON users.userid = comments.userid WHERE comments.postid = ?";
    $statement = $db->prepare($comment_query);
    $statement->execute([$postid]);
    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);  
  }catch(Exception $er){
    if(isset($er)){
      echo $er->getMessage();
    }
  }

  try{
    $count_comments_query = "SELECT comments.postid,COUNT(*) AS comment_count FROM comments WHERE comments.postid = :postid GROUP BY comments.postid"; 
    $counts = $db->prepare($count_comments_query);
    $counts->execute(['postid'=>$postid]);
    $row = $counts->fetch(PDO::FETCH_ASSOC);
  }catch(Exception $er){
    $error = $er->getMessage();
    if(isset($error)){
      echo $error;
    }
  }
 
}

?>

<?php if($post): ?>
<?php $currentPage = $post['post']; ?>
<?php require_once 'includes/header.php'; ?>
<div class="container" style="padding-bottom: 8px;">
  <div class="pageTitle">
    <a href="#"><?php echo $post['post']; ?></a>
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
              <p class="big">Thread: <?php echo $post['post']; ?></p>
            </div>
            <div class="col-lg-12">
              <?php echo $post['description']; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($row): ?>
  <small style="display:block;margin: 3px 0;" class="text-muted"> <?php echo $row['comment_count']; ?>
    &#9679;
    Comment(s)</small>
  <?php else: ?>
  <small style="display:block;margin: 3px 0;" class="text-muted"> <?php echo 0; ?> &#9679;
    Comment(s)</small>
  <?php endif; ?>

  <?php if($comments): ?>
  <?php foreach($comments as $comment): ?>
  <div class="panel panel-primary reply" id="r1" style="border-radius: 10px">
    <div class="panel-body">
      <div class="row reply">
        <div class="col-lg-9">
          <div class="reply-msg"><?php echo $comment['comment']; ?></div>
        </div>
        <div class="col-lg-3">
          <div class="reply-details">
            <i class="glyphicon glyphicon-calendar"></i> <?php echo $comment['comment_date']; ?> &nbsp; <br />
            <i class="glyphicon glyphicon-user"></i> <?php echo $comment['username']; ?> &nbsp; <br />
            <?php if(isset($_SESSION['userid']) && $_SESSION['userid'] == $comment['userid']): ?>
            <i style="color: red;" class="glyphicon glyphicon-trash"></i> <a style="color: red;"
              href="delete.php?remove=<?php echo $comment['commentid'];  ?>">Delete</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <?php else: ?>
  <p style="text-align: center;">No comments yet.</p>
  <?php endif; ?>
  <?php if(isset($_SESSION['userid'])): ?>
  <a href="comment.php?comment_post=<?php echo $post['postid']; ?>" class="btn btn-primary">
    Add First Comment
  </a>
  <?php else: ?>
  <a href="login.php" class="btn btn-primary">
    Login To Comment
  </a>
  <?php endif; ?>
</div>
<?php require_once 'includes/footer.php' ?>
<?php else: ?>
<p style="text-align: center;">Post does not exist</p>
<?php endif ?>