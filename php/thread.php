<?php $currentPage = 'Thread'; ?>
<?php 
require_once '../db/db.php';
require_once 'functions/commentfunc.php';

session_start();

$query = 'SELECT posts.userid, post,description,post_date,username,users.userid FROM posts INNER JOIN users ON posts.userid = users.userid ORDER BY post_date DESC';
$stmt = $db->query($query);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($allPosts);


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
              <p class="big"><?php echo $post['post']; ?></p>
            </div>
            <div class="col-lg-12 mb-2">
              <?php echo $post['description']; ?>
            </div>
            <div class="col-lg-12 my-2">
              <span class="mr-3"><i class="glyphicon glyphicon-user"></i> <a href="profile.php"
                  class="user_profile"><?php echo $post['username']; ?>
                </a></span>
              <small class="text-muted"> : <?php echo $post['post_date']; ?></small>
              <?php if(isset($_SESSION['userid']) == $post['userid']): ?>
              &nbsp;
              <a href="#_reply"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
              &nbsp;
              <a href="#_reply"><i class="glyphicon glyphicon-remove"></i> Delete</a>
              <?php else: ?>
              &nbsp;
              <a href="#_reply"><i class="glyphicon glyphicon-comment"></i> Reply</a>
              <?php endif; ?>
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

  <h3 class="">Replies &mdash; (2 total)</h3>

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
  <div class="panel panel-primary reply" id="r2" style="border-radius: 10px">
    <div class="panel-body">
      <div class="row reply">
        <div class="col-lg-9">
          <div class="reply-msg">So do I :-)</div>
        </div>
        <div class="col-lg-3">
          <div class="reply-details">
            <i class="glyphicon glyphicon-calendar"></i> 23 June, 2017 &nbsp; <br />
            <i class="glyphicon glyphicon-user"></i> Quentin Lance
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
          <form action="" method="POST" role="form" id="theForm">
            <div class="form-group">
              <textarea name="comment" id="reply" class="form-control" rows="5" required="required"
                placeholder="Post Reply"></textarea>
              <?php echo isset($comment_err)?"<span class='text-danger'>{$comment_err}</span>":"" ?>
            </div>
            <button type="submit" class="btn btn-primary" name="comment">
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