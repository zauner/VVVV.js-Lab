<?
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>VVVV.js Lab: New Patch</title>
<link rel="stylesheet" type="text/css" href="vvvv_js-26c779666/vvvviewer/vvvv.css"/>
<link rel="stylesheet" type="text/css" href="main.css"/>
<link rel="stylesheet" type="text/css" href="show.css"/>
<script language="JavaScript" src="vvvv_js-26c779666/lib/jquery/jquery-1.8.2.min.js"></script>
<script language="JavaScript" src="main.js"></script>
<script language="JavaScript" src="vvvv_js-26c779666/vvvv.min.js"></script>
<script language="JavaScript" src="new.js?b6sddd87505452"></script>
</head>
<body>
  
<div id="menu_bar">
  <a href="index.php" class="page_title">VVVV.js <span>Lab</span></a>
  <div id="controls">
    <a href="#" id="showpatch" class="disabled">Show Patch</a>
    <a href="#" id="open_save_shelf" class="disabled">Save As ...</a>
    <a href="#" class="open_help_shelf">Need Help?</a>
  </div>
</div>

<div class="shelf" id="save_shelf">
  <form action="index.php" method="post" id="new_form">
    <input type="hidden" name="action" value="create"/>
    <textarea id="xml" name="patch[xml]"></textarea>
    <textarea id="screenshot_data" name="patch[screenshot]"></textarea>
    <img src="img/placeholder.png" id="screenshot_image"/>
    <label>Title</label><input class="text" type="text" name="patch[name]"/>
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
    Here at the <b>VVVV.js lab</b>, you can <b>push every patch to a VVVV instance</b> on your machine, play around with it, and <b>save it as a new revision</b>. Don't worry, you won't break or overwrite anything doing so.<br/>
  </p>
  <p>
    To connect the lab to your VVVV, you need the following:
    <ol>
      <li><a href="http://www.vvvv.org/downloads" target="_new">VVVV 45beta27 or higher</a> running on your machine</li>
      <li>The latest <a href="https://github.com/downloads/zauner/vvvv.js/vvvv_js_sdk-0.2.zip">VVVV.js SDK</a></li>
      <li>An empty patch, containing only a VVVVJsConnector node</li>
    </ol>
  </p>
  <p>
    There's a <b>detailed guide</b> about setting all this up at substance.io: <a href="http://substance.io/zauner/patching-vvvvjs" target="_new">Patching VVVV.js</a>.
  </p>
  <p>
    If you got everything right, just hit the <b>"Sync to VVVV + Edit"</b> button on the upper left, and the patch should be pushed to your classic VVVV.
    You can patch around then, <b>see the results in the browser</b>, and hit "Save As ..." to give save it as a new version, providing <b>a screenshot and a name</b>.
  </p>
  <p>
    If you have trouble, hit the "Show Patch" button, and have a look of what VVVV.js made of your patch. Maybe you stumble upon some <b>red nodes</b>,
    which means that these nodes have <b>not been ported to VVVV.js yet</b>.
  </p>
  <input class="button close" type="button" value="Close"/>
</div>

<div class="shelf" id="connection_error_shelf">
  <span class="message error"><span>!</span> Sorry, couldn't connect to VVVV!</span><br/>
  Make sure, you have <b>VVVV running an empty VVVV patch</b>, containing only a <b>VVVVJsConnector</b> node, and hit <b>Reload</b>.
  <p>
    Do you need help?
  </p>
  <input class="button open_help_shelf" type="button" value="Yes"/>
  <input class="button close" type="button" value="No"/>
</div>

<div class="shelf" id="not_connected_shelf">
  <span class="message error"><span>!</span> There's no connection to VVVV yet.</span><br/>
  To create a new patch, <b>start VVVV on your machine</b>, and add the <b>VVVVJsConnector</b> node to an empty patch. Then hit the <b>Reload</b> button.
  <p>
    Do you need help?
  </p>
  <input class="button open_help_shelf" type="button" value="Yes"/>
  <input class="button close" type="button" value="No, thanks"/>
</div>

<h1>New Patch</h1>

<div id="patch"></div>

</body>
</html>