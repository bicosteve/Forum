<?php 

require_once '../db/db.php';

session_start();

if(!isset($_SESSION['username'])){
  header('location: login.php');
}

if(isset($_GET['delete'])){
  try{
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
  } catch(Exception $er){
    $error = $er->getMessage();
    if(isset($error)){
      echo $error;
    }
  }
  
}


if(isset($_GET['remove'])){
  $commentid = (int) trim($_GET['remove']);
  $userid = (int) $_SESSION['userid'];

  $statement = $db->prepare("DELETE FROM comments WHERE comments.commentid = ? AND comments.userid = ?");
  $success = $statement->execute([$commentid,$userid]);

  if($success){
    $_SESSION['message'] = "Successfully deleted";
    $_SESSION['msg_type'] = 'danger';
    header('location: thread.php');
  } else {
    $_SESSION['message'] = "Was not deleted";
    $_SESSION['msg_type'] = 'warning';
  }

}