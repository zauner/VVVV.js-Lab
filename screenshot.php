<?php
header('Content-Type: image/png');

include_once('lib/class.database.php');

$hash = mysql_real_escape_string($_REQUEST["id"]);

$db = new databaseLocal();
$db->query("SELECT screenshot FROM patch WHERE hash='$hash'");
$db->next_record();
$data = explode(';', $db->get("screenshot"));
$data = explode(',', $data[1]);
$data = $data[1];

echo base64_decode($data);



?>