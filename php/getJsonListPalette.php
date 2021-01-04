<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$lieu = $_GET['lieu'];
$data = array();
$q="SELECT distinct(stockscan_palette) FROM stockScan WHERE stockscan_lieu='" . $lieu . "'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_palette"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>