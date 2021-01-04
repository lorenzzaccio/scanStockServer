<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];
$machine = $_GET['machine'];
$data = array();

$q="SELECT plan_id as id,plan_delai as delai,plan_color as color,plan_date as plan_date,plan_heure as plan_heure,plan_numProd as numProd, client_nom as client, com_id as numOrdre, ficheprod_transfo as transfo,plan_machine as machine, ficheprod_status as status, com_date_livraison as livraison  from planning join ficheProduction on plan_numProd=ficheprod_id join commandes on ficheprod_ordre=com_id join client on com_client_id=client_id WHERE plan_date between '{$dateDeb}' and '{$dateFin}'";//" and plan_machine='{$machine}'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["id"].';'.$row["delai"].';'.$row["color"].';'.$row["plan_date"].';'.$row["plan_heure"].';'.$row["numProd"].';'.$row["numOrdre"].';'.$row["transfo"].';'.utf8_encode($row["client"]).';'.strtolower($row["machine"]).';'.$row["status"].';'.$row["livraison"];
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
