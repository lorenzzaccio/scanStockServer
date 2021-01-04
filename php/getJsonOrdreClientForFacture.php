<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$facture_num = $_GET['facture_num'];
$data = array();
$q="SELECT com_id,
com_prefix,
com_article_id,
com_quantite,
com_client_id,
com_client_site,
com_status_id,
com_desc_ordre,
com_num_com_client,
com_date_livraison,
com_type_timbre,
com_centilisation,
com_ref_article_client_etiq,
com_type,
sitecli_addr1,
offrecom_offrenum,
com_ref_article_client,
com_ref_article_client_fact,
com_prix_au_mille_ht_achat,
com_prix_au_mille_ht
FROM commandes 
left join siteClient on (com_client_id=sitecli_mere_id and com_client_site=sitecli_num )
LEFT join offreCom on offrecom_comId=com_id
WHERE com_facture_num = '{$facture_num}' order by com_date_livraison desc ";


if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	$data[]=utf8_encode($row["com_id"].';'.$row["com_prefix"].';'.$row["com_article_id"].';'.$row["com_quantite"].';'.$row["com_client_id"].';'.$row["com_client_site"].';'.$row["com_status_id"].';'.utf8_encode($row["com_desc_ordre"]).';'.utf8_encode($row["com_num_com_client"]).';'.$row["com_date_livraison"].';'.$row["com_type_timbre"].';'.$row["com_centilisation"].';'.utf8_encode($row["com_ref_article_client_etiq"]).';'.$row["com_type"].';'.utf8_encode($row["sitecli_addr1"]).';'.$row["offrecom_offrenum"].';'.utf8_encode($row["com_ref_article_client"]).';'.utf8_encode($row["com_ref_article_client_fact"].';'.$row["com_prix_au_mille_ht_achat"].';'.$row["com_prix_au_mille_ht"]));
        $index++;
    }
	$tot1=strlen(json_encode(array('groups'=>$data)));
	header("Content-length:".intval($tot1));

    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
