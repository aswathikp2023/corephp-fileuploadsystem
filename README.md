# corephp-fileuploadsystem
core php file system to upload files
.htaccess is added to the project directory and the directory index is index.php. htaccess will restrict access to all files and folders
run localhost/project name/index.php
autoload.php will load all classes and helpers in your project automatically

  * classes are called using namespaces
   * csrf token , will change after page refresh and also after submitting a form
   * input data and file name sanitization htmlspecialchars,Strip_tags and trim()
   * secure password encryption using password_hash and password_verify
   * load login page if user is not logged in otherwise load dashboard
   * upload file - 5MB file size restricted, files with pdf,docx,doc,jpg,png,jpeg extensions are allowed to upload
   * showing error messages and successful messages in login,registration and upload pages
   * for successful uploading and failed uploading logs will be created with ipaddress, uploded user, nre file name ,created timestamp etc
   * successful uploads will be in uploads table
   * a directory will be created outside the root directory ie, /var/store/. a .htaccess file will added to this folder initially to restrict file access . created folder in restricted mode and use chmod($file) if the file is executable
   * user can logout at the end
DB configuration page App/database/DB.php
create user table
 CREATE TABLE `user` (
  `user_id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) AUTO_INCREMENT=1

create logs table
CREATE TABLE logs (
id integer unsigned AUTO_INCREMENT,
user integer NOT NULL,
filename TEXT NOT NULL,
ipaddress varchar(100) NOT NULL,
status varchar(10) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(user) REFERENCES user(user_id)
)AUTO_INCREMENT=1;

create uploads table
CREATE TABLE uploads (
id integer unsigned AUTO_INCREMENT,
user integer NOT NULL,
filename TEXT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(user) REFERENCES user(user_id)
)AUTO_INCREMENT=1;

