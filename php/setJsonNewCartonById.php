<?php

include("../../php_conf/config1.php");
include("Utils.php");
include("dbUtil.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$stockId = $_GET['stockId'];
$stockIdMere = $_GET['stockIdMere'];

//$newStockId = dbUtil::DuplicateMySQLRecord($mysqli, 'stockScan', 'stockscan_id', $stockIdMere);
//echo "New id=".$newStockId;
//$q = "UPDATE stockScan SET stockscan_quantite='0' WHERE stockscan_id='" . $stockId . "'";
$numCarton = dbUtil::getMaxNumCarton($mysqli,$stockIdMere)[0] + 1;
$numCom = dbUtil::getDb($mysqli,"stockScan","stockscan_numCom","stockscan_id=".$stockIdMere)[0];
$typeStock = dbUtil::getDb($mysqli,"stockScan","stockscan_typeStock","stockscan_id=".$stockIdMere)[0];
$prefix = dbUtil::getDb($mysqli,"stockScan","stockscan_prefix","stockscan_id=".$stockIdMere)[0];
$article = dbUtil::getDb($mysqli,"stockScan","stockscan_article","stockscan_id=".$stockIdMere)[0];
$user = dbUtil::getDb($mysqli,"stockScan","stockscan_user","stockscan_id=".$stockIdMere)[0];
$lieu = dbUtil::getDb($mysqli,"stockScan","stockscan_lieu","stockscan_id=".$stockIdMere)[0];
$palette = dbUtil::getDb($mysqli,"stockScan","stockscan_palette","stockscan_id=".$stockIdMere)[0];
$timeStamp = utils::getTimeStamp();
//echo "num carton = ".$numCarton."<BR>";
//$q = "UPDATE stockScan SET stockscan_prefix='".$prefix."',stockscan_article='".$article."',stockscan_numCom='".$numCom."',stockscan_quantite=0,stockscan_numCarton='".$numCarton."' WHERE stockscan_id='".$stockId."'";
        
$q = "UPDATE stockScan SET stockscan_prefix='{$prefix}',stockscan_article='{$article}',stockscan_numCom='{$numCom}',stockscan_quantite=0,stockscan_numCarton='".$numCarton."',"
        . "stockscan_lieu='{$lieu}',"
        . "stockscan_palette='{$palette}',"
        . "stockscan_user='{$user}',"
        . "stockscan_status=1,"
        . "stockscan_typeStock='{$typeStock}',"
        . "stockscan_timestamp='{$timeStamp}'"
        . " WHERE stockscan_id='".$stockId."'";
       /*
$q = "UPDATE stockScan SET "
        . "stockscan_prefix=Mere.stockscan_prefix,"
        . "stockscan_article=Mere.stockscan_article,"
        . "stockscan_numCom=Mere.stockscan_numCom,"
        . "stockscan_quantite=0,"
        . "stockscan_numCarton='".$numCarton."',"
        . "stockscan_lieu=Mere.stockscan_lieu,"
        . "stockscan_palette=Mere.stockscan_palette,"
        . "stockscan_user=Mere.stockscan_user,"
        . "stockscan_status=1,"
        . "stockscan_typeStock=Mere.stockscan_typeStock"
        . "FROM (SELECT * FROM stockScan WHERE stockscan_id='{$stockIdMere}') as Mere "
        . "WHERE stockscan_id='"+$stockId+"'";
*/
//echo "q=".$q."<BR>";

if ($result = $mysqli->query($q)) {
   /* $q = "UPDATE stockScan SET stockscan_typeStock='" . $typeStock . "' WHERE stockscan_id='" . $newStockId . "'";
    //echo $q."<BR>";
    if ($result = $mysqli->query($q)) {
        $q = "UPDATE stockScan SET stockscan_timestamp='" . Utils::getTimeStamp() . "' WHERE stockscan_id='" . $newStockId . "'";
        //echo $q."<BR>";
        if ($result = $mysqli->query($q)) {
            $q = "UPDATE stockScan SET stockscan_numCarton='" . $stockId . "' WHERE stockscan_id='" . $newStockId . "'";
            //echo $q."<BR>";
            if ($result = $mysqli->query($q)) {*/
                echo "ok";
            } else {
                echo "ko";
            }
       /* } else {
            echo "ko";
        }
    } else {
        echo "ko";
    }
} else {
    echo "ko";
}*/



?>