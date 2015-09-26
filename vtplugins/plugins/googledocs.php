<?php
use \Curl\Curl;
$curl = new Curl();
$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
$curl->get($this->url);
$html = $curl->response;
preg_match('/<title>(.+)<\/title>/',$html,$matches);
$title = urlencode($matches[1]);
$html = @explode('["fmt_stream_map","',$html);
$html = @explode('"]',$html[1]);
$json = @explode(',',$html[0]);
$json = @array_reverse($json);
foreach ($json as $value) {
	$_DataARR = @explode('|',$value);
	$_DataItag = (int)$_DataARR[0];
	$_DataDR = @(string)$_DataARR[1];
	if($_DataItag != 0 && in_array($_DataItag,array(18,35,22)) && $_DataDR != false)
	{
		$_Height = (int)str_replace(array(18,35,22),array(360,480,720),$_DataItag);
		$data[$_Height] = array(
			'url' => $this->utf8_callback($_DataDR).'&title='.$title.'+'.$_Height.'p',
			'type' => 'mp4'
		);
	}
}