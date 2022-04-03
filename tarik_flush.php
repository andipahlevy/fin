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
$post = file_get_contents('php://input');


//bersihkan data / reset
$sql = "DELETE FROM PL4NTAPPS.FIN_TRACKING";
$st = oci_parse($cons, $sql);
$r = oci_execute($st, OCI_NO_AUTO_COMMIT);
if (!$r) {
	$e = oci_error($st);
}else{
	$r = oci_commit($cons);
}