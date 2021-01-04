<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$num_offre = $_GET['num_offre'];


$data = array();
$q="SELECT 
    max(offreprix_id), 
    offreprix_num as num_offre
    FROM offrePrix 
    WHERE offreprix_num like '{$num_offre}"."_rev%'";

if($result=$mysqli->query($q)){
    if ($row = $result->fetch_assoc()) {
        $tmp  = $row["num_offre"];
        if(!explode("_rev",$tmp)[1])
            $tmp=0;
        else
            $tmp=explode("_rev",$tmp)[1];

        $ind = intval($tmp) + 1;
        $data[]=$num_offre."_rev".$ind;
    }
    else
        $data[]=$num_offre."_rev1";

    echo json_encode(array('groups'=>$data));
}
else
    echo "-1";
?>
