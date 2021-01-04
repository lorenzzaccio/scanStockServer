<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
$COM_STATUS_LIVRE = 6;
$client = $_GET['client'];
$date = date("Y-m-d");
$d1=new DateTime($date);
$interval = date_interval_create_from_date_string("1 years");
date_sub($d1,$interval);
$dateLiv = date_format($d1,"Y-m-d");
$tva = 0.2;

/* change character set to utf8 */
if (!$mysqli->set_charset("latin1")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    //printf("Current character set: %s\n", $mysqli->character_set_name());
}
$data = array();
$q="SELECT facture.fact_num as num, sum(facture.fact_total_ht) as ht,commandes.com_status_id as status FROM facture inner join commandes on facture.fact_com_id=commandes.com_id WHERE facture.fact_com_id>0 and facture.fact_date>='".$dateLiv."' and commandes.com_prefix not like 'A__' and com_client_id='" . $client . "' group by facture.fact_num order by facture.fact_num desc";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
    $totalTTC=(1+$tva) * floatval($row["ht"]);
    $data[]="N° : ".$row["num"]." -> ".$totalTTC." euros T.T.C. ;;".$row["status"];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
