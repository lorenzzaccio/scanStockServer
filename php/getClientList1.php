<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

val=split(",",$_GET['status']);
$status = implode(" OR stockscan_typeStock=",$val);

$status = "stockscan_typeStock=".$status;
//echo $status;
$data = array();

$q="SELECT DISTINCT(client_id) as id,client_nom  as client FROM client ";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        printf ("ID : %s  Comment : %s \n", $row['id'], $row['client']);
       //$data[]=$row;
        $data[]=$row['id']."-".$row['client'];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>