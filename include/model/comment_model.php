<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
class Comment_Model {
	public static function rand_notice() {
		$input = array(
			"Comentario educado sin malas palabras, insultos.", 
			"No le pida a la sala de cine sin HD", 
			"No hay enlaces de otra guía Web sobre."
		);
		return $input[array_rand($input)];
	}
}
