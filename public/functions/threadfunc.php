<?php

function validatePost($post)
{
  $flag = true;
  if (empty($post)) {
    $flag = false;
  }

  return $flag;
}


function validateDescription($description)
{
  $flag = true;
  if (empty($description)) {
    $flag = false;
  }

  return $flag;
}
