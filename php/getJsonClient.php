<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$fullArticle = $_GET['fullArticle'];

$prefix = Utils::getPrefix($fullArticle);
$article = sprintf("%08d", Utils::getArticle($fullArticle));
$data = array();
$q="SELECT DISTINCT(client.client_id) as id ,client.client_nom as client FROM client join commandes on client.client_id=commandes.com_client_id WHERE commandes.com_prefix='" . $prefix . "' and commandes.com_article_id='" . $article . "'";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["id"]."-".utf8_encode($row["client"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>