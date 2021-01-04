<?php

include("../../php_conf/config1.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  

$data = array();
if(isset($_REQUEST['letter']))
    $letter=$_REQUEST['letter'];
else
    echo "-1";

$q="select max(SUBSTRING(art_num,5,8)) as num from articles WHERE art_prefix like '{$letter}__'";
//echo $q;
if($result=$mysqli->query($q)){
    $row = $result->fetch_assoc();
    $data[]=str_pad(intval(utf8_encode($row["num"]))+1,8,'0',STR_PAD_LEFT);
    echo json_encode(array('groups'=>$data));
}else
    echo "-1";
?>