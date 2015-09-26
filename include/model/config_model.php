<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
class Config_Model {
	public static function ConfigName($name) {
		$arr = MySql::dbselect('config_name,config_content','config',"config_name = '$name'");
		return $arr[0][1];
	}
}
