<?php
    include("../../../php_conf/config1.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];

$data = array();
$q="SELECT 
avoir.av_id as av_id,
avoir.av_num as av_num,
client_nom,
avoir.av_date as avoir_date,
format(sum(avoir.av_total_ht),2) as total_ht,
avoir.av_date as av_date_paiement,
'nop' as av_ref_paiement,
avoir.av_type_paiement as av_type_paiement,
com_status_id,
avoir.av_delai_paiement as av_delai_paiement,
av1.av_delai_paiement as tva
FROM avoir 
left join commandes on avoir.av_com_id=com_id
left join client on client_id=com_client_id
left join avoir as av1 on avoir.av_num=av1.av_num and av1.av_com_id=0 
where avoir.av_date between '{$dateDeb}' and '{$dateFin}' group by avoir.av_num order by avoir.av_num desc";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	$data[]=utf8_encode($row["av_id"].';'.$row["av_num"].';'.$row["client_nom"].';'.$row["av_date"].';'.$row["total_ht"].';'.$row["av_date_paiement"].';'.$row["av_ref_paiement"].';'.$row["av_type_paiement"].';'.$row["com_status_id"].';'.$row["av_delai_paiement"].';'.$row["tva"]);      
	$index++;
    }
	$tot1=strlen(json_encode(array('groups'=>$data)));
	header("Content-length:".intval($tot1));
    if($index==0){
        echo json_encode(array('groups'=>["-1"]));
    }else{
		echo json_encode(array('groups'=>$data));
    }
}else
    echo json_encode(array('groups'=>["-1"]));
?>
