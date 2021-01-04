<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
$fullArticle = $_GET['fullArticle'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$data = array();
$q = "SELECT SUM(stockscan_quantite) FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and "
        . "(stockscan_typeStock='0' or "
        . "stockscan_typeStock='1' or "
        . "stockscan_typeStock like'5_' or "
        . "stockscan_typeStock like'5__' or "
        . "stockscan_typeStock='6' )";
if ($result = $mysqli->query($q)) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
echo json_encode(array('groups' => $data));
?>