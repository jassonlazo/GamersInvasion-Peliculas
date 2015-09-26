<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
// Optimización de datos
class Cache {
	public static function BEGIN_CACHE($file,$expire = '') {
		//$expire 			= 	CACHE_TIME;
		if($expire) {
			if (file_exists($file) && filemtime($file) > (time() - $expire)) {
				$html = file_get_contents($file);
				return $html;
			} else return false;
		}else {
			if (file_exists($file)) {
				$html = file_get_contents($file);
				return $html;
			} else return false;
		}
	}
    public static function END_CACHE($html,$file) {
		$html = Cache::SanitizeOutput($html);
		$fp = fopen($file,"w");
		fputs($fp, $html);
		fclose($fp);
	}
	public static function SanitizeOutput($buffer) {
		$search = array(
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s'       // shorten multiple whitespace sequences
		);
		$replace = array(
			'>',
			'<',
			'\\1'
		);
		$buffer = preg_replace($search, $replace, $buffer);
		return $buffer;
	}
}