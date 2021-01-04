<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
$COM_STATUS_LIVRE = 6;
$client = $_GET['client'];
$date = date("Y-m-d");
$d1=new DateTime($date);
$interval = date_interval_create_from_date_string("3 years");
date_sub($d1,$interval);
$dateLiv = date_format($d1,"Y-m-d");

$data = array();
$q="SELECT com_id,com_prefix,com_article_id,com_quantite,com_date_livraison,com_centilisation,com_type_timbre,com_status_id FROM commandes WHERE com_status_id>=".$COM_STATUS_LIVRE." and com_prefix not like 'A__' and com_client_id='" . $client . "' and com_date_livraison>='" .$dateLiv. "' order by com_date_livraison desc";
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
    $data[]=$row["com_id"]." ".$row["com_prefix"]."-".$row["com_article_id"]."->".$row["com_quantite"]." ".$row['com_date_livraison']." ".$row['com_centilisation']." ".$row['com_type_timbre'].";;".$row['com_status_id'];
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>
