<?php
    include("../../../php_conf/config1.php");
    include("../../../scanStockServer/php/Utils.php");
    include("../../../scanStockServer/php/dbUtil.php");
    include("../../../scanStockServer/php/codes.php");
    include("../../../scanStockServer/php/status.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
    
    //1-check Args 
    $arg = array(
        'url'=>''
    );

    foreach ($arg as $key=>$value) {
      $arg[$key]=Utils::check_req_arg_key($key);
    }
  	
  	//2-compute args
    $arr_ofx = Utils::get_ofx_to_array($arg['url']);

    //3-SQL 
    foreach ($arr_ofx as $row) {
    	if(Utils::check_row_exist($mysqli,'journal_banque','journ_fit_id="'.$row[9].'"')) {
    	}else{
	    	$str_row = implode("','",$row);
	  		$q="INSERT INTO journal_banque VALUES(null,'{$str_row}')";

	  		if(!$result=$mysqli->query($q)){
				return_code($ERROR_DB_SQL);
				exit;
			}
		}
  	}
  	return_code($OPERATION_SUCCESS);
?>