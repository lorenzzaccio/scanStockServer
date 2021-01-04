<?php
    include("../../../php_conf/config1.php");
    include("../Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$data = array();
$q="SELECT offrePrix_id,offrePrix_global_num,offrePrix_num,offrePrix_prefix,offrePrix_index,
offrePrix_quantite,
offrePrix_desc,
offrePrix_comment,
offrePrix_prix_ht,
offrePrix_status,offrePrix_unite FROM offre_global WHERE offrePrix_prefix='T00' order by offrePrix_id desc";

//echo $q;
if($result = mysqli_query($mysqli,$q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	   $data[]=$row["offrePrix_id"].
       ';'.$row["offrePrix_global_num"].
       ';'.$row["offrePrix_num"].
       ';'.$row["offrePrix_prefix"].
       ';'.$row["offrePrix_index"].
       ';'.$row["offrePrix_quantite"].
       ';'.utf8_encode($row["offrePrix_desc"]).
       ';'.utf8_encode($row["offrePrix_comment"]).
       ';'.utf8_encode($row["offrePrix_prix_ht"]).
       ';'.$row["offrePrix_status"].
       ';'.$row["offrePrix_unite"];/*.*/
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
