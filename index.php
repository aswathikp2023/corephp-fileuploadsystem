<?php
use App\Helper\Token;
use App\Database\DB;
use App\Helper\SanitizeInput;
use App\Controllers\User;
require_once('App/Helper/Flash.php');


class Index extends DB{
	// use Flash;
	public function __construct(){
		// session_destroy();
		session_start();
		Token::create();
	}
	public function main(){
		if(!empty($_SESSION['loggedin']) && $_SESSION['loggedin']=== TRUE){
		    header("location:index.php");
		}
		include('App/template/header.php');
		include('App/template/login.php');
		include('App/template/footer.php');

	}
	public function home(){
		User::dashboard();
	}

	public function register(){
		if(!empty($_SESSION['loggedin']) && $_SESSION['loggedin']=== TRUE){
		    header("location:index.php?page=register");
		}
		include('App/template/header.php');
		include('App/template/register.php');
		include('App/template/footer.php');
	} 

}
$app =  new Index();
//
//routes
if($_SERVER["REQUEST_METHOD"] == "POST"){

	$token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

	if (!empty($token)) {
	    if (Token::validate($token)) {
	    	//Token refresh
	    	Token::create();
	         // Proceed to process the form data
	    	$page = SanitizeInput::clear($_REQUEST['form']);
	    	switch ($page) {
			  case $page == 'login':{
								  	$email = SanitizeInput::clear($_REQUEST['email']);
									$password = SanitizeInput::clear($_REQUEST['password']);
									User::login($email, $password);
			  						} 
			    					break;
				case $page == 'register':{
								  	$email = SanitizeInput::clear($_REQUEST['email']);
									$password = SanitizeInput::clear($_REQUEST['password']);
									$validate = SanitizeInput::email($email);
									if($validate === false){
										set_flash('err_msg','Enter Valid Email');
										header('location: index.php?page=register');
										exit();
									}
										// check if user exists
									$exist = User::exists($email);

									if(!empty($exist)){
										set_flash('err_msg','Email ID already exists.');
										header('location: index.php?page=register');
										exit();
									}
	
									$response = User::create($email, $password);
									set_flash('success', 'User added successully');
									header('location: index.php?page=register');
									} 
									break;
			   case $page == 'upload':{
			   							User::uploadFile();
									   }
									   break;
			  default:
			    header(base_url() . ' 405 Method Not Allowed');
			    exit();
			}
	    } else {
	         // Log this as a warning and keep an eye on these attempts
	    	header(base_url() . ' 404 Not Found');
    		exit;
	    }
	}

}elseif(
	$_SERVER["REQUEST_METHOD"] == "GET" && 
	!empty($_REQUEST['flag']) && 
	$_REQUEST['flag'] ==='logout'){
		User::Logout();
		header('location: index.php');
	}else{

		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=== TRUE){
			$app->home();
		}else{
			if(isset($_GET['page']) && ($_GET['page'] === 'register'))
			{
				$app->register();
			}else
			{
			 $app->main();
			}
		}
}
?>