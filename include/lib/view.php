<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
// Template
class View {
	public static function TemplateView($template, $ext = '.php') {
		parse_str(parse_url(Url::curRequestURL(),PHP_URL_QUERY), $get);
		if($get['ver'] == 'mobile') {
			$_SESSION['mobile'] = true;
			header('Location: /');
		}
		else if($get['ver'] == 'desk') {
			$_SESSION['mobile'] = false;
			header('Location: /');
		}
		if(CheckMobile() || $_SESSION['mobile'] == true) {
			if (!is_dir(TEMPLATE_M_PATH)) {
				die('Không tồn tại thư mục template');
			}
			$rs = TEMPLATE_M_PATH . $template . $ext;
		} else {
			if (!is_dir(TEMPLATE_PATH)) {
				die('Không tồn tại thư mục template');
			}
			$rs = TEMPLATE_PATH . $template . $ext;
		}
		return $rs;
	}
	public static function AdminView($template, $ext = '.php') {
		if (!is_dir(ADMINCP_PATH)) {
			die('Không tồn tại thư mục template');
		}
		return ADMINCP_PATH . $template . $ext;
	}
	public static function output() {
		ob_start("sanitize_output");
		Site_Controller::display();
	}
}
