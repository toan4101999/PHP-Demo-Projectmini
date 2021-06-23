<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'quanlyxe');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

define('UPLOAD_DIR', 'uploads');
define('UPLOAD_MAX_FILE_SIZE', 10485760); 
define('UPLOAD_ALLOWED_MIME_TYPES', 'image/jpeg,image/png,image/gif,image/jpg');
?>