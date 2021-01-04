<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];


if(isset($_REQUEST['status'])){
    //echo $_REQUEST['status'];
    $val=explode(",",$_REQUEST['status']);
    $status = implode(" OR com_status_id=",$val);

    $status = "com_status_id=".$status;
}

/* change character set to utf8 */
if (!$mysqli->set_charset("latin1")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    //printf("Current character set: %s\n", $mysqli->character_set_name());
}

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
com_prix_au_mille_ht,
liv_num_daa,
offrecom_id,
com_unite,
com_facture_num
FROM commandes 
left join siteClient on (com_client_id=sitecli_mere_id and com_client_site=sitecli_num )
LEFT join offreCom on offrecom_comId=com_id
left join livraison on liv_com_id=com_id
WHERE com_date_livraison between '{$dateDeb}' AND '{$dateFin}'  AND 
 ({$status}) 
  order by com_date_livraison desc, com_id desc ";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	$data[]=utf8_encode($row["com_id"].';'.$row["com_prefix"].';'.$row["com_article_id"].';'.$row["com_quantite"].';'.$row["com_client_id"].';'.$row["com_client_site"].';'.$row["com_status_id"].';'.($row["com_desc_ordre"]).';'.($row["com_num_com_client"]).';'.$row["com_date_livraison"].';'.$row["com_type_timbre"].';'.$row["com_centilisation"].';'.($row["com_ref_article_client_etiq"]).';'.$row["com_type"].';'.($row["sitecli_addr1"]).';'.$row["offrecom_offrenum"].';'.$row["com_ref_article_client"].';'.$row["com_ref_article_client_fact"].';'.$row["com_prix_au_mille_ht_achat"].';'.$row["com_prix_au_mille_ht"].';'.$row["liv_num_daa"].';'.$row["offrecom_id"].';'.$row["com_unite"].';'.$row["com_facture_num"]);
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
