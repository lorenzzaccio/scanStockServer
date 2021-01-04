<?php
    //include("../../php_conf/config/config1.php");
	include("../../php_conf/config1.php");
	include("Utils.php");
    include("dbUtil.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

	$data = array();
	$data[] =  dbUtil::get_new_num_proforma($mysqli);

    echo json_encode(array('groups'=>$data));
?>
