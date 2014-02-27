<?php
session_start();
include_once('lib/class.database.php');

$db = new databaseLocal();

$n = $_GET["count"];
if ($n=='')
  $n = 5;

$db->query("SELECT * FROM patch WHERE featured=1 ORDER BY rand() LIMIT 0, ".mysql_real_escape_string($n));
$ret = array();
while ($db->next_record()) {
  $patch = array(
    'title' => $db->get("name"),
    'author' => $db->get("author"),
    'image' => "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/screenshot.php?id=".$db->get("hash"),
    'url' => "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/show.php?id=".$db->get("hash")
  );
  $ret[] = $patch;
}

echo json_encode(array('patches' => $ret));
?>