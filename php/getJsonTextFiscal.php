<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$clientId = $_GET['clientId'];
$data = array();
$q="SELECT sitecli_texteFiscal FROM siteClient WHERE sitecli_mere_id='" . $clientId . "'";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row["sitecli_texteFiscal"];
    $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>