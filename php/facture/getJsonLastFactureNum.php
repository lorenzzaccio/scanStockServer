<?php
	include("../../../php_conf/config1.php");
	include("../../../scanStockServer/php/Utils.php");
    include("../../../scanStockServer/php/dbUtil.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

	$data = array();
	$data[] =  dbUtil::get_new_num_facture($mysqli);

    echo json_encode(array('groups'=>$data));
?>
