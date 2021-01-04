<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$planId = $_GET['planId'];
$planDate = $_GET['planDate'];
$planHeure = $_GET['planHeure'];
$data = array();

$q = "UPDATE  planning SET plan_date='" . $planDate . "',plan_heure='{$planHeure}' WHERE plan_id='" . $planId . "'";

if ($result = $mysqli->query($q)) {
    echo "ok";
} else {
    echo "ko";
}
?>