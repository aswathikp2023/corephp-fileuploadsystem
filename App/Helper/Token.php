<?php
namespace App\Helper;

class Token{
	public static function create() : void{
		if (empty($_SESSION['token'])) {
	        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
	    }
	}
	public static function validate($token):bool{
		return (hash_equals($_SESSION['token'], $token)) ? true:false;
	}
}
?>