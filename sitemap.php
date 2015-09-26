<?php
define('RK_MEDIA',true);
require('init.php');
header("Content-type: text/xml");
#$file = CACHE_PATH.'xml/sitemap'.CACHE_EXT;
#$xml = Cache::BEGIN_CACHE($file);
if(!$xml) {
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><?xml-stylesheet type=\"text/xsl\" href=\"/sitemap.xsl\"?>\n
			<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n
			<url>\n
				<loc>" . SITE_URL . "</loc>\n
				<changefreq>hourly</changefreq>\n
				<priority>1.00</priority>\n
				<lastmod>2013-09-01T00:03:12+07:00</lastmod>\n
			</url>\n";
	$sitemap = MySql::dbselect("id,title,title_en,timeupdate", "film", "");
		for ($i = 0; $i < count($sitemap); $i++) {
			$title = $sitemap[$i][1];
			$url_phim = Url::get($sitemap[$i][0],$title,'Phim');
			$lastmod = date('Y-m-d',$sitemap[$i][3]);
			if($i < 6) $priority[$i] = '0.9';
			elseif($i < 20) $priority[$i] = '0.8';
			elseif($i > 19) $priority[$i] = '0.6';
			$xml .= "<url>\n<loc>$url_phim</loc>\n<changefreq>daily</changefreq>\n<priority>".$priority[$i]."</priority>\n<lastmod>".$lastmod."T00:00:00+07:00</lastmod>\n</url>\n";
		}
	$xml .= "</urlset>";
	#Cache::END_CACHE($xml,$file);
}
echo $xml;
?>