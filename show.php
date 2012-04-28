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
<title>VVVV.js Lab: <?= $name ?> by <?= $db->get("author") ?></title>
<link rel="image_src" href="screenshot.php?id=<?= $id ?>"/>
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
  <div id="social_buttons">
    <g:plusone size="tall" href="http://vvvvjs.quasipartikel.at/beta/lab/show.php?id=<?= $id ?>"></g:plusone><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode("http://vvvvjs.quasipartikel.at/beta/lab/show.php?id=$id"); ?>&amp;send=false&amp;layout=box_count&amp;width=60&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=60" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:60px;" allowTransparency="true"></iframe>
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