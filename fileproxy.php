<?php

if (true) {//key_exists('HTTP_REFERER', $_SERVER) && strpos($_SERVER["HTTP_REFERER"], "vvvvjs.quasipartikel.at")==$_SERVER['HTTP_HOST']) {
  if ($_REQUEST["f"]!="") {
    $ch = curl_init($_REQUEST["f"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
    $content = curl_exec($ch);
  
    $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    if (strpos($content_type, 'image/')===0) {
      header('Content-Type: '.content_type);
      echo $content;
    }
  }
}


?>
