<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$client = $_GET['client'];
$date = date("Y-m-d");
$d1 = new DateTime($date);
$interval = date_interval_create_from_date_string("2 years");
date_sub($d1, $interval);
$dateLiv = date_format($d1, "Y-m-d");

$data = array();

$q = "
SELECT pref,art from 
(SELECT com_prefix as pref,com_article_id as art FROM commandes 
WHERE (com_prefix like 'C__' or com_prefix like 'V__' or com_prefix like 'E__') 
and com_client_id='" . $client . "'  
and com_date_livraison>='" . $dateLiv . "' and (com_prefix like 'E__' or com_prefix like 'C__' or com_prefix like 'V__')
group by com_article_id order by com_date_livraison desc) as d1
union all
SELECT offrePrix_prefix,offrePrix_article from offrePrix
WHERE offrePrix_clientId='" . $client . "'
and offrePrix_date>='" . $dateLiv . "' and (offrePrix_prefix like 'E__' or offrePrix_prefix like 'C__' or offrePrix_prefix like 'V__')

union ALL
select demPrix_prefix COLLATE latin1_general_ci  as pref,demPrix_article COLLATE latin1_general_ci as art from demandePrix WHERE demPrix_client like '" . $client . "-%'

";
//echo $q;
if ($result = $mysqli->query($q)) {
    $index = 0;
    while ($row = $result->fetch_assoc()) {
        
        $data[] = $row["pref"] . ";" . $row["art"] ;
        $index++;
    }
    if ($index == 0) {
        echo "-1";
    } else {
        echo json_encode(array('groups' => $data));
    }
}

?>
