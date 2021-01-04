<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$type_prefix = $_GET['type_prefix'];


$data = array();
$q="SELECT 
LPAD(MAX(SUBSTR(LPAD(art_num,8,0),5,4))+1,8,0) as article
FROM articles 
WHERE art_prefix like '%{$type_prefix}%'";

if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
            $data[]=$row["article"];
        $index++;
    }
    if($index==0){
        echo json_encode(array('groups'=>["0"]));
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo json_encode(array('groups'=>["-1"]));
?>
