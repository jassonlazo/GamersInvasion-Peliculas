<?php

if(!isset($_GET['dl'])) exit;

$url = parse_url($_GET['dl']);

//if(!preg_match("/dailymotion.com/", $url['host'])) exit;


$f = $_GET['dl'];

$in = fopen($f, 'r');

while($c = fread($in, 10240)) { echo $c; }
