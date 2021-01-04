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
    $status = implode(" OR offrePrix_status=",$val);

    $status = "offrePrix_status=".$status;
}
//echo $status;

$data = array();
$q="SELECT offrePrix_id,
offrePrix_num,
offrePrix_clientId,
offrePrix_prefix,
offrePrix_article,
offrePrix_quantite,
offrePrix_prixHt,
offrePrix_date,
offrePrix_demNum,
offrePrix_status,
offrePrix_dateValidation,
offrePrix_refOrdreClient,
offrePrix_period_year,
offrePrix_comment,
offrePrix_solde,
offrePrix_refArticle,
client_nom
FROM offrePrix 
join client on (client_id=offrePrix_clientId)
WHERE offrePrix_date BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
 ({$status}) AND (offrePrix_prefix like 'C__' or offrePrix_prefix like 'V__' or offrePrix_prefix like 'E__' or offrePrix_prefix like '_K__' ) 
 order by offrePrix_date desc";

echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    echo "longueur ".$result->lengths;
    while ($row = $result->fetch_assoc()) {
	$data[] = $row["offrePrix_id"].';'.$row["offrePrix_num"].';'.$row["offrePrix_clientId"].';'.$row["offrePrix_prefix"].';'.$row["offrePrix_article"].';'.$row["offrePrix_quantite"].';'.$row["offrePrix_prixHt"].';'.$row["offrePrix_date"].';'.$row["offrePrix_demNum"].';'.$row["offrePrix_status"].';'.$row["offrePrix_dateValidation"].';'.utf8_encode($row["offrePrix_refOrdreClient"]).';'.$row["offrePrix_period_year"].';'.utf8_encode($row["offrePrix_comment"]).';'.$row["offrePrix_solde"].';'.utf8_encode($row["offrePrix_refArticle"]).';'.utf8_encode($row["client_nom"]);
    //echo $val;
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
