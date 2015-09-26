<?php
use \Curl\Curl;
$curl = new Curl();
$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
parse_str(parse_url($this->url,PHP_URL_QUERY),$arr_var);
$youtubeUrl = 'http://www.youtube.com/watch?v='.$arr_var['v'];
$curl->get($this->url);
$content = $curl->response;
if (preg_match('/;ytplayer\.config\s*=\s*({.*?});/', $content, $matches)) {
	$jsonData = json_decode($matches[1], true);
	$streamMap = $jsonData['args']['url_encoded_fmt_stream_map'];
	$title = $jsonData['args']['title'];
	$videoUrls = array();
	$streamMap = explode(',', $streamMap);
	$streamMap = @array_reverse($streamMap);
	foreach ($streamMap as $url)
	{
		$url = str_replace('\u0026', '&', $url);
		$url = urldecode($url);
		parse_str($url, $value);
		$dataURL = $value['url'];
		unset($value['url']);
		if(in_array($value['itag'],array(18,35,22))) {
			$height = (int)str_replace(array(18,35,22),array(360,480,720),$value['itag']);
			$data[$height] = array(
				'url' => str_replace('"', "'", $dataURL.'&'.urldecode(http_build_query($value))).'&title='.$title.'+'.$height.'p',
				'type' => 'mp4'
			);
		}
	}
}