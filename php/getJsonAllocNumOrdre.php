<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$ordre_fourn_num = $_GET['ordre_fourn_num'];
$agent = substr($ordre_fourn_num,0,2);
$ordre_fourn_num_canon = substr($ordre_fourn_num,2);


$data = array();
$q="SELECT 
max(SPLIT_STR(demPrix_num,'-',3)) as ordre_fourn
FROM demandePrix 
WHERE demPrix_num like '%{$ordre_fourn_num_canon}-%'";

if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
        $tmp  = $row["ordre_fourn"];
        if($tmp==null)
            $data[]=$agent  . $ordre_fourn_num_canon."-1";
        else{
           	$index_offre = intval($tmp) + 1;
            $data[]=$agent . $ordre_fourn_num_canon . '-'. $index_offre;
        }
	    
        $index++;
    }
    if($index==0){
        echo "0";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
