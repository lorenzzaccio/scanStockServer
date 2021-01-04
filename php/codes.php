<?php

    $OPERATION_SUCCESS=1;
    $ERROR_DB_SQL=-1;
    $ERROR_COM_DB=100;
    $ERROR_FICHEPROD_DB=101;
    $ERROR_STOCKSCAN_DB=102;
    $ERROR_NGM_DB=106;
    $ERROR_ORDINE_DB=103;
    $ERROR_NO_DATA=104;
    $ERROR_COMMANDE_DB=105;
	$ERROR_NO_ARG=120;

    $COM_STATUS_FACTURE=7;

	function return_code($code){
  		echo json_encode(array('groups'=>$code));
	}

?>