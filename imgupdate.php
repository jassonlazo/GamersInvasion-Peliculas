<?php
define('RK_MEDIA',true);
# Conectados Los archivos importantes
require('init.php');
$url= $_GET['newthumb'];
MySql::dbinsert("test","url","'$url'");
#echo $_GET['id'];
?>