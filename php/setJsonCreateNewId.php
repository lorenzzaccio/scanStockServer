<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$userId = $_GET['userId'];

$timeStamp = Utils::getTimeStamp();
$data = array();
$q = "INSERT INTO stockScan VALUES('0','C00','0','0','0','" . $timeStamp . "','0','0','0','0','{$userId}','0',0)";
if ($result = $mysqli->query($q)) {
    $q = "SELECT MAX(stockscan_id) as id from stockScan";
    $index=0;
    if ($result = $mysqli->query($q)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["id"];
            $index++;
        }
        if ($index == 0) {
            echo "-1";
        } else {
            echo json_encode(array('groups' => $data));
        }
    } else {
        echo "-1";
    }
}
?>