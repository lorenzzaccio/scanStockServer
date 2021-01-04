<?php

    include("../../../php_conf/config1.php");
    include("../Utils.php");
    include("../dbUtil.php");
    include("lib_facture.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    
    $data = array();

    if(isset($_REQUEST['fact_num'])){
      $fact_num = addslashes(utf8_decode($_REQUEST['fact_num']));
    }else { echo json_encode(array('groups'=>["fact_num invalide "])); return;}

    
    update_facture($fact_num,$_REQUEST);

?>
