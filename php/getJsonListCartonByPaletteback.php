<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];
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
sitecli_addr1
FROM commandes 
join siteClient on (com_client_id=sitecli_mere_id and com_client_site=sitecli_num )
WHERE com_date_livraison BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
 (com_status_id=0 OR
 com_status_id=1 OR
 com_status_id=2 OR
 com_status_id=3 OR
 com_status_id=4 OR
 com_status_id=5 OR
 com_status_id=24)";

/*$q="SELECT plan_id as id,plan_delai as delai,plan_color as color,plan_date as plan_date,plan_heure as plan_heure,plan_numProd as numProd, client_nom as client, com_id as numOrdre, ficheprod_transfo as transfo,plan_machine as machine, ficheprod_status as status, com_date_livraison as livraison  from planning join ficheProduction on plan_numProd=ficheprod_id join commandes on ficheprod_ordre=com_id join client on com_client_id=client_id WHERE plan_date between '{$dateDeb}' and '{$dateFin}'";//" and plan_machine='{$machine}'";
*/
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
    $data[]=$row["com_id"].';'.$row["com_prefix"].';'.$row["com_article_id"].';'.$row["com_quantite"].';'.$row["com_client_id"].';'.$row["com_client_site"].';'.$row["com_status_id"].';'.utf8_encode($row["com_desc_ordre"]).';'.$row["com_num_com_client"].';'.$row["com_date_livraison"].';'.$row["com_type_timbre"].';'.$row["com_centilisation"].';'.$row["com_ref_article_client_etiq"].';'.$row["com_type"].';'.utf8_encode($row["sitecli_addr1"]);
    //$data[]=$row;
/*
        $data[]=$row["id"].';'.$row["delai"].';'.$row["color"].';'.$row["plan_date"].';'.$row["plan_heure"].';'.$row["numProd"].';'.$row["numOrdre"].';'.$row["transfo"].';'.utf8_encode($row["client"]).';'.strtolower($row["machine"]).';'.$row["status"].';'.$row["livraison"];*/
        $index++;
    }

    if($index==0){
        echo "-1";
    }else{
      //echo $data[0];
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>