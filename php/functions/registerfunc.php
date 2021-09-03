<?php
function checkUsername($username){
  $flag = true;
  if(empty($username) && !preg_match('/^[a-zA-Z0-9]*$/',$username)){
    $flag = false;
  } 
  return $flag;
}

function checkEmail($email){
  $flag = true;
  if(empty($email) && !filter_var($email,FILTER_VALIDATE_EMAIL) ){
    $flag = false;
  } 
  return $flag;
}

function checkPassword($password){
  $flag = true;
  if(empty($password)){
    $flag = false;
  }
  return $flag;
}

function checkPassword2($password2){
  $flag = true;
  if(empty($password2)){
    $flag = false;
  }
  return $flag;
}

function comparePassword($password,$password2){
  $flag = true;
  if($password !== $password2){
    $flag = false;
  }
  return $flag;
}

?>