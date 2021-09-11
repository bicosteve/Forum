<?php 

require_once '../db/db.php';

session_start();

if(!isset($_SESSION['username'])){
  header('location: login.php');
}

//deleting data from db
if(isset($_GET['delete'])){
  $postid = (int) trim($_GET['delete']);
  $userid = (int) $_SESSION['userid'];

  $stmt = $db->prepare("DELETE FROM posts WHERE posts.postid = ? AND posts.userid = ?");
  $result = $stmt->execute([$postid,$userid]);

  if($result){
    $_SESSION['message'] = 'Successfully deleted.';
    $_SESSION['msg_type'] = 'danger';
    header('location: index.php');
  } else {
    $_SESSION['message'] = 'Was not deleted';
    $_SESSION['msg_type'] = 'warning';
    header('location: thread.php');
    
  }
  
}