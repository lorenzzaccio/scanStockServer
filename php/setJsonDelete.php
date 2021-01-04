<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
	
	if(isset($_REQUEST['table']))
		$table = $_REQUEST['table'];
	else{
		echo("Table invalide");
		echo("-1");
		return;
	}
	if(isset($_REQUEST['condition']))
		$condition = $_REQUEST['condition'];
	else{
		echo("condition invalide");
		echo("-1");
		return;
	}


	if(isset($_REQUEST['limit'])){
		$limit = intval($_REQUEST['limit']);
		if($limit==0)
			$limit="";
		else
			$limit = "LIMIT ".$limit;	
	}else 
		$limit = " LIMIT 1";
	
    $data = array();
    $q="DELETE FROM {$table} WHERE {$condition} ".$limit;

    if($result=$mysqli->query($q)){
        echo "1";
    }else{
      echo "-1";
    }
?>
