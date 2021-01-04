<?php
    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    //include("../../scanStockServer/php/db_mapping.php");
    include("../../scanStockServer/php/codes.php");
    include("../../scanStockServer/php/status.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

 
    //$json = file_get_contents('php://input');
    $fullArticle=Utils::check_req_arg_key("fullArticle");
    $table = "articles";

    $prefix = Utils::getPrefix($fullArticle);
    $article = Utils::getArticle($fullArticle);

    //liste des données à recevoir
    $field = array(
        "art_conicite",
        "art_dimensions",
        "art_couleur_fond",
        "art_impression_jupe",
        "art_impression_tete"
    );

    $conditions = "art_num='" . $article . "' and art_prefix='".$prefix."'";

    $q = "SELECT ".implode(",", $field)." FROM ".$table." WHERE ".$conditions;
    $data = array();

    if($result=$mysqli->query($q)){
        $index=0;
        while ($row = $result->fetch_assoc()) {
            for ($i=0; $i < count($field); $i++) { 
                 # code...
                if($i===0) $line=$row[$field[$i]];
                else
                    $line.=";".$row[$field[$i]];
                
            }
            $data[]=utf8_decode($line);
            $index++;
        }
        if($index===0){
            return_code($ERROR_NO_DATA);
            exit();
        }else{
            
            echo json_encode(array('ok'=>'1','groups'=>$data));
        }
    }

?>