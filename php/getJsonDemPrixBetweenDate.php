<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];


if(isset($_REQUEST['status'])){
    $val=explode(",",$_REQUEST['status']);
    $status = implode(" OR demPrix_status=",$val);

    $status = "demPrix_status=".$status;
}

/* change character set to utf8 */
if (!$mysqli->set_charset("latin1")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    //printf("Current character set: %s\n", $mysqli->character_set_name());
}

$data = array();
$q="SELECT demPrix_id,
demPrix_num,
demPrix_client,
demPrix_prefix,
demPrix_article,
demPrix_autreQuantite as quantite,
demPrix_quantite as prixHt,
demPrix_date,
demPrix_status,
demPrix_rem as comment,
demPrix_numOffre as ref_offre_fourn,
demPrix_fourn,
demPrix_ordNum,
ord_id,
ord_date_liv
FROM demandePrix
LEFT JOIN ordine on ord_com_num=demPrix_num  and demPrix_prefix = ord_pref and  ord_art =SPLIT_STR(demPrix_article,'-',1) 
WHERE demPrix_date BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
 ({$status}) 
order by demPrix_date desc";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	$data[]=$row["demPrix_id"].';'.$row["demPrix_num"].';'.utf8_encode($row["demPrix_client"]).';'.$row["demPrix_prefix"].';'.$row["demPrix_article"].';'.$row["quantite"].';'.$row["prixHt"].';'.$row["demPrix_date"].';'.$row["demPrix_status"].';'.utf8_encode($row["comment"]).';'.utf8_encode($row["ref_offre_fourn"]).';'.utf8_encode($row["demPrix_fourn"]).';'.utf8_encode($row["demPrix_ordNum"]).';'.utf8_encode($row["ord_id"]).';'.utf8_encode($row["ord_date_liv"]);
        $index++;
    }
//echo "nombre de lignes : ".$index;
    if($index==0){
        echo "-1";
    }else{
      //echo $data[0];
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
