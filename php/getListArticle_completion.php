<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 

$data = array();
$q="SELECT art_prefix,art_num FROM articles group by art_num,art_prefix";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["art_prefix"]."-".$row["art_num"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
