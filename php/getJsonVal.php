<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$table = $_GET['table'];
$field = $_GET['field'];

$condition = $_GET['condition'];

$data = array();
$q="SELECT '{$field}' FROM '{$table}' WHERE '{$condition}'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row;
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>