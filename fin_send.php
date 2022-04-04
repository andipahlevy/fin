<?php
$file_name_with_full_path = 'fileku.csv';
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
