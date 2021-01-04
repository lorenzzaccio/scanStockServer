<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
//$prefix = Utils::getPrefix($fullArticle);
//$article = Utils::getArticle($fullArticle);
$data = array();
//$q="SELECT * from (select * from logProd order by logprod_stockId,logprod_timestamp desc, logprod_quantite) as x  where logprod_numProd='{$numProd}'  and (logprod_stockType>=40 and logprod_stockType<50)  group by logprod_stockId ";
/*$q="select * from (
    SELECT o.* FROM `logProd` o                     
    LEFT JOIN `logProd` b 
    ON o.logprod_stockId = b.logprod_stockId AND (o.logprod_timestamp < b.logprod_timestamp or (o.logprod_timestamp = b.logprod_timestamp and o.logprod_id < b.logprod_id))
    WHERE b.logprod_timestamp is NULL and (b.logprod_numProd='{$numProd}' or o.logprod_numProd='{$numProd}') ) as x"
    . " WHERE (logprod_stockType>=40 and logprod_stockType<50)";*/
    $q="SELECT * from stockScan WHERE stockscan_numProd like '%{$numProd}%' and (stockscan_typeStock>=40 and stockscan_typeStock<50)";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["stockscan_id"]."_ Quantité : ".$row["stockscan_quantite"];//.";".$row["logProd_status"].";".$row["logProd_timestamp"];
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>