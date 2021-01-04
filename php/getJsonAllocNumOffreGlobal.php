<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$offre_num = $_GET['offre_num'];
$agent = substr($offre_num,0,2);
$offre_num_canon = substr($offre_num,2);


$data = array();
$q="SELECT 
max(SPLIT_STR(offrePrix_global_num,'-',3)) as offre
FROM offre_global
WHERE offrePrix_global_num like '%{$offre_num_canon}-%'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
        $tmp  = $row["offre"];
        if($tmp==null)
            $data[]=$agent  . $offre_num_canon."-1";
        else{
            $index_offre = intval($tmp) + 1;
            $data[]=$agent . $offre_num_canon . '-'. $index_offre;
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
