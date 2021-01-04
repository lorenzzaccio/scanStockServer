<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');


$data = array();


$q="SELECT 
client_id as id,
client_nom as nom,
client_adresse1 as addr1,
client_adresse2 as addr2,
client_adresse3 as addr3,
client_echeance as echeance,
client_email_fact as email_fact,
client_tva as tva,
client_compte_paiement as compte_paiement,
sitecli_id as site_id,
sitecli_nom as site,
sitecli_num as site_num,
sitecli_addr1 as liv_addr1,
sitecli_addr2 as liv_addr2,
sitecli_addr3 as liv_addr3,
sitecli_fact_addr1 as fact_addr1,
sitecli_fact_addr2 as fact_addr2,
sitecli_fact_addr3 as fact_addr3,
sitecli_active as site_actif,
sitecli_texteFiscal as texteFiscal,
sitecli_accise as accise,
sitecli_tel as tel,
sitecli_mail as mail
FROM client join siteClient on sitecli_mere_id=client_id
order by client_id desc";

//echo $q;

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	$data[]=utf8_encode($row["id"].";".$row["nom"].";".$row["addr1"].";".$row["addr2"].";".$row["addr3"].";".$row["echeance"].";".$row["email_fact"].";".$row["tva"].";".$row["compte_paiement"].";".$row["site_id"].";".$row["site"].";".$row["site_num"].";".$row["liv_addr1"].";".$row["liv_addr2"].";".$row["liv_addr3"].";".$row["fact_addr1"].";".$row["fact_addr2"].";".$row["fact_addr3"].";".$row["site_actif"].";".$row["texteFiscal"].";".$row["accise"].";".$row["tel"].";".$row["mail"]);
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
