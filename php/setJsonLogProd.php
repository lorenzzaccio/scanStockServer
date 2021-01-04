<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$stockId = $_GET['stockId'];
$numProd = $_GET['numProd'];
if($numProd === ""){
    $numProd=0;
}
$userId = $_GET['userId'];
$status = $_GET['status'];
$qCarton = $_GET['qCarton'];
$timeStamp = Utils::getTimeStamp();
//echo $timeStamp;

//$data = array();
$q = "INSERT INTO logProd VALUES('0','".$stockId."','".$numProd."','".$status."','".$qCarton."','".$userId."','".$timeStamp."')";
if ($result = $mysqli->query($q)) {
    echo "ok";
} else {
    echo $q;
}
?>
