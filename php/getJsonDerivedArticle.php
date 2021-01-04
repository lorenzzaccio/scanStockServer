<?php
include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$fullArticle = $_GET['fullArticle'];
$prefix = Utils::getPrefix($fullArticle);
$article = sprintf("%08d", Utils::getArticle($fullArticle));

/* change character set to utf8 */
if (!$mysqli->set_charset("latin1")) {
    printf("Error loading character set utf8: %s\n", $mysqli->error);
    exit();
} else {
    //printf("Current character set: %s\n", $mysqli->character_set_name());
}

$data = array();
$q="SELECT mat_prefix as prefix ,mat_article as article FROM gestion_matiere WHERE mat_prefix='" . $prefix . "' and mat_article_base='" . $article . "' and  ( mat_article !='" . $article . "') group by mat_article asc";
//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=$row["prefix"]."-".utf8_encode($row["article"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}
?>