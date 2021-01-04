<?php

include("../../php_conf/config1.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  


$data = array();
if(isset($_REQUEST['prefix']))
    $prefix=$_REQUEST['prefix'];
else{
    echo json_encode(array('groups'=>['-1','prefix invalide']));
    return;
}

if(isset($_REQUEST['article']))
    $article=$_REQUEST['article'];
else{
    echo json_encode(array('groups'=>['-1','article invalide']));
    return;
}

$q="select demPrix_num from demandePrix where demPrix_article like '%{$article}%' and demPrix_prefix like '%{$prefix}' and demPrix_status='6' order by demPrix_id desc";//état livré
//echo $q;
$index=0;
if($result=$mysqli->query($q)){
    while ($row = $result->fetch_assoc()) {
    	$data[]=$row["demPrix_num"];
    	$index++;
    }
}

if($index!==0)
    echo json_encode(array('groups'=>$data));
else{
    echo json_encode(array('groups'=>['-1','aucune données']));
}


?>