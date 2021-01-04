<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
$data = array();
$q="SELECT * from stockScan WHERE stockscan_numProd like '%{$numProd}%' and (stockscan_typeStock>=40 and stockscan_typeStock<50)";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_id"]."_ Quantité : ".$row["stockscan_quantite"];
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>