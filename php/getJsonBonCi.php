<?php

include("../../php_conf/config1.php");
include("dbUtil.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$texteFiscal = $_GET['texteFiscal'];
$data = array();
$data = dbUtil::getBonCi($mysqli,$texteFiscal);
if ($data=="-1"){
    echo "-1";
}else{
    echo json_encode(array('groups'=>$data));
}
?>