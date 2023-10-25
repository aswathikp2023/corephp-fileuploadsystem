<?php
namespace App\Helper;

Class SanitizeInput{
	public static function clear($string) : String{
		return htmlspecialchars(trim(strip_tags($string)));
	}
	public static function email($email) : String{
		return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
	}
}
?>