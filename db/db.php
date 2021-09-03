<?php
$db_source = "mysql:host=localhost;dbname=forum_db";
$options = [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES=>false
];

try{
  $db = new PDO($db_source,"root","",$options);
}catch(Exception $e){
  $error = $e->getMessage();
  $code = (int)$e->getCode();
  echo $error .' - '.$code;
}