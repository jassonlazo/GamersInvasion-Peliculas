<?php

$link = $_POST['url'];
$useheader = $_POST['iheader'];
$useragent = $_POST['iagent'];
$referer = $_POST['ireferer'];
$autoreferer = $_POST['iautoreferer'];
$usehttpheader = $_POST['ihttpheader'];
$custheader = $_POST['icustheader'];
$ucookie = $_POST['icookie'];
$encoding = $_POST['iencoding'];
$timeout = $_POST['itimeout'];
$follow = $_POST['ifollow'];
$mpost = $_POST['ipost'];
$mpostfield = $_POST['ipostfield'];
$proxytunnel = $_POST['iproxytunnel'];
$proxytype = $_POST['iproxytype'];
$proxyport = $_POST['iproxyport'];
$proxyip = $_POST['iproxyip'];
$sslverify = $_POST['isslverify'];
$nobody = $_POST['inobody'];

function get_curl($url)
{
	global $useheader,$useragent,$referer,$autoreferer,$usehttpheader,$custheader,$ucookie,$encoding,$timeout,$follow,$mpost,$mpostfield,$proxytunnel,$proxytype,$proxyport,$proxyip,$sslverify,$nobody;
	$curl = curl_init();
	$header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Keep-Alive: 115";
	$header[] = "Connection: keep-alive";
	if($custheader!=""){$header[] = urldecode($custheader);}
	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	if($useheader=="true"){curl_setopt($curl, CURLOPT_HEADER, 1);}
	if($useragent!=""){curl_setopt($curl, CURLOPT_USERAGENT, $useragent);}
	if($usehttpheader=="true"){curl_setopt($curl, CURLOPT_HTTPHEADER, $header);}
	if($ucookie!=""){curl_setopt($curl, CURLOPT_COOKIE, str_replace('\\"','"',$ucookie));}
	if($referer!=""){curl_setopt($curl, CURLOPT_REFERER, $referer);}
	if($autoreferer=="true"){curl_setopt($curl, CURLOPT_AUTOREFERER, 1);}
	if($encoding!=""){curl_setopt($curl, CURLOPT_ENCODING, $encoding);}
	if($timeout!=""){curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);}
	if($follow=="true"){curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);}
	if($mpost=="true"){curl_setopt($curl, CURLOPT_POST, 1);}
	if($mpostfield!=""){curl_setopt($curl, CURLOPT_POSTFIELDS, $mpostfield);}
	if($proxytunnel=="true"){curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);}
	if($proxytype=="http"){curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);}
	if($proxytype=="socks5"){curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);}
	if($proxyport!=""){curl_setopt($curl, CURLOPT_PROXYPORT, $proxyport);}
	if($proxyip!=""){curl_setopt($curl, CURLOPT_PROXY, $proxyip);}
	if($nobody=="true"){curl_setopt($curl, CURLOPT_NOBODY, 1);}
	if($sslverify=="true"){
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	}

	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}
function showLinkEpisode($link = null) {
    if (strpos($link, 'picasaweb.google.com/lh/photo/')) {
        $link = encrypt_decrypt('decrypt', str_replace('https://picasaweb.google.com/lh/photo/', '', $link));
    }
    return $link;
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'hackcaigi';
    $secret_iv = 'hacklamcho';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
if($link){
	$link = showLinkEpisode($link);
	
	if(stripos($link, 'picasaweb.google.com/lh/photo/')) // rui do
	{
		$text = get_curl($link);
		$arr = explode(',"media":{',$text);
		$ct = $arr[1];
		$arr2 = explode('}],"title":',$ct);
		$ct2 = $arr2[0];
		$text = $ct2;
	} 
	// elseif(preg_match('/picasaweb.google.com\/([0-9]+)\/(.*?)\?authkey\=(\w+)/is', $link, $matches)){
		// $text = get_curl($link);
		// array_shift($matches);
		// $matches2 = array();
		// foreach($matches as $k => $v){
			// $matches2[] = encrypt_decrypt('encrypt', $v);
		// }
		// $text = str_replace($matches,$matches2,$text);
	// } elseif(preg_match('/picasaweb.google.com\/(.*?)\/(.*?)\?authkey\=(\w+)/is', $link, $matches)){
		// echo $linkOld = $matches[0];
		// array_shift($matches);
		// $matches2 = array();
		// foreach($matches as $k => $v){
			// $matches2[] = encrypt_decrypt('decrypt', $v);
		// }
		// $linkNew = 'https://'.str_replace($matches,$matches2,$linkOld);
		// $text = get_curl($linkNew);
		// $text = str_replace($matches2,'',$text);
	// }
	else{
		$text = get_curl($link);
	}
	echo $text;
}

?> 