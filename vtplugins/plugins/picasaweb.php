<?php
use \Curl\Curl;
$curl = new Curl();
$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
$curl->get($this->url);
$html = $curl->response;
preg_match('/<title>(.+)<\/title>/',$html,$matches);
$check_url = explode('/',$this->url);
if(strpos(end($check_url),'#') == true) {
	$id_p = explode('#',end($check_url));
	$id_p = $id_p[1];
	$html = explode('shared_group_'.$id_p.'"]',$html);
	$html = $html[1];
}

$title = urlencode($matches[1]);
$html = @explode('"media":{"content":',$html);
$html = @explode(',"description":"',$html[1]);
$json = json_decode($html[0]);
foreach($json as $value) {
	$value = (array)$value;
	$data[$value['height']] = array(
		'url' => $value['url'].'&title='.$title.'+'.$value['height'].'p',
		'type' => $value['type']
	);
}