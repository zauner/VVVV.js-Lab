<?php

header('Content-type: application/octest-stream');
include_once('lib/class.database.php');

$db = new databaseLocal();
$hash = mysql_real_escape_string($_REQUEST["id"]);
$db->query("SELECT * FROM patch WHERE hash='$hash'");
$db->next_record();

echo $db->get("xml");

?>