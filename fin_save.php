<?php
header("Access-Control-Allow-Headers: Authorization,Content-Type, Content-Range, Content-Disposition, Content-Description,Origin, X-Requested-With, sessionId");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS");
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include ('config_finflow.php');
$cons = oci_connect(DB_USER, DB_PASSWORD, DB_SERVER.'/'.DB_DATABASE) or die ('Connection Failed');
$post = file_get_contents('php://input');
$param = json_decode($post,true);

if(file_exists('fin_upload/file.csv')){
	unlink('fin_upload/file.csv');
} 

move_uploaded_file($_FILES['file_contents']['tmp_name'],'fin_upload/file.csv');

$row = 1;
if (($handle = fopen("fin_upload/file.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	
        $num = count($data);
        // echo "<p> $num fields in line $row: <br /></p>\n";die;
        $row++;
		$fnl = '';
        for ($c=0; $c < $num; $c++) {
			if($c > 0){
				$fnl .= ',';
			}
            $fnl .= "'".str_replace("'",'*',$data[$c])."'"; 
        }
		$sql = "INSERT INTO PL4NTAPPS.FIN_TRACKING_TMP
		VALUES($fnl)
		";
				// echo $sql;die;
		$st = oci_parse($cons, $sql);
		$r = oci_execute($st, OCI_NO_AUTO_COMMIT);
		if (!$r) {
			$r = oci_error($st);
			
		}else{
			$r = oci_commit($cons);
		}
		// echo $r;die;
    }
    fclose($handle);
}