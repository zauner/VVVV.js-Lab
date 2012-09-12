<?php

include_once('lib/class.database.php');

$hash = mysql_real_escape_string($_REQUEST["id"]);

$db = new databaseLocal();
$db->query("SELECT * FROM patch WHERE hash='$hash'");
$db->next_record();

echo $db->get("xml");

?>