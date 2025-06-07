<?php $currentPage = 'Thread'; ?>
<?php require_once 'includes/header.php'; ?>

<?php
require_once '../db/db.php';
require_once 'functions/commentfunc.php';

//getting all posts
try {
  $query = 'SELECT posts.userid,postid, post,description,post_date,username,email,forum_users.userid
  FROM posts INNER JOIN forum_users ON posts.userid = forum_users.userid ORDER BY post_date DESC';
  $stmt = $db->query($query);
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $er) {
  $err = $er->getMessage();
  if (isset($err)) {
    echo $err;
  }
}

?>

<div class="container">
  <div class="pageTitle">
    <a href="index.php">General Thread</a>
  </div>
  <div class="row">
    <div class="col-lg-4">
      <a href="index.php" class="btn btn-default btn-sm">
        <i class="glyphicon glyphicon-arrow-left"></i> Back to Threads
      </a>
    </div>
  </div>

  <?php if ($posts) : ?>
    <?php foreach ($posts as $post) : ?>
      <div class="row pad">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <span class="mr-3"><i class="glyphicon glyphicon-user"></i> <a href="profile.php?profile=<?php echo $post['userid']; ?>" class="user_profile"><?php echo $post['username']; ?>
                    </a></span>
                  <small class="text-muted"> &#9679; <?php echo $post['post_date']; ?></small>
                </div>
                <div class="col-lg-12">
                  <p class="big"><?php echo $post['post']; ?></p>
                </div>
                <div style="margin-bottom:5px;" class="col-lg-12 mb-3">
                  <?php echo $post['description']; ?>
                </div>
              </div>
              <?php if (isset($_SESSION['userid'])) : ?>
                <a style="margin-top: 5px;" href="comment.php?comment_post=<?php echo $post['postid'] ?>" class="btn btn-primary">
                  Comment
                </a>
              <?php else : ?>
                <a href="login.php" class="btn btn-primary">
                  Login To Reply
                </a>
              <?php endif; ?>
              <?php

              //getting all the comments for each post in db using postid
              try {
                $postid = (int) $post['postid'];
                $comment_query = "SELECT commentid,comment,comments.userid,comments.postid,comments.comment_date,username FROM comments INNER JOIN forum_users ON forum_users.userid = comments.userid WHERE comments.postid = :postid";
                $stmt = $db->prepare($comment_query);
                $stmt->execute(['postid' => $postid]);
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
              } catch (Exception $er) {
                $error = $er->getMessage();
                if (isset($error)) {
                  echo $error;
                }
              }
              ?>

              <?php
              // counting comments
              try {
                $count_comments_query = "SELECT comments.postid,COUNT(*) AS comment_count FROM comments WHERE comments.postid = :postid GROUP BY comments.postid";
                $stmt = $db->prepare($count_comments_query);
                $stmt->execute(['postid' => $postid]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              } catch (Exception $er) {
                $error = $er->getMessage();
                if (isset($error)) {
                  echo $error;
                }
              }
              ?>

              <?php if ($row) : ?>
                <small style="display:block;margin: 5px 0;" class="text-muted"> <?php echo $row['comment_count']; ?>
                  &#9679;
                  Comment(s)</small>
              <?php else : ?>
                <small style="display:block;margin: 5px 0;" class="text-muted"> <?php echo 0; ?> &#9679;
                  Comment(s)</small>
              <?php endif; ?>

              <?php if ($comments) : ?>
                <?php foreach ($comments as $com) : ?>
                  <div class="panel panel-primary reply" id="r1" style="border-radius: 10px">
                    <div class="panel-body">
                      <div class="row reply">
                        <div class="col-lg-9">
                          <div class="reply-msg"><?php echo $com['comment'] ?></div>
                        </div>
                        <div class="col-lg-3">
                          <div class="reply-details">
                            <i class="glyphicon glyphicon-calendar"></i> <?php echo $com['comment_date']; ?> &nbsp; <br />
                            <i class="glyphicon glyphicon-user"></i> <?php echo $com['username']; ?>
                            <?php if (isset($_SESSION['userid']) && (int) $_SESSION['userid'] == $com['userid']) : ?>
                              &nbsp; <br />
                              <a style="text-decoration: none; color:red;" href="delete.php?remove=<?php echo $com['commentid']; ?>">
                                <i style="color:red;" class="glyphicon glyphicon-trash"></i> Delete
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <p>No posts here yet</p>
  <?php endif; ?>
</div>
<?php require_once 'includes/footer.php' ?>