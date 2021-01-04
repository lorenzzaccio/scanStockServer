<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$numPalette = $_GET['numPalette'];
$numLieu = $_GET['numLieu'];
$stockId = $_GET['stockId'];
$data = array();
$q = "UPDATE  stockScan SET stockscan_lieu='" . $numLieu . "',stockscan_palette='" . $numPalette . "' WHERE stockscan_id='" . $stockId . "'";
if ($result = $mysqli->query($q)) {
    echo "ok";
} else {
    echo "ko";
}
?>