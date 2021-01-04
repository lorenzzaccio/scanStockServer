<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$val=explode(",",$_GET['status']);
$status = implode(" OR stockscan_typeStock=",$val);

$status = "stockscan_typeStock=".$status;

$data = array();
$q="SELECT 
stockscan_id,
stockscan_prefix,
stockscan_article,
stockscan_quantite,
stockscan_timestamp,
stockscan_numProd,
stockscan_palette,
stockscan_lieu,
stockscan_typeStock,
com_ref_article_client,
client_nom,
ficheprod_transfo,com_id,
com_status_id
FROM stockScan 
left join ficheProduction on (stockscan_typeStock>=1 AND ficheprod_id=getNumProd1(stockscan_numProd))
left join commandes on (stockscan_typeStock>=1 AND  com_id=ficheprod_ordre)
left join client on (stockscan_typeStock>=1 AND  client_id=com_client_id)
WHERE 
 ({$status}) AND (stockscan_prefix like 'C__' or stockscan_prefix like 'V__' or stockscan_prefix like 'E__' or stockscan_prefix like 'B__' )";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $numProd="";
        $numProd=explode(";",$row["stockscan_numProd"]);
        //echo "<BR> NumProd=".$numProd[$index] ."<BR>";
        //echo "a1 is: '".implode("','",$numProd)."'<br>";
        $row["stockscan_numProd"] = implode(",",$numProd)."'<br>";
        /*echo "line is ".$data[$index]."'<br>";
        printf ("\n%s \n", $row["stockscan_id"]);
        printf ("%s \n", $row["stockscan_prefix"]);
        printf ("%s \n", $row["stockscan_article"]);
        printf ("%s \n", $row["stockscan_quantite"]);
        printf ("%s \n", $row["stockscan_timestamp"]);
        printf ("%s \n", $row["stockscan_numProd"]);
        printf ("%s \n", $row["stockscan_palette"]);
        printf ("%s \n", $row["stockscan_lieu"]);
        printf ("%s \n", $row["stockscan_typeStock"]); 
        printf ("%s \n", utf8_encode($row["com_ref_article_client"]));
        printf ("%s \n", utf8_encode($row["client_nom"]));
        printf ("%s \n", $row["ficheprod_transfo"]); 
        printf ("%s \n", $row["com_id"]); 
        printf ("%s \n", $row["com_status_id"]); */
	    $data[]=$row["stockscan_id"].';'.$row["stockscan_prefix"].';'.$row["stockscan_article"].';'.$row["stockscan_quantite"].';'.$row["stockscan_timestamp"].';'.$row["stockscan_numProd"].';'.$row["stockscan_palette"].';'.$row["stockscan_lieu"].';'.$row["stockscan_typeStock"].';'.utf8_encode($row["com_ref_article_client"]).';'.utf8_encode($row["client_nom"]).';'.$row["ficheprod_transfo"].';'.$row["com_id"].';'.$row["com_status_id"];
        //echo "line is ".$data[$index];
        $index++;
    }
    //echo "nombre de lignes : ".$index;
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
