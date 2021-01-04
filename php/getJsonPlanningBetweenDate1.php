<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];
$data = array();
$q="SELECT 
plan_id,
plan_date,
plan_heure,
plan_greffon,
plan_machine,
plan_numProd,
ficheprod_transfo,
ficheprod_comment,
ficheprod_couleurEncre
FROM planning 
JOIN ficheProduction on plan_numProd=ficheprod_id
WHERE plan_date BETWEEN '{$dateDeb}' AND '{$dateFin}' AND ficheprod_status<3";


//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_row()) {
        //printf ("ID : %s  Comment : %s \n", $row[0], $row[8]);
        //$comment = utf8_encode($row[8]);
        //$row[8] = $comment;
	   $data[]=$row;
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        header('Content-Type: application/json');
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
