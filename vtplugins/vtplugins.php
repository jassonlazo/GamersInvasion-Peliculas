<?php
define('PATH_ROOT', dirname(__FILE__));
class VTPlugin {
	public $ver = '3.1.1';
	public $path = PATH_ROOT;
	public $url;
	public $server;
	public $on_cache = false;
	public $data = null;
	public $key_cache;
	public function get_direct() {
		require $this->path.'/curl/Curl.php';
		require $this->path.'/plugins/'.$this->server.'.php';
		return $data;
	}
	public function utf8_callback($data) {
		return preg_replace_callback(
			"/\\\u([0-9a-f]{4})/i", 
			create_function('$matches', 'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_QUOTES, \'UTF-8\');'), 
			$data
		);
	}
	public function result() {
		if($this->on_cache == true) {
			require $this->path.'/phpfastcache/phpfastcache.php';
			phpFastCache::setup("storage","auto");
			phpFastCache::setup('path',$this->path.'/phpfastcache/cache/');
			$cache = phpFastCache();
			$this->data = $cache->get($this->key_cache);
			if($this->data == null) {
				$this->data = $this->get_direct();
				$cache->set($this->key_cache,$this->data, 86400);
			}
		} else {
			$this->data = $this->get_direct();
		}
		return $this->data;
	}
}