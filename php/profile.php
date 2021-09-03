<?php $currentPage = 'Profile'; ?>
<?php require_once 'includes/header.php'; ?>
<!-- display the page title and the number of threads we got from the database -->
<div class="pageTitle">My Profile</div>

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
          <strong class="pull-right">Alexander McQuinn</strong>
        </li>
        <li class="list-group-item">
          Email:
          <strong class="pull-right">alexQnn@gmail.com</strong>
        </li>
        <li class="list-group-item">
          Username: <strong class="pull-right">alexQnn</strong>
        </li>
        <li class="list-group-item">
          Num of Posts: <strong class="pull-right">23</strong>
        </li>
        <li class="list-group-item">
          Join Date:
          <strong class="pull-right">January 1, 2017</strong>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>