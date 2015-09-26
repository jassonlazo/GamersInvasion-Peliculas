<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
class GetLink {
	public static function Mobile($url) {
		$is_picasa        = (preg_match('#picasaweb.google.com/(.*?)#s', $url)); // Picasaweb
		$is_zingtv         = (preg_match("#tv.zing.vn/video/([^/]+)#", $url)); // Zing TV
		$is_ggdocs        = (preg_match("#docs.google.com(.*?)#s", $url)); // Google Docs
		$is_nct        = (preg_match("#nhaccuatui.com(.*?)#s", $url)); // Nhaccuatui
		$is_dailymotion        = (preg_match("#dailymotion.com(.*?)#s", $url)); // Dailymotion
		$is_youtube        = (preg_match("#youtube.com(.*?)#s", $url)); // Youtube
		if($is_picasa) {
			// Análisis de los primeros resultados
			$url = str_replace('https','http',$url);
			$link = file_get_contents($url);
			if(strpos($url,"?noredirect=1#")) {
				$_id = explode("?noredirect=1#",$url);
				$html_id = explode('"'.$_id[1].'"',$link);
				$html_id = explode('}],"description"',$html_id[1]);
				$link = explode('"type":"application/x-shockwave-flash"},{"url":"',$html_id[0]);
				$link = explode('","',$link[1]);
				$link = urldecode($link[0]);
			} else {
				$link = explode('"type":"application/x-shockwave-flash"},{"url":"',$link);
				$link = explode('","',$link[1]);
				$link = urldecode($link[0]);
			}
			// Análisis del segundo resultado
			if(!$link) {
				$url = 'https://picasaweb.google.com/'.$id;
				$link	=	str_replace('authkeyenterplus','?authkey=',$url);
				$link	=	str_replace('/daukhac/','#',$link);
				$html = file_get_contents($link);
				$link = explode($link."#",$html);
				$link = explode('"',$link[1]);
				$url = $url."#".$link[0];
				$link	=	str_replace('authkeyenterplus','?authkey=',$url);
				$url	=	str_replace('/daukhac/','#',$link);
				$link = file_get_contents($url);
				$link = explode('"type":"application/x-shockwave-flash"},{"url":"',$link);
				$link = explode('","',$link[1]);
				$link = urldecode($link[0]);
			}
			// Mueva los enlaces a archivos mp4
			//header('Location: '.$link); // resultado
		}else if($is_zingtv) {
			// Análisis html para conseguir enlaces a archivos mp4
			$url = explode("/",$url);
			$url = explode(".html",$url[5]);
			$url = "http://m.tv.zing.vn/video/Tap-20-END/".$url[0].".html";
			$html =	file_get_contents($url);
			$link = explode('<source src="',$html);
			$link = explode('"',$link[1]);
			$link = $link[0];
			// Mueva los enlaces a archivos mp4
			//header('Location: '.$link); // resultado
		}else if($is_ggdocs) {
			$url = str_replace('https','http',$url);
			$html	=	file_get_contents($url);
			$link	= 	explode('18|',$html);
			$link	=	explode('|',$link[1]);
			$link	=	$link[0];
			// Mueva los enlaces a archivos mp4
			//header('Location: '.$link); // resultado
		}else if($is_nct) {
			$html	=	file_get_contents($url);
			$link	= 	explode('&amp;file=',$html);
			$link	=	explode('"',$link[1]);
			$url	=	$link[0];
			$html	=	file_get_contents($url);
			$link	= 	explode('<![CDATA[',$html);
			$link	=	explode(']]>',$link[3]);
			$link	=	$link[0];
			// Mueva los enlaces a archivos mp4
			//header('Location: '.$link); // resultado
		}else {
			$link = $url;
		}
		return $link;
	}
	
	public static function _GetDirectForJwplayer($url,$server)
{
	$_HtmlDATA = $_DataIMG = $_File = '';
	$_DataQT = $_JsonData = $_DataEXP = array();
	if(isset($server) && $server == 'picasaweb')
	{
		$_HtmlDATA = @file_get_contents($url);
		$_DataEXP = @explode('"media":{"content":',$_HtmlDATA);
		$_DataEXP = @explode(',"description":"',$_DataEXP[1]);
		$_JsonData = (array)json_decode($_DataEXP[0]);
		foreach ($_JsonData as $value) {
			$_DataARR = (array)$value;
			if($_DataARR['type'] == 'image/jpeg' && !$_DataIMG) 
				$_DataIMG = (string)$_DataARR['url'];
			else
			{
				$_Height = (int)$_DataARR['height'];
				$_DataQT[$_Height] = (string)$_DataARR['url'];
			}
		}
	}
	else if(isset($server) && $server == 'docs')
	{
		$_HtmlDATA = @file_get_contents($url);
		$_DataEXP = @explode('["fmt_stream_map","',$_HtmlDATA);
		$_DataEXP = @explode(']',$_DataEXP[1]);
		$_DataEXP = (string)$_DataEXP[0];
		$_JsonData = @explode(',',$_DataEXP);
		$_JsonData = @array_reverse($_JsonData);
		foreach ($_JsonData as $value) {
			$_DataARR = @explode('|',$value);
			$_DataItag = (int)$_DataARR[0];
			$_DataDR = @(string)$_DataARR[1];
			if($_DataItag != 0 && in_array($_DataItag,array(18,35,22)) && $_DataDR != false)
			{
				$_DataDR = preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_QUOTES, \'UTF-8\');'), $_DataDR);
				$_Height = (int)str_replace(array(18,35,22),array(360,480,720),$_DataItag);
				$_DataQT[$_Height] = urldecode($_DataDR);
			}
		}
	}
	return array('DataIMG' => $_DataIMG, 'DataQT' => $_DataQT);
}
	
	
	public static function buil_down($epid) {
		$episode = MySql::dbselect('url','episode',"id = '$epid'");
		$url = $episode[0][0];
		$url = str_replace('https','http',$url);
		$is_picasa        = (preg_match('#picasaweb.google.com/(.*?)#s', $url)); // Picasaweb
		$is_zingtv         = (preg_match("#tv.zing.vn/video/([^/]+)#", $url)); // Zing TV
		$is_ggdocs        = (preg_match("#docs.google.com(.*?)#s", $url)); // Google Docs
		$is_nct        = (preg_match("#nhaccuatui.com(.*?)#s", $url)); // Nhaccuatui
		$is_dailymotion        = (preg_match("#dailymotion.com(.*?)#s", $url)); // Dailymotion
		$is_youtube        = (preg_match("#youtube.com(.*?)#s", $url)); // Youtube
		if($is_picasa) {
			$data = file_get_contents($url);
			$mp4 = array();
			$ht = explode('"media":{"content":', $data);
			$code = explode('"description":', $ht[1]);
			$link = explode('"url":"', $code[0]);
			for ($i = 2; $i < count($link); $i++) {
				$play = explode('"', $link[$i]);
				if (substr_count($play[0], "itag=5&") > 0) array_push($mp4, "240p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=34&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=6&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=35&") > 0) array_push($mp4, "480p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=59&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=22&") > 0) array_push($mp4, "720p [HD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=37&") > 0) array_push($mp4, "1080p [HD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=38&") > 0) array_push($mp4, "Ful HD|-|" . $play[0]);
			}
			for ($i = 0; $i < count($mp4); $i++) {
				$d = explode('|-|', $mp4[$i]);
				$html.= "<a href=\"$d[1]\" title=\"Chất lượng $d[0]\" target=\"_blank\">$d[0]</a>&nbsp;-&nbsp;";
			}	
			$html = substr($html, 0, -7);
		}
		if($is_zingtv) {}
		if($is_nct) {
			$html	=	file_get_contents($url);
			$link	= 	explode('&amp;file=',$html);
			$link	=	explode('"',$link[1]);
			$url	=	$link[0];
			$html	=	file_get_contents($url);
			$link	= 	explode('<![CDATA[',$html);
			$link	=	explode(']]>',$link[3]);
			$link	=	$link[0];
			$html = "<a href=\"$link\" title=\"Chất lượng 360p [SD]\" target=\"_blank\">360p [SD]</a>&nbsp;-&nbsp;";
			$html = substr($html, 0, -7);
		}
		if($is_ggdocs) {
			$data	=	file_get_contents($url);
			$mp4 = array();
			$ht = explode('"fmt_stream_map":', $data);
			$code = explode('"fmt_list"', $ht[1]);
			$link = explode('|', urldecode(unescapeUTF8EscapeSeq($code[0])));
			for ($i = 1; $i < count($link); $i++) {
				$play = explode('"', $link[$i]);
				if (substr_count($play[0], "itag=5&") > 0) array_push($mp4, "240p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=34&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=6&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=35&") > 0) array_push($mp4, "480p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=59&") > 0) array_push($mp4, "360p [SD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=22&") > 0) array_push($mp4, "720p [HD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=37&") > 0) array_push($mp4, "1080p [HD]|-|" . $play[0]);
				if (substr_count($play[0], "itag=38&") > 0) array_push($mp4, "Ful HD|-|" . $play[0]);
			}
			for ($i = 0; $i < count($mp4); $i++) {
				$d = explode('|-|', $mp4[$i]);
				$html.= "<a href=\"$d[1]\" title=\"Chất lượng $d[0]\" target=\"_blank\">$d[0]</a>&nbsp;-&nbsp;";
			}
			$html = substr($html, 0, -7);
		}
		if($is_youtube) {
			$my_id = VideoYoutubeID($url);
			$my_video_info = 'http://www.youtube.com/get_video_info?&video_id='.$my_id;
			$my_video_info = curlGet($my_video_info);
			$thumbnail_url = $title = $url_encoded_fmt_stream_map = $type = $url = '';
			parse_str($my_video_info);
			if(isset($url_encoded_fmt_stream_map)) {
				$my_formats_array = explode(',',$url_encoded_fmt_stream_map);
			}
			$avail_formats[] = '';
			$i = 0;
			$ipbits = $ip = $itag = $sig = $quality = '';
			$expire = time(); 
			foreach($my_formats_array as $format) {
				parse_str($format);
				$avail_formats[$i]['itag'] = $itag;
				$avail_formats[$i]['quality'] = $quality;
				$type = explode(';',$type);
				$avail_formats[$i]['type'] = $type[0];
				$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
				parse_str(urldecode($url));
				$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
				$avail_formats[$i]['ipbits'] = $ipbits;
				$avail_formats[$i]['ip'] = $ip;
				$i++;
			}
			if(count($avail_formats) > 1) {
				for ($i = 0; $i < count($avail_formats); $i++) {
					$url = $avail_formats[$i]['url'];
					$chatluong = $avail_formats[$i]['type'].' ('.$avail_formats[$i]['quality'].')';
					$html.= "<a href=\"$url\" title=\"Calidad $chatluong\" target=\"_blank\">$chatluong</a>&nbsp;-&nbsp;";
				}
			}
			$html = substr($html, 0, -7);
		}
		$arrep = MySql::dbselect('subtitle','episode',"id = '$epid'");
		$subtitle = urldecode($arrep[0][0]);
		if($subtitle) $html .= "<p>Nota: Este episodio debe <a href=\"$subtitle\" title=\"Descarga subtítulos\" target=\"_blank\">Descargar los subtitulos</a></p>";
		return $html;
	}
}
