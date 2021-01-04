<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$stockId = $_GET['stockId'];
$qCarton = $_GET['qCarton'];
$typeStock = $_GET['typeStock'];

$newStockId = dbUtil::DuplicateMySQLRecord($mysqli, 'stockScan', 'stockscan_id', $stockId);
//echo "New id=".$newStockId;
$q = "UPDATE stockScan SET stockscan_quantite='" . $qCarton . "' WHERE stockscan_id='" . $newStockId . "'";
//echo $q."<BR>";
if ($result = $mysqli->query($q)) {
    $q = "UPDATE stockScan SET stockscan_typeStock='" . $typeStock . "' WHERE stockscan_id='" . $newStockId . "'";
    //echo $q."<BR>";
    if ($result = $mysqli->query($q)) {
        $q = "UPDATE stockScan SET stockscan_timestamp='" . Utils::getTimeStamp() . "' WHERE stockscan_id='" . $newStockId . "'";
        //echo $q."<BR>";
        if ($result = $mysqli->query($q)) {
            $q = "UPDATE stockScan SET stockscan_numCarton='" . $stockId . "' WHERE stockscan_id='" . $newStockId . "'";
            //echo $q."<BR>";
            if ($result = $mysqli->query($q)) {
                echo "ok";
            } else {
                echo "ko";
            }
        } else {
            echo "ko";
        }
    } else {
        echo "ko";
    }
} else {
    echo "ko";
}



?>