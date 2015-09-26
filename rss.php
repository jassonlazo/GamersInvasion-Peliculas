<?php
/*
Vao8 v1.0
Source code by Vao8
Writing based on PHP platform
Support: nuocmatdoibantay@gmail.com
*/
define('RK_MEDIA',true);
# Các tập tin quan trọng cần kết nối
require('init.php');
// Gửi đến trình duyệt với yêu cầu trang là xml
header("Content-Type: text/xml; charset=utf-8");
$file = CACHE_PATH."xml/rss".CACHE_EXT;
$rss = Cache::BEGIN_CACHE($file);
if(!$rss) {
	function clean_feed($input) {
		$original = array("<", ">", "&", '"');
		$replaced = array("&lt;", "&gt;", "&amp;", "&quot;");
		$newinput = str_replace($original, $replaced, $input);
		return $newinput;
	}
	function one_data($item,$table,$con) {
		$arr = MySql::dbselect("$item","$table","$con");
		$data = $arr[0][0];
		return $data;
	}
	$rss .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	$rss .= "<rss version=\"2.0\">\r\n";
	$rss .= "<channel>\r\n";
	$rss .= "<title>" . ucwords(Config_Model::ConfigName('site_name')) . " - RSS Feed</title>\r\n";
	$rss .= "<link>" . SITE_URL . "</link>\r\n";
	$rss .= "<description>".Config_Model::ConfigName('site_descriptione')."</description>\r\n";
	$rss .= "<language>vi-vn</language>\r\n";
	$rss .= "<copyright>Copyright (C) XaLoPhim.Org</copyright>\r\n";
	$rss .= "<ttl>60</ttl>\r\n";
	$rss .= "<generator>XaLoPhim.Org</generator> \r\n";
	$arr = MySql::dbselect('
		tb_film.id,
		tb_film.title,
		tb_film.title_en,
		tb_film.thumb,
		tb_film.year,
		tb_film.big_image,
		tb_film_other.content,
		tb_film.quality,
		tb_film.year,
		tb_film.timeupdate,
		tb_film.duration,
		tb_film.director,
		tb_film.actor,
		tb_film.country,
		tb_film.category
		','film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id != 0 order by id desc LIMIT 20");
	for($i=0;$i<count($arr);$i++) {
		$filmid = $arr[$i][0];
		$title = $arr[$i][1];
		$title_en = $arr[$i][2];
		$quality = $arr[$i][7];
		$year = $arr[$i][8];
		$thumb = $arr[$i][3];
		$duration = $arr[$i][10];
		$content = $arr[$i][6];
		$director = $arr[$i][11];
		$actor = $arr[$i][12];
		$country = one_data('name','country',"id = '".$arr[$i][13]."'");
		$category = $arr[$i][14];
		$category = substr($category,1);
		$category = substr($category,0,-1);
		$cat = MySql::dbselect('name','category',"id IN ($category)");
		for($x=0;$x<count($cat);$x++) {
			$catx .= $cat[$x][0].', ';
		}
		$category = substr($catx,0,-2);
		$m_time = date('D, d M Y H:i:s',$arr[$i][9]);
		$url = Url::get($arr[$i][0],$title,'Phim');
		$rss .= "<item>\r\n";
		$rss .= "<title>" . clean_feed($title.' - '.$title_en) . "</title>\r\n";
		$rss .= "<description><![CDATA[<table><tr><td><img src=\"".$thumb."\" width=\"200\" height=\"270\" alt=\"" . clean_feed($title.' - '.$title_en) . "\" /></td><td><a href=\"$url\" title=\"" . clean_feed($title.' - '.$title_en) . "\" target=\"_blank\"><h1 />" . clean_feed($title.' - '.$title_en) . "</h1></a><br />Diễn viên: ".CheckName($actor)."<br />Đạo diễn: ".CheckName($director)."<br />Quốc gia: ".RemoveHtml($country)."<br />Thể loại: ".RemoveHtml($category)." <br />Thời lượng: ".$duration."</td></tr></table><hr />".CutName(RemoveHtml(UnHtmlChars($content)),250)."]]></description>\r\n";
		$rss .= "<link>".$url."</link>\r\n";
		$rss .= "<pubDate>".$m_time." GMT</pubDate>\r\n";
		$rss .= "</item>\r\n\r\n";
	}
	$rss .= "</channel>\r\n";
	$rss .= "</rss>\r\n";
	Cache::END_CACHE($rss,$file);
}
echo $rss;
exit();
?>