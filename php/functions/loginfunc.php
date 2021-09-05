<?php

function validateEmail($email){
  $flag = true;
  if(empty($email) && !filter_var($email,FILTER_VALIDATE_EMAIL)){
    $flag = false;

  }
  return $flag;
}

function validatePassword($password){
  $flag = true;
  if(empty($password)){
    $flag = false;
  }
  return $flag;
}