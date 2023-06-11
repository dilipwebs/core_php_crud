<?php 

$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'core_php_crud';

mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $con = new mysqli($servername, $username, $password, $db);
    date_default_timezone_set('Asia/Kolkata');
} catch (Exception $ex) {
    echo "Connection failed: ".$ex->getMessage();
    exit();
}