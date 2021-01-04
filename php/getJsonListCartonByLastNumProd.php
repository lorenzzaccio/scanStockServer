<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
$stockType = $_GET['stockType'];
$data = array();

$q="SELECT * from stockScan WHERE stockscan_numProd like '%{$numProd}' and stockscan_typeStock='{$stockType}'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_id"].";".$row["stockscan_quantite"].";".$row["stockscan_typeStock"].";".$row["stockscan_numProd"];//.";".$row["logProd_status"].";".$row["logProd_timestamp"];
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>