<?php
/**
 * Define APP_URL Dynamically
 * Write this at the bottom of index.php
 *
 * Automatic base url
 */
define('BASEPATH', ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])); 
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('base_url')) {
        function base_url(){
    	return BASEPATH;
	}
 }


if (!function_exists('set_flash')) {
        function set_flash($key,$val){
    	$_SESSION[$key]=$val;
	}
 }
if (!function_exists('is_flash')) {
        function is_flash($key){
    	return array_key_exists($key,$_SESSION);
	}
 }
 if (!function_exists('get_flash')) {
        function get_flash($key){
    	return $_SESSION[$key];
	}
 }
  if (!function_exists('pop_flash')) {
        function pop_flash($key){
    	 $ret=isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	    unset($_SESSION[$key]);
	    return $ret;
	}
 }

?>