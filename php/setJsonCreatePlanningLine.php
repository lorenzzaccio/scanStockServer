<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    //mb_internal_encoding('UTF-8');
    $duree = $_GET['duree'];
    $greffon = $_GET['greffon'];
    $date = $_GET['date'];
    $heure = $_GET['heure'];
    $prod_id = $_GET['prod_id'];
    $machine = $_GET['machine'];
    
    $data = array();
    $q="INSERT INTO planning VALUES(null ,'{$date}','{$heure}','0','0','0','{$duree}','blue','green','{$prod_id}','{$greffon}','0','{$machine}')";

    echo $q;
    if($result=$mysqli->query($q)){
    	$q1="update ficheProduction set ficheprod_status=1 where ficheprod_id='{$prod_id}'";
    	if($result=$mysqli->query($q1)){
        	echo "1";
        }else
        {
        	echo "-1";
        }
    }else{
      echo "-1";
    }
?>
