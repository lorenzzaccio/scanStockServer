<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 

$data = array();
$q="SELECT fourn_id,fourn_nom FROM fournisseur WHERE (fourn_type=1 || fourn_type=2) order by fourn_id";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["fourn_id"]."-".utf8_encode($row["fourn_nom"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
