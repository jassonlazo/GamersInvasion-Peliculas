<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script>

function update(i) {
	oldimg = document.getElementById("old0");
	filmid = document.getElementById("film"+i);
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("thumb0").innerHTML=xmlhttp.responseText;
	document.getElementById("status0").innerHTML="•";
    }
  }
xmlhttp.open("GET","http://saved-media.com/upload/upload1.php?url=http%3A%2F%2F4.bp.blogspot.com%2F-3A-vZ2ZjeY4%2FUV_hPd-jeqI%2FAAAAAAAARkc%2FLVOYwyGVQA4%2Fs1600%2FYLSLQni.png",true);
xmlhttp.send();
}
</script>
</head>

<body>

<?php
define('RK_MEDIA',true);
require('init.php');
$episode = MySql::dbselect('id,title,thumb','film',"id = 1632");
echo "<table border='1'>
<tr>
<th>filmid</th>
<th>name</th>
<th>new thumb</th>
<th>status</th>
<th>old thumb</th>


</tr>";

function kq($x, $y, $z, $i) {
  echo "<tr>";
  echo "<td id=\"film".$i."\">" . $x . "</td>";
  echo "<td>" . $y . "</td>";
  echo "<td id=\"thumb".$i."\"></td>";
  echo "<td id=\"status".$i."\"></td>";
  echo "<td id=\"old".$i."\">" . $z . "</td>";
  

  echo "</tr>";}
  $i=0;
while ($episode[$i][1] != "") {kq($episode[$i][0], $episode[$i][1], $episode[$i][2], $i); $i++;}
echo "</table>";
?>
<div id="myDiv"><h2>Let AJAX change this text</h2></div>
<button type="button" onclick="update(0)">Change Content</button>
</body>
</html>