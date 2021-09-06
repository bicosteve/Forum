<?php $currentPage = 'Home'; ?>


<?php 

require_once '../db/db.php';
require_once 'functions/threadfunc.php';

session_start();

if(isset($_POST['submit']) == 'POST'){
  
  $post = trim($_POST['post']);
  $description = trim($_POST['description']);
  $post_date = date('Y-m-d');
  $userid = (int) trim($_SESSION['userid']);

  if(validatePost($post) != true){
    $post_err = 'This field is required';
  }

  if(validateDescription($description)){
    $description_err = 'This field is required';
  }
  
  if(!isset($post_err) && !isset($description_err)){
    try{
      $sql = "INSERT INTO posts(post,description,post_date,userid) VALUES (:post,:description,:post_date,:userid)";
      $stmt = $db->prepare($sql);
      $stmt->execute(['post'=>$post,'description'=>$description,'post_date'=>$post_date,'userid'=>$userid]);
      
      $_SESSION['message'] = 'Successfully created';
      $_SESSION['msg_type'] = 'success';
    }catch(Exception $er){
      $err = $er->getMessage();
      if(isset($err)){
        echo $err;
      }
    }
  }
}

?>


<?php require_once 'includes/header.php'; ?>

<div class="container">
  <div class="row">
    <div class="col-lg-12 col-lg-offset-0">
      <div class="logo">
        <div>
          <a href="index.php">Forum</a>
          <span class="tagline">...cool community forum</span>
        </div>
      </div>
      <div class="menu">
        <a href="index.php" class="m-item">Home</a> |
        <?php if(isset($_SESSION['username'])): ?>
        <a href="profile.php" class="m-item">Profile</a> |
        <a href="logout.php" class="m-item">Logout</a> |
        <?php else: ?>
        <a href="login.php" class="m-item">Login</a> |
        <a href="register.php" class="m-item">Register</a>
        <?php endif; ?>
      </div>
      <div class="pageTitle">Threads</div>

      <div class="row">
        <div class="col-lg-3">
          <?php if(isset($_SESSION['username'])): ?>
          <a href="#newModal" data-toggle="modal" class="btn btn-primary" title="Add Thread">
            <i class="glyphicon glyphicon-plus-sign"></i> Add Thread
          </a>
          <?php else: ?>
          <a href="login.php" class="btn btn-primary">
            Login To Add Thread
          </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="row pad">
        <div class="col-lg-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-lg-4">Name</div>
                <div class="col-lg-4">Description</div>
                <div class="col-lg-4">Last Post</div>
              </div>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-4">
                  <h3 class="panel-title">
                    <a href="thread.php" style="font-size: 18px" class="blue">
                      General Thread
                    </a>
                  </h3>
                </div>
                <div class="col-lg-4">
                  <p>
                    <em> This thread is for sharing general information </em>
                  </p>
                </div>

                <div class="col-lg-4">
                  <p>
                    <i class="glyphicon glyphicon-calendar"></i>
                    26 June, 2017 &nbsp;
                    <a href="thread.php#_reply">
                      <i class="glyphicon glyphicon-comment"></i>
                      Reply
                    </a>
                  </p>
                </div>
              </div>
            </div>

            <div class="panel-body">
              <div class="row">
                <div class="col-lg-4">
                  <h3 class="panel-title">
                    <a href="thread.php" style="font-size: 18px" class="blue">
                      Games Thread
                    </a>
                  </h3>
                </div>
                <div class="col-lg-4">
                  <p>
                    <em> This thread is for game related discussions </em>
                  </p>
                </div>

                <div class="col-lg-4">
                  <p>
                    <i class="glyphicon glyphicon-calendar"></i>
                    26 June, 2017 &nbsp;
                    <a href="thread.php#_reply">
                      <i class="glyphicon glyphicon-comment"></i>
                      Reply
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="newModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
              </button>
              <h4 class="modal-title">Add Thread</h4>
            </div>
            <div class="modal-body">
              <form action="index.php" method="POST" role="form">
                <div class="form-group">
                  <label for="name">Thread Name</label>
                  <input type="text" name="post" id="name" class="form-control" placeholder="Enter thread name" />
                  <?php echo isset($post_err)?"<span class='text-danger'>{$post_err}</span>":"" ?>
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" name="description" id="description" cols="30" rows="10"
                    placeholder="Enter thread description"></textarea>
                  <?php echo isset($description_err)?"<span class='text-danger'>{$description_err}</span>":"" ?>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <footer>
        <div class="row">
          <div class="col-lg-12">
            <div class="center">
              Copyright &copy; <?php echo date('Y'); ?> Forum. All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php' ?>