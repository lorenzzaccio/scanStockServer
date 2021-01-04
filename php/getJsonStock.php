<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
$fullArticle = $_GET['fullArticle'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$data = array();
$q="SELECT max(stock_date),stock_crd,stock_fromCom FROM stock WHERE stock_pref='" . $prefix . "' and stock_art='" . $article . "'";
if($result=$mysqli->query($q)){
    
    while ($row = mysqli_fetch_assoc($result)){
    $data[]=$row;
    }
}
echo json_encode(array('groups'=>$data));
?>