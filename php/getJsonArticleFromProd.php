<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$numProd = $_GET['numProd'];
$data = array();
$q="SELECT ficheprod_pref,ficheprod_art FROM ficheProduction WHERE ficheprod_id='" . $numProd . "'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row["ficheprod_pref"]."-".sprintf("%08d",$row["ficheprod_art"]);
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>