<?php

function validateComment($comment)
{
  $flag = true;
  if (empty($comment)) {
    $flag = false;
  }
  return $flag;
}
