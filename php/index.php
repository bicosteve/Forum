<?php $currentPage = 'Home'; ?>
<?php require_once 'includes/header.php'; ?>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-lg-offset-0">
      <div class="logo">
        <div>
          <a href="./">Forum</a>
          <span class="tagline">...cool community forum</span>
        </div>
      </div>
      <div class="menu">
        <a href="index.php" class="m-item">Home</a> |
        <a href="profile.php" class="m-item">Profile</a> |
        <a href="login.php" class="m-item">Logout</a>
      </div>
      <div class="pageTitle">Thread Listing</div>

      <div class="row">
        <div class="col-lg-3">
          <a href="#newModal" data-toggle="modal" class="btn btn-primary" title="Add Thread">
            <i class="glyphicon glyphicon-plus-sign"></i> Add Thread
          </a>
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
              <form action="" method="POST" role="form">
                <div class="form-group">
                  <label for="name">Thread Name</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Enter thread name"
                    required="required" />
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" name="description" id="description" cols="30" rows="10"
                    placeholder="Enter thread description" required="required"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
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
              Copyright &copy; 2017 Forum. All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php' ?>