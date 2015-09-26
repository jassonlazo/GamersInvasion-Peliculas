<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
// The functions related to curl
class cURL {
    public static function getWiki($name) {
		$name = VietChar($name);
		$name = str_replace(' ','_',$name);
		$url = "http://vi.wikipedia.org/w/api.php?action=opensearch&search=".urlencode($name)."&format=xml&prop=images&limit=1";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$page = curl_exec($ch);
		$xml = simplexml_load_string($page);
		$Text = (string)$xml->Section->Item->Text;
		$Description = (string)$xml->Section->Item->Description;
		$URL = (string)$xml->Section->Item->Url;
		$Image = (string)$xml->Section->Item->Image[0]['source'];
		$r = array('/20px','/21px','/22px','/23px','/24px','/25px','/26px','/27px','/28px','/29px','/30px','/31px','/32px','/33px','/34px','/35px','/36px','/37px','/38px','/39px','/40px','/41px','/42px','/43px','/44px','/45px','/46px','/47px','/48px','/49px','/50px');
		$Image = str_replace($r,'/120px',$Image);
		$return = array($Text, $Description, $URL, $Image);
		if($Description) {
			return $return;
		} else {
			return "";
		}
	}
	public static function getYoutube($url) {
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		$video_id = $my_array_of_vars['v']; 
		$url = 'http://gdata.youtube.com/feeds/api/videos/'.$video_id.'?v=2&alt=jsonc';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
		curl_setopt($ch, CURLOPT_REFERER, "");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
		$data = curl_exec($ch);
		$obj=json_decode($data);
		$title = $obj->data->title;
        $vid_duration = $obj->data->duration;
		$duration = str_pad(floor($vid_duration/60), 2, '0', STR_PAD_LEFT) . ' phút ' . str_pad($vid_duration%60, 2, '0', STR_PAD_LEFT) .' giây';
		$thumb = "http://i.ytimg.com/vi/$video_id/hqdefault.jpg";
		return array($title,$duration,$thumb);
	}
}