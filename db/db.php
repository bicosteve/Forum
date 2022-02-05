<?php

// LOCAL DB CONFIG
// $hostname = 'localhost';
// $dbname = 'forum_db';
// $dbusername = 'root';
// $dbpassword = '';


//REMOTE DB CONFIG
$hostname = 'remotemysql.com';
$dbname = 'Zr5yUPFBDe';
$dbusername = 'Zr5yUPFBDe';
$dbpassword = 'YYaSIfGn39';

$db_source = "mysql:host=$hostname;dbname=$dbname";

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

try {
  $db = new PDO($db_source, $dbusername, $dbpassword, $options);
} catch (Exception $e) {
  $error = $e->getMessage();
  $code = (int)$e->getCode();
  echo $error . ' - ' . $code;
}
