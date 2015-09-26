<pre>
<?php

define('RK_MEDIA', 1);

include_once 'config.php';

mysql_connect(SERVER_HOST, DATABASE_USER, DATABASE_PASS) or die('123');
mysql_select_db(DATABASE_NAME);


$q = mysql_query("SELECT * FROM tb_subtitle") or die(mysql_error());

while($row = mysql_fetch_assoc($q)) {
       mysql_query("UPDATE tb_episode SET default_subtitle_id = {$row['id']} WHERE id = {$row['episode_id']}");
}	