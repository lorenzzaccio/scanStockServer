<?php
    include("../../../php_conf/config1.php");
    include("../../../scanStockServer/php/Utils.php");
    include("../../../scanStockServer/php/dbUtil.php");
    //include("../../../scanStockServer/php/db_mapping.php");
    include("../../../scanStockServer/php/codes.php");
    include("../../../scanStockServer/php/status.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    //1-check Args 
    $arg = array(
        'num_facture'=>'0'
    );
    foreach ($arg as $key=>$value) {
      $arg[$key]=Utils::check_req_arg_key($key);
    }
  	
  	//2-compute args
    $mail_address = Utils::get_mail_address($mysqli,$arg['num_facture']);

    //3-return result
    $data= array(); 
    echo json_encode(array('groups'=>$mail_address));

?>