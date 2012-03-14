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
<link rel="stylesheet" type="text/css" href="index.css"/>
<link rel="stylesheet" type="text/css" href="show.css"/>
<script language="JavaScript" src="vvvv_js/lib/jquery/jquery-1.7.1.min.js"></script> 
<script language="JavaScript" src="vvvv_js/vvvv.js"></script>
<script language="VVVV" src="patch.v4p.php?id=<?= $id ?>"></script>
<script language="JavaScript" src="show.js"></script>
</head>
<body>
  
<div id="menu_bar">
  <a href="index.php" class="page_title">VVVV.js <span>Lab</span></a>
  <div id="controls">
    <a href="#" id="showpatch">Show Patch</a>
    <a href="#edit" id="edit">Sync to VVVV + Edit</a>
    <a href="#" id="open_save_shelf" class="disabled">Save As ...</a>
  </div>
</div>

<div id="shelf">
  <form action="index.php" method="post" id="new_form">
    <input type="hidden" name="action" value="create"/>
    <input type="hidden" name="patch[parent_id]" value="<?= $id ?>"/>
    <textarea id="xml" name="patch[xml]"></textarea>
    <textarea id="screenshot_data" name="patch[screenshot]"></textarea>
    <img src="img/placeholder.png" id="screenshot_image"/>
    <label>Title</label><input class="text" type="text" name="patch[name]"/>
    <label>Your Name</label><input class="text" type="text" name="patch[author]"/>
    <input class="button" type="button" id="save" value="Save"/>
    <input class="button" type="button" id="cancel" value="Cancel"/>
  </form>
</div>

<h1><?= $name ?></h1>

<div id="patch"></div>

</body>
</html>