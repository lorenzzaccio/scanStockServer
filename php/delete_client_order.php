<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    include("dbUtil.php");
    include("codes.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
	
	if(isset($_REQUEST['num_ordre']))
		$num_ordre = $_REQUEST['num_ordre'];
	else{
		return_code($ERROR_NO_ARG);
	}

	if (!dbUtil::db_delete_line($mysqli,'ficheProduction','ficheprod_ordre',$num_ordre,''))
		return_code($OPERATION_SUCCESS);
	



	if (dbUtil::db_delete_line($mysqli,'commandes','com_id',$num_ordre,''))
		return_code($OPERATION_SUCCESS);
	else
		return_code($ERROR_DB_SQL);	
	
?>