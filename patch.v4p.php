<?php

include_once('lib/class.database.php');

$id = intval($_REQUEST["id"]);

$db = new databaseLocal();
$db->query("SELECT * FROM patch WHERE id=$id");
$db->next_record();

echo $db->get("xml");

?>