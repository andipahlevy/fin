<?php 
header("Access-Control-Allow-Headers: Authorization,Content-Type, Content-Range, Content-Disposition, Content-Description,Origin, X-Requested-With, sessionId");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$code = 200;
$msg = 'Success';
include ('config_finflow.php');
$cons = oci_connect(DB_USER, DB_PASSWORD, DB_SERVER.'/'.DB_DATABASE) or die ('Connection Failed');
print_r($cons);