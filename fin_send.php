<?php
// header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

$sort = scan_dir('./download');

if(count($sort)){
	$file_name_with_full_path = $sort[0];
	if (function_exists('curl_file_create')) { // php 5.5+
	  $cFile = curl_file_create($file_name_with_full_path);
	} else { // 
	  $cFile = '@' . realpath($file_name_with_full_path);
	}
	$post = array('extra_info' => '123456','file_contents'=> $cFile);
	$ch = curl_init();
	// curl_setopt($ch, CURLOPT_URL,'http://localhost/tmp/finflow/fin_save.php');
	curl_setopt($ch, CURLOPT_URL,'http://custodianqa.tap-agri.com/fin_save.php');
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result=curl_exec ($ch);
	curl_close ($ch);

	print_r($result);	
}


