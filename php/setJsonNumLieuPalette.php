<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$numPalette = $_GET['numPalette'];
$numLieu = $_GET['numLieu'];
$data = array();
$q = "UPDATE  stockScan SET stockscan_lieu='" . $numLieu . "' WHERE stockscan_palette='" . $numPalette . "'";
if ($result = $mysqli->query($q)) {
    echo "ok";
} else {
    echo "ko";
}
?>