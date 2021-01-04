<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
    
$lieu = $_GET['lieu'];
$data = array();

$q="SELECT distinct(stockscan_palette) as palette from stockScan WHERE stockscan_lieu = '{$lieu}' and (stockscan_typeStock=0 || stockscan_typeStock=1 || stockscan_typeStock=2 || stockscan_typeStock=3)";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["palette"];
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
