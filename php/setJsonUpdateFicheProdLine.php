<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$quantity = $_GET['quantity'];
$numProd = $_GET['numProd'];

$q = "update ficheProduction set ficheprod_quantity='{$quantity}'   where ficheprod_id='{$numProd}' limit 1";
//echo $q;
    if ($result = $mysqli->query($q)) {
        echo "ok";
    } else {
        echo "ko";
    }
?>
