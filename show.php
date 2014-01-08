<?php
session_start();
include_once('lib/class.database.php');

$db = new databaseLocal();
$hash = mysql_real_escape_string($_REQUEST["id"]);
$db->query("SELECT * FROM patch WHERE hash='$hash'");
$db->next_record();
$name = $db->get("name");

if (preg_match('/^([^0-9]*)([0-9]+)$/', $name, $match)>0)
  $suggested_name = $match[1].($match[2]+1);
else
  $suggested_name = $name." #2";

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>VVVV.js Lab: <?= $name ?> by <?= $db->get("author") ?></title>
<link rel="image_src" href="http://<?= $_SERVER["SERVER_NAME"].dirname($_SERVER['SCRIPT_NAME']).'/'; ?>screenshot.php?id=<?= $hash ?>"/>
<meta property="og:image" content="http://<?= $_SERVER["SERVER_NAME"].dirname($_SERVER['SCRIPT_NAME']).'/'; ?>screenshot.php?id=<?= $hash ?>"/>
<meta property="og:title" content="VVVV.js Lab: <?= $name ?> by <?= $db->get("author") ?>"/>
<meta property="og:description" content="The VVVV.js Lab is a place to view, share and try VVVV.js patches."/>
<link rel="stylesheet" type="text/css" href="vvvv_js-26c779666/vvvviewer/vvvv.css"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
<link rel="stylesheet" type="text/css" href="show.css"/>
<script language="JavaScript" src="vvvv_js-26c779666/lib/jquery/jquery-1.8.2.min.js"></script>
<script language="JavaScript">
  if (!$.browser.webkit && !$.browser.mozilla) {
    location.href = "../notsupported.html"; 
  }
</script>
<script language="JavaScript" src="vvvv_js-26c779666/lib/underscore/underscore-min.js"></script>
<script language="JavaScript" src="vvvv_js-26c779666/lib/glMatrix-0.9.5.min.js"></script>
<script language="JavaScript" src="main.js"></script>
<script language="JavaScript" src="vvvv_js-26c779666/vvvv.min.js"></script>
<script language="JavaScript" src="vvvv_js-26c779666/lib/d3-v1.14/d3.min.js"></script>
<script language="VVVV" src="patch.v4p.php?id=<?= $hash ?>"></script>
<script language="JavaScript" src="show.js?b6875054sfs52"></script>
</head>
<body>
  
<img src="screenshot.php?id=<?= $hash ?>" style="display:none"/>
  
<div id="menu_bar">
  <a href="index.php" class="page_title">VVVV.js <span>Lab</span></a>
  <div id="controls">
    <a href="index.php">&lt; Index</a>
    <a href="#edit" id="edit">Edit Patch</a>
    <a href="#" id="open_save_shelf" class="disabled">Save As ...</a>
    <a href="#" class="open_help_shelf">Need Help?</a>
  </div>
  <div id="social_buttons">
    <g:plusone size="tall" href="http://<?= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ?>"></g:plusone><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
    <iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode("http://".$_SERVER['SERVER_NAME'].'/'.$_SERVER['REQUEST_URI']); ?>&amp;send=false&amp;layout=box_count&amp;width=60&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=60" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:60px;" allowTransparency="true"></iframe>
  </div>
</div>

<div class="shelf" id="save_shelf">
  <form action="index.php" method="post" id="new_form">
    <input type="hidden" name="action" value="create"/>
    <? if ($hash!=""): ?>
      <input type="hidden" name="patch[parent_id]" value="<?= $hash ?>"/>
    <? endif ?>
    <textarea id="xml" name="patch[xml]"></textarea>
    <textarea id="screenshot_data" name="patch[screenshot]"></textarea>
    <img src="img/placeholder.png" id="screenshot_image"/>
    <label>Title</label><input class="text" type="text" name="patch[name]", value="<?= $suggested_name ?>"/>
    <label>Your Name</label><input class="text" type="text" name="patch[author]" value="<?= $_SESSION["author"] ?>"/><span class="checkbox"><input type="checkbox" name="remember_name" value="1" checked="checked"/> Remember my name</span>
    <label>Public</label><span class="checkbox"><input type="checkbox" checked="checked" name="patch[public]" value="1"/> Yes, show this patch on the frontpage</span>
    <input class="button" type="button" id="save" value="Save"/>
    <input class="button close" type="button" value="Cancel"/>
  </form>
</div>

<div id="log_message">
  
</div>

<div class="shelf" id="help_shelf">
  <h2>Help</h2>
  <p>
    Here at the <b>VVVV.js lab</b>, you can <b>edit every VVVV.js patch in your browser</b> without any additional software, and <b>save it as a new revision</b>. Don't worry, you won't break or overwrite anything doing so.<br/>
  </p>
  <p>
    Just hit the <b>"Edit Patch" button</b> and the patch will open in a new window. Make sure to <b>allow popups</b> for this page. When you are happy with your result, you can save it by hitting <b>"Save as ..."</b>. 
  </p>
  <p>
    <h3>Patching Cheat Sheet</h3>
    
    <ul class="quickhelp">
      <li><span class="helptopic">Create nodes</span> <span class="ui-action">Double-Click</span> anywhere in the patch</li>
      <li><span class="helptopic">Draw connections</span> <span class="ui-action">Left-Click</span> pin to start connection;<br/>
        <span class="ui-action">Left-Click</span> other pin to create the connection
      </li>
      <li><span class="helptopic">Delete connection</span> <span class="ui-action">Right-Click</span> connection/link</li>
      <li><span class="helptopic">Modify numeric values</span> <span class="ui-action">Right-Click</span> pin or IOBox; enter value or use<br/>
        <span class="ui-action">Mouse Wheel</span> to modulate;<br/>
        <span class="ui-action">Alt</span> + <span class="ui-action">Mouse Wheel</span> to make smaller adjustments</li>
      <li><span class="helptopic">Modify color values</span> <span class="ui-action">Right-Click</span> pin or IOBox;<br/>
        <span class="ui-action">Mouse Wheel</span> to modulate hue<br/>
        <span class="ui-action">Shift</span> + <span class="ui-action">Mouse Wheel</span> to modulate lightness/value<br/>
        <span class="ui-action">Alt</span> + <span class="ui-action">Mouse Wheel</span> to modulate saturation<br/>
        <span class="ui-action">Shift</span>+ <span class="ui-action">Alt</span> + <span class="ui-action">Mouse Wheel</span> to modulate alpha<br/>
      </li>
      <li><span class="helptopic">Open Inspektor</span> <span class="ui-action">Ctrl</span> + <span class="ui-action">I</span></li>
      <li><span class="helptopic">Select Nodes</span>
        <span class="ui-action">Shift</span> + <span class="ui-action">Left-Click</span> to select multiple nodes<br/>
        <span class="ui-action">Draw selection area</span> to area-select multiple nodes<br/>
        <span class="ui-action">Ctrl</span> + <span class="ui-action">A</span> to select all nodes
      </li>
      <li><span class="helptopic">Copy/Paste</span>
        <span class="ui-action">Ctrl</span> + <span class="ui-action">C</span> to copy<br/>
        <span class="ui-action">Ctrl</span> + <span class="ui-action">V</span> to paste<br/>
        (You can also copy to/paste from classic VVVV)
      </li>
      <li><span class="helptopic">Save As</span> <span class="ui-action">Ctrl</span> + <span class="ui-action">S</span> (triggers file download)</li>
    </ul>
  </p>
  <div class="clear"></div>
  <input class="button close" type="button" value="Close"/>
</div>

<div class="shelf" id="connection_error_shelf">
  <span class="message error"><span>!</span> Sorry, couldn't open the VVVV.js Editor!</span><br/>
  We tried to open it in a pop-up but your browser seemed to block it. After allowing pop-ups for this page and reloading, it should fire up nicely.
  <p>
    Do you need help?
  </p>
  <input class="button open_help_shelf" type="button" value="Yes"/>
  <input class="button close" type="button" value="No"/>
</div>

<div class="shelf" id="not_connected_shelf">
  <span class="message error"><span>!</span> There isn't really anything to save, is it?</span><br/>
  To save a new revision of this patch, launch the Patch Editor by hitting the <b>Edit Patch</b> button.
  <p>
    Do you need help?
  </p>
  <input class="button open_help_shelf" type="button" value="Yes"/>
  <input class="button close" type="button" value="No, thanks"/>
</div>

<h1><?= $name ?></h1>

<div id="patch"></div>

<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=7067416; 
var sc_invisible=1; 
var sc_security="cfe91c6a"; 
</script>

<script type="text/javascript"
src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
class="statcounter"><a title="free web stats"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="http://c.statcounter.com/7067416/0/cfe91c6a/1/"
alt="free web stats" ></a></div></noscript>
<!-- End of StatCounter Code -->

</body>
</html>
