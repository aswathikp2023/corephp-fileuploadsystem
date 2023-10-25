<?php
namespace App\Helper;
use App\Database\DB;

class Password {
	
	public static function encrypt($password) : String{
		return password_hash($password, PASSWORD_DEFAULT);
	}
	public static function verify(String $email, String $password) : int|String{
		$c = DB::run('select user_id,password from user where email=? ',[$email])->fetch();

		if(!empty($c)){
			if(password_verify($password, $c['password']) ){
				return $c['user_id'];
			}
			else{
			return 'Incorrect Password';	
			}
		} else{
			return 'User Not Found';
		}
	}
}
?>