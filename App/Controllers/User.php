<?php
namespace App\Controllers;
use App\Helper\SanitizeInput;
use App\Helper\Password;
use App\Database\DB;
use App\Controllers\Log;


class User{

	public static function login(String $email, String $password){ 

			$response = Password::verify($email, $password);
			
			if(!is_numeric($response)){
				set_flash('err_msg',$response);
				header('location: index.php');
				exit();
			}
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['id'] = $response;
			SELF::dashboard();
	}
	public static function create(String $email, String $password){
		$password = Password::encrypt($password);
		$query = 'INSERT INTO User (name, email, password, status) VALUES (:name, :email, :password, :status)';
		$args = array(':name' => $email,':email' => $email, ':password' => $password, ':status' => 1);
		return DB::run($query, $args);
	} 

	public static function exists($email){
		$query = 'select user_id from user where email=?';
		$args = [$email];
		return DB::run($query, $args)->fetch();
	}
	public static function logout(){ 
		session_destroy();
		return true;
	}
	public static function dashboard(){
		include('App/template/home.php');
	}
	public static function uploadFile(){
			if(isset($_FILES['file'])) {

        ini_set("memory_limit", "20000M"); 

    $errors     = array();
    $maxsize    = 5242880;
    $acceptable = array(
        'application/pdf',
        'application/msword',
        'image/jpeg',
        'image/jpg',
        'image/png'
    );
  
    if((!in_array($_FILES['file']['type'], $acceptable)) && (!empty($_FILES["file"]["type"]))) {
        set_flash('err_msg','Invalid file type. Only PDF, DOC, JPG and PNG types are accepted.');
		// header('location: home.php');
		Log::save($_FILES['file']['name'], 'failed');
		SELF::dashboard();
		exit();
    }

    if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
         set_flash('err_msg','File too large. File must be less than 5 megabytes.');
		// header('location: home.php');
		Log::save($_FILES['file']['name'], 'failed');
        SELF::dashboard();
		exit();
    }


    if(count($errors) === 0) {

        $_FILES["file"]["name"] =  SanitizeInput::clear($_FILES["file"]["name"]);
        // $getExtension = explode(".", $_FILES["file"]["name"]);
      
        // $basefilename = time().end($getExtension);
        $basefilename = time().$_FILES["file"]["name"];
        if (!file_exists('/var/store/')) {
             mkdir('/var/store/', 0777, true);

               //add .htaccess in folder to prevent execustion of files
       
    		$newfile = fopen('/var/store/.htaccess', 'wb');

       		fputs($newfile, '<Files *.php>
					Deny from all
					</Files>
					<Files *.exe>
					Deny from all
					</Files>
					<Directory />
					AllowOverride None
					</Directory>

					<Directory /home>
					AllowOverride FileInfo
					</Directory>
					<Directory "file:///C:/var/store/">
						Deny from all
					</Directory>
					');
   
    		fclose($newfile);
        }
        // Read and write for owner, read for everybody else
        if(move_uploaded_file($_FILES['file']['tmp_name'], '/var/store/'.$basefilename)){
		        if(is_executable('/var/store/'.$basefilename)){
		            chmod('/var/store/'.$basefilename, 0000);
		        }
		      
		        // rename file and save the extension in db if needed
		        //log details
		        Log::save($basefilename, 'success');
		        SELF::uploadhistory($basefilename);
		    }else{
		    	Log::save($basefilename, 'suspicious');
		    }
    }
    
	    set_flash('success','File uploaded successfully.');
		// header('location: home.php');
		//remove file from globals
		unset($_FILES['file']);
		SELF::dashboard();
		}
	}

	public static function uploadhistory($filename){
		$query = 'INSERT INTO uploads (user, filename) VALUES (:user, :file)';
		$args = array(':user' => $_SESSION['id'],':file' => $filename);
		return DB::run($query, $args);
	}
}
?>