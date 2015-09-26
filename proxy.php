<?php
#header('Location: http://saved-media.com/upload/upload1.php?url='.rawurlencode($_GET['url']).'&id='.$_GET["id"].'');
header('Content-type: text/html');

// Website url to open
$url = 'http://saved-media.com/upload/upload1.php?url='.rawurlencode($_GET['url']).'&id='.$_GET["id"].'';

// Get that website's content
$handle = fopen($url, "r");

// If there is something, read and return
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        echo $buffer;
    }
    fclose($handle);
}
?>