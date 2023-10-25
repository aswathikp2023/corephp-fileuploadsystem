<?php 
namespace App\Controllers;
use App\Database\DB;

class Log{
 public static function ipaddress(){
 	$ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
 }

 public static function save(String $filename,String $status){
 	// log all uploaded records
 	$ipaddress = SELF::ipaddress();
		$query = 'INSERT INTO Logs (user, filename, ipaddress, status) VALUES (:user, :file, :ipaddress, :status)';
		$args = array(':user' => $_SESSION['id'],':file' => $filename, ':ipaddress' => $ipaddress, ':status' => $status);
		return DB::run($query, $args);
	
 }
}
?>