<?php

//development connection
// $db_host = "localhost";
// $db_username = 'root';
// $db_password = '';
// $db_name = 'forum_app';

//remote db connection
$db_host = ' sql11.freemysqlhosting.net';
$db_name = 'sql11440970';
$db_username = 'sql11440970';
$db_password = 'D6RqVCPrl6';
$charset = 'utf8mb4';

//db source
$db_source = "mysql:host=$db_host;dbname=$db_name;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES=>false
];

try{
  $db = new PDO($db_source,$db_username,$db_password,$options);
}catch(PDOException $e){
  $error = $e->getMessage();
  $code = (int)$e->getCode();
  echo $error .' - '.$code;
}