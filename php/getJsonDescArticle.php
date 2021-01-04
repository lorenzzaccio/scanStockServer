<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  

$fullArticle = $_GET['fullArticle'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);

$data = array();
$q="SELECT art_prefix,art_num,art_conicite,art_cran,art_cannelure,art_ouverture,art_grille,art_adelphe,art_repere,art_dimensions,art_couleur_fond,art_impression_jupe,art_impression_tete FROM articles WHERE art_num='" . $article . "' and art_prefix='".$prefix."'";

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        $data[]=utf8_encode($row["art_conicite"].";".$row["art_dimensions"].";".$row["art_couleur_fond"].";".$row["art_impression_jupe"].";".$row["art_impression_tete"]);
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        
        echo json_encode(array('groups'=>$data));
    }
}
?>