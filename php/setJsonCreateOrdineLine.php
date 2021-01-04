<?php
    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/db_mapping.php");
    include("../../scanStockServer/php/codes.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    $ORDINE_CONFIRME = 0;

    $input = array(
        "ord_pref",
        "ord_art",
        "ord_quantite",
        "ord_prix",
        "ord_num",
        "ord_com_num",
        "ord_date",
        "ord_fourn"
    );
    $in_arr = array();

    foreach ($input as $key ){
        if(isset($_REQUEST[$key])){
          $in_arr[$key] = $_REQUEST[$key];
        }
        else{
            echo($key." manquant\n");
            return_code($ERROR_NO_ARG);
            exit();
        }
    }


    $comp=array();
    $comp["ord_date_liv"]="2007-01-01";
    $comp["ord_quantite_liv"]=0;
    $comp["ord_fact_num"]=0;
    $comp["ord_prix_ht"]=0.0;
    $comp["ord_status"]=$ORDINE_CONFIRME;
    $comp["ord_date_paiement"]="2007-01-01";
    $comp["ord_timeStamp"]=date("Y-m-d H:i:s");

    $arg = array(
        'null',
        $in_arr["ord_pref"],
        $in_arr["ord_art"],
        $in_arr["ord_quantite"],
        $in_arr["ord_prix"],
        $in_arr["ord_num"],
        $in_arr["ord_com_num"],
        $in_arr["ord_date"],
        $comp["ord_date_liv"],
        $comp["ord_quantite_liv"],
        $comp["ord_fact_num"],
        $comp["ord_prix_ht"],
        $comp["ord_status"],
        $comp["ord_date_paiement"],
        $in_arr["ord_fourn"],
        $comp["ord_timeStamp"]
      );

      if(!db_mapping::add_ordine_row($mysqli,$arg)){
        return_code($ERROR_ORDINE_DB);
        exit();
      }

?>