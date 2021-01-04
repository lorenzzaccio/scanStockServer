<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$numProd = $_GET['numProd'];

$data = array();
    $q1="SELECT * FROM stockScan WHERE stockscan_numProd like '%{$numProd}%'";
    if ($result = $mysqli->query($q1)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data1[] = $row;
        }
    }
    
    $q2 ="SELECT * FROM ficheProduction where ficheprod_id={$numProd}";
    if ($result = $mysqli->query($q2)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data2[] = $row;
        }
    }
//$q = "SELECT * FROM stockScan join ficheProduction on  stockScan.stockscan_numProd=ficheProduction.ficheprod_id WHERE stockscan_numProd like '%{$numProd}%'";

//if ($result = $mysqli->query($q)) {
//    while ($row = mysqli_fetch_assoc($result)) {
//        $data[] = $row;
//    }
//}
echo json_encode(array('scan' => $data1,'prod'=>$data2));
?>
