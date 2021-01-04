<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
    
$texte = $_GET['texte'];
$type = $_GET['type'];
$centili = $_GET['centili'];
$data = array();

$q="
SELECT distinct(id),date,type,centili,quantity as quant,texte,comment FROM
(
SELECT 
bon_id as id,
bon_date as date,
bon_texte_fiscal COLLATE latin1_general_cs as texte,
bon_type_timbre COLLATE latin1_general_cs as type,
bon_centilisation*10 as centili,
bon_quantite COLLATE latin1_general_cs as quantity,
client_nom as client,
'bon de CI' as comment
FROM bonsDeCI_CRD
LEFT JOIN siteClient on sitecli_texteFiscal=bon_texte_fiscal COLLATE latin1_general_cs
LEFT JOIN client on client_id=sitecli_mere_id COLLATE latin1_general_cs
group by bon_id

UNION

SELECT com_id as id ,
com_date_livraison as date,
sitecli_texteFiscal as texte,
com_type_timbre as type,
com_centilisation*10 as centili,
-com_quantite as quantity,
client_nom as client,
'livraison client' as comment
FROM commandes
LEFT JOIN  siteClient on sitecli_mere_id=com_client_id and sitecli_num=com_client_site
LEFT JOIN client on client_id=sitecli_mere_id COLLATE latin1_general_cs
WHERE com_status_id BETWEEN 5 AND 25 AND com_status_id NOT BETWEEN 15 AND 20 AND 
(com_prefix like 'C__' or  com_prefix like 'V__')
AND com_type_timbre !='EXPORT'
group by com_id

UNION

SELECT com_id as id ,
com_date_livraison as date,
sitecli_texteFiscal as texte,
com_type_timbre as type,
com_centilisation*10 as centili,
com_quantite as quantity,
client_nom as client,
'retour client' as comment
FROM commandes
LEFT JOIN  siteClient on sitecli_mere_id=com_client_id and sitecli_num=com_client_site
LEFT JOIN client on client_id=sitecli_mere_id COLLATE latin1_general_cs
WHERE com_status_id =16  AND 
(com_prefix like 'C__' or  com_prefix like 'V__')
AND com_type_timbre !='EXPORT'
group by com_id

) as bonCi_commandesLivrees
WHERE texte='{$texte}' and type='{$type}' and centili='{$centili}' 
order by date desc
";

//echo $q;

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
	    $data[]=$row["id"].';'.$row["date"].';'.$row["type"].';'.utf8_encode($row["centili"]).';'.utf8_encode($row["quant"]).';'.utf8_encode($row["texte"]).';'.utf8_encode($row["comment"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
