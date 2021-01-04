<?php
    include("../../../php_conf/config1.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];

$data = array();
$q="SELECT 
facture.fact_id as fact_id,
facture.fact_num as fact_num,
client_nom,
facture.fact_date as fact_date,
format(fact1.fact_total_ht*(1+fact1.fact_delai_paiement/100),2) as total_ht,
facture.fact_date_paiement as fact_date_paiement,
facture.fact_ref_paiement as fact_ref_paiement,
facture.fact_type_paiement as fact_type_paiement,
fact1.fact_status as fact_status,
facture.fact_delai_paiement as fact_delai_paiement,
fact1.fact_delai_paiement as tva
FROM facture 
join commandes on facture.fact_com_id=com_id
left join client on client_id=com_client_id
left join facture as fact1 on facture.fact_num=fact1.fact_num and fact1.fact_com_id=0 
where facture.fact_date between '{$dateDeb}' and '{$dateFin}' group by facture.fact_num order by facture.fact_num desc  ";


if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	   $data[]=utf8_encode($row["fact_id"].';'.$row["fact_num"].';'.$row["client_nom"].';'.$row["fact_date"].';'.$row["total_ht"].';'.$row["fact_date_paiement"].';'.$row["fact_ref_paiement"].';'.$row["fact_type_paiement"].';'.$row["fact_status"].';'.$row["fact_delai_paiement"].';'.$row["tva"]);    
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
