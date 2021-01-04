<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    //mb_internal_encoding('UTF-8');
    $prefix = $_GET['prefix'];
    $article = $_GET['article'];
    
    $data = array();
    $q="SELECT * FROM commandes WHERE com_prefix='{$prefix}' and com_article_id='{$article}'";
    //echo $q;
	
    if($result=$mysqli->query($q))
		$row = $result->fetch_assoc();
    if($row>0)	
		echo json_encode(array('groups'=>["1"]));
    else
       	echo json_encode(array('groups'=>["-1"]));
?>
