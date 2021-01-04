<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
/*$fullArticle = $_GET['fullArticle'];
$prefix=Utils::getPrefix($fullArticle);
$article= Utils::getArticle($fullArticle);*/

$data = array();
//$q="SELECT distinct(stockscan_lieu) FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "'";
$q="select client_nom from client limit 23";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["client_nom"];
        echo $index."-".utf8_encode($row["client_nom"])."<BR>";
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        //echo "results : ".mysqli_num_rows ( $result )." rows<BR>";
        echo json_encode(array('groups'=>$data));
    }
}else{
    echo "No result found <BR>";
}
?>
