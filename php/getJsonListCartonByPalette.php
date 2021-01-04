<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$numPalette = $_GET['numPalette'];
$data = array();
$q="SELECT stockscan_id,
stockscan_quantite,
stockscan_typeStock,
stockscan_numProd,
stockscan_prefix,
stockscan_article
FROM stockScan 
WHERE stockscan_palette='{$numPalette}' AND 
 (stockscan_typeStock=0 OR
 stockscan_typeStock=1 OR
 stockscan_typeStock=2 OR
 stockscan_typeStock=3)";
//echo "here";
//echo $q;
 $numProd=0;
 $val="0";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        if($row["stockscan_numProd"]==""){
            //echo"0";
            $row["stockscan_numProd"]="0";
        }

	   $data[]=$row["stockscan_id"].';'.$row["stockscan_quantite"].';'.$row["stockscan_typeStock"].';'.$row["stockscan_numProd"].';'.$row["stockscan_prefix"].';'.$row["stockscan_article"];
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-2";
?>