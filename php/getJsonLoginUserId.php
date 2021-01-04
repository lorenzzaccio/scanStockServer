<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$identifiant = $_GET['login'];
$motdepasse = $_GET['pass'];
$data = array();
$q = "SELECT user_id FROM users WHERE user_login='{$identifiant}' and user_pass='{$motdepasse}'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row['user_id'];
    $index++;
    }
    if($index==0){
        echo $q;
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>