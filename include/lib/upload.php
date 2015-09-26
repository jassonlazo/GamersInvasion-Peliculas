<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
// Upload file
class Upload {
        public static function Subtitle($name,$type='') {
                if($type) $folder = $type.'/';
                $extension = get_type($_FILES["$type"]['name']);
                if($_FILES["$type"]['tmp_name'] && $extension == 'srt') {
                        $extension = 'srt';
                        move_uploaded_file($_FILES["$type"]['tmp_name'],UPLOAD_PATH."$folder$name.$extension");
                        return UPLOAD_URL."$folder$name.$extension";
                } else {
                        return false;
                }
        }
        
        public static function newSubtitle() {
        	if(!isset($_FILES['newsub_file'])) return null;
			
			$newsub_amt = count($_FILES['newsub_file']['name']);
			$folder = 'subtitle/';
			$return = array();
			
			for($i = 0; $i < $newsub_amt; $i++) {
				$extension = get_type($_FILES['newsub_file']['name'][$i]);
				$name = 'sub_'.strtotime('now').rand(10000000,99999999);
				if($_FILES['newsub_file']['tmp_name'][$i] && $extension == 'srt') {
                        $extension = 'srt';
                        move_uploaded_file($_FILES['newsub_file']['tmp_name'][$i],UPLOAD_PATH."$folder$name.$extension");
                        $return[$i] = UPLOAD_URL."$folder$name.$extension";
                } else {
                		$return[$i] = null;
                }
			}
			
			return $return;
        }
}