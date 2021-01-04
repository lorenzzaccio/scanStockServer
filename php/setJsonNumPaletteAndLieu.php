<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numPalette = $_GET['numPalette'];
$numCarton = $_GET['numCarton'];
$numCom = $_GET['numCom'];
$numLieu = $_GET['numLieu'];
$data = array();
$q = "UPDATE  stockScan SET stockscan_lieu='" . $numLieu . "' WHERE stockscan_numCarton='" . $numCarton . "' and stockscan_numCom='" . $numCom . "'";
if ($result = $mysqli->query($q)) {
    $q1 = "UPDATE  stockScan SET stockscan_palette='" . $numPalette . "' WHERE stockscan_numCarton='" . $numCarton . "' and stockscan_numCom='" . $numCom . "'";
    if ($result = $mysqli->query($q1)) {
        echo "ok";
    } else {
        echo "ko";
    }
} else {
    echo "ko";
}
?>