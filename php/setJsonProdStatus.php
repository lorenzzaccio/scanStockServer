<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
$status = $_GET['status'];
$data = array();
$q = "UPDATE  ficheProduction SET ficheprod_status='" . $status . "' WHERE ficheprod_id='" . $numProd . "'";
if ($result = $mysqli->query($q)) {
    echo $status;
} else {
    echo "-1";
}
?>