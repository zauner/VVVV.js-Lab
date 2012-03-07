<?php

include_once('lib/class.database.php');

$id = intval($_REQUEST["id"]);

$db = new databaseLocal();
$db->query("SELECT * FROM patch WHERE id=$id");
$db->next_record();
$name = $db->get("name");

?>

<html>
<head>
<title>VVVV.js Lab</title>
<link rel="stylesheet" type="text/css" href="vvvv_js/vvvviewer/vvvv.css"/>
<link rel="stylesheet" type="text/css" href="show.css"/>
<script language="JavaScript" src="vvvv_js/lib/jquery/jquery-1.4.2.min.js"></script> 
<script language="JavaScript" src="vvvv_js/vvvv.js"></script>
<script language="VVVV" src="patch.v4p.php?id=<?= $id ?>"></script>
<script language="JavaScript" src="show.js"></script>
</head>
<body>

<div id="controls">
  <a href="#" id="showpatch">Show Patch</a>
  <a href="#sync/patch.v4p.php?id=<?= $id ?>">Edit this patch</a>
  <a href="#" id="save">Save</a>
  <img src="" id="screenshot_image"/>
</div>

<h1><?= $name ?></h1>

<form action="index.php" method="post" id="new_form">
  <input type="hidden" name="action" value="create"/>
  <input type="hidden" name="parent_id" value="<?= $id ?>"/>
  <textarea id="xml" name="xml"></textarea>
  <textarea id="screenshot_data" name="screenshot_data"></textarea>
</form>

<div id="patch"></div>

</body>
</html>