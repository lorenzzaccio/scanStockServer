<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$numProd = $_GET['numProd'];
$data = array();
$q = "SELECT ficheprod_transfo FROM ficheProduction WHERE ficheprod_id='" . $numProd . "'";
//echo $q;
if ($result = $mysqli->query($q)) {
    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $line = explode('-', $row["ficheprod_transfo"]);
        $data[] = array("ficheprod_transfo"=>$line[count($line) - 1]);
        $index++;
    }
    if ($index == 0) {
        echo "-1";
    } else {
        echo json_encode(array('groups' => $data));
    }
}
?>