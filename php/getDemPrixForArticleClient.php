<?php
    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/codes.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    $COMMANDE_CONFIRMEE = 4;

    $table = $_GET['table'];
    $name = $_GET['name'];

    if(isset($_REQUEST['prefix'])){
        $prefix=$_REQUEST['prefix'];
    }else
        return_code($ERROR_DB_SQL);

    if(isset($_REQUEST['article'])){
        $article=$_REQUEST['article'];
    }else
        return_code($ERROR_DB_SQL);

    if(isset($_REQUEST['client_id'])){
        $client_id=$_REQUEST['client_id'];
    }else
        return_code($ERROR_DB_SQL);
    
    $data = array();
    $q="select * from demandePrix where demPrix_article like '%{article}' and demPrix_prefix='{$prefix} and demPrix_client like '{$client_id}%' and demPrix_status=".$COMMANDE_CONFIRMEE;

    if($result=$mysqli->query($q)){
        $row = mysql_fetch_assoc($result);
        $data = $row['demPrix_numOrdre']
        echo json_encode(array('groups'=>[1]));
    }else
      return_code($ERROR_DB_SQL);
    
?>




