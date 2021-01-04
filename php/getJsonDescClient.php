<?php

include("../../php_conf/config1.php");
include("Utils.php");
include("dbUtil.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$idClient = $_GET['idClient'];
$data = array();
$q="SELECT client.client_nom as nom,siteClient.sitecli_nom as site,siteClient.sitecli_addr1 as addr1,siteClient.sitecli_addr2 as addr2,siteClient.sitecli_addr3 as addr3,siteClient.sitecli_texteFiscal as texteFiscal,siteClient.sitecli_accise as accise FROM client join siteClient on siteClient.sitecli_mere_id=client.client_id WHERE client.client_id='" . $idClient . "'";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        //check bon CI
        $texteFiscal = $row["texteFiscal"];
        $bonCi = dbUtil::getBonCi($mysqli,$texteFiscal);
        $data[]=array(utf8_encode($row["nom"].";".$row["site"].";".$row["addr1"].";".$row["addr2"].";".$row["addr3"].";".$row["texteFiscal"].";".$row["accise"]),"bonCi"=>$bonCi);
        /*
        foreach($bonCi as $x => $x_value) {
            echo "Key=" . $x . ", Value=" . $texteFiscal . ", ". $x_value;
            echo "<br>";
        }*/
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}

?>