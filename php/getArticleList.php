<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$data = array();
$q="SELECT art_prefix as prefix ,art_num as article FROM articles where art_prefix like 'C__' or art_prefix like 'V__' or art_prefix like 'E__' or art_prefix like 'B__' order by art_num asc ";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["prefix"]."-".$row["article"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
