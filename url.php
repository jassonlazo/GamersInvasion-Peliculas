<?php 

$url="http://r9---sn-npo7enes.googlevideo.com/videoplayback?id=08daa4b80a45c59b&itag=34&source=picasa&ip=128.199.142.224&ipbits=0&expire=1408286231&sparams=expire,id,ip,ipbits,itag,source&signature=34EF325E35CD65ECAE62A9F6C9EBD362F8974F44.1E252620C4937FE79C8B70F8BD64184CDFE5CC97&key=cms1&cms_redirect=yes&ms=nxu&mt=1405700678&mv=m&mws=yes";
// This is what you need, it will return you the last effective URL

// Uncomment to see all headers
/*
echo "<pre>";
print_r($a);echo"<br>";
echo "</pre>";
*/

#$link = file_get_contents($url);
$link = explode("if (!'",$url);
$link = explode("'",$link[1]);
header("location: ".rawurldecode($link[0])); 
echo $url; // Voila
?>