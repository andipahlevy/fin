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
// $post = str_replace('"','\'',$post);
// $ni = explode('=',urldecode($post));
$param = json_decode($post);
$str = $param->data;
if(!$param->data){
	die;
}
$str = (string) $str;

$fnl = str_replace('"',"'",$str);

// echo $fnl;die;

$myfile = fopen("data.txt", "w") or die("Unable to open file!");


//bersihkan data / reset
// $sql = "DELETE FROM PL4NTAPPS.FIN_TRACKING";
// $st = oci_parse($cons, $sql);
// $r = oci_execute($st, OCI_NO_AUTO_COMMIT);
// if (!$r) {
	// $e = oci_error($st);
// }else{
	// $r = oci_commit($cons);
// }

// foreach($no as $k=>$l){
	// if($k>0 && $k<count($no)){
		$sql = "INSERT INTO PL4NTAPPS.FIN_TRACKING
VALUES($fnl)
";
		
			fwrite($myfile, $sql);
fclose($myfile);
		$st = oci_parse($cons, $sql);
		$r = oci_execute($st, OCI_NO_AUTO_COMMIT);
		if (!$r) {
			$e = oci_error($st);
			
		}else{
			$r = oci_commit($cons);
			
		}
		
		
	// }
// };




// $rsp = [
			// 'code'	=> $code,
			// 'messages'	=> $msg,
		// ];	

// echo json_encode($rsp, JSON_PRETTY_PRINT);