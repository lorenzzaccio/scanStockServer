<?php
    include("../../../php_conf/config1.php");
    include("../Utils.php");
    include("../dbUtil.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    $data = array();
    
    if(isset($_REQUEST['fact_com_id'])){
      $fact_com_id = addslashes(utf8_decode($_REQUEST['fact_com_id']));
      $com_quantite = intVal(dbUtil::get_Db($mysqli,"commandes","com_quantite","com_id=".$fact_com_id));
      $com_prix_au_mille_ht = floatVal(dbUtil::get_Db($mysqli,"commandes","com_prix_au_mille_ht","com_id=".$fact_com_id));
      $com_unite = intVal(dbUtil::get_Db($mysqli,"commandes","com_unite","com_id=".$fact_com_id));
    }else {echo json_encode(array('groups'=>["com_id invalide"])); return;}


    if(isset($_REQUEST['fact_num'])){
      $fact_num = addslashes(utf8_decode($_REQUEST['fact_num']));
    }else { echo json_encode(array('groups'=>["fact_num invalide"])); return;}

    if(isset($_REQUEST['fact_cout_ht'])){
        $fact_cout_ht = addslashes(utf8_decode($_REQUEST['fact_cout_ht']));
      } else $fact_cout_ht ="0.0";

    //calcul fact_total HT
    $fact_total_ht = floatVal($com_quantite*$com_prix_au_mille_ht/$com_unite);

    if(Utils::check_row_exist($mysqli,"facture","fact_num='{$fact_num}' AND fact_com_id='{$fact_com_id}'")){
      dbUtil::db_update_line("facture","fact_total_ht",$fact_total_ht,"fact_num='{$fact_num}' AND fact_com_id='{$fact_com_id}'");

      dbUtil::db_update_line("facture","fact_cout_ht",$fact_cout_ht,"fact_num='{$fact_num}' AND fact_com_id='{$fact_com_id}'");

      dbUtil::update_total_facture($fact_num);
    }else{  

      if(isset($_REQUEST['fact_date'])){
        $fact_date = addslashes(utf8_decode($_REQUEST['fact_date']));
      } else $fact_date = date("Y-m-d");

      if(isset($_REQUEST['fact_delai_paiement'])){
        $fact_delai_paiement = addslashes(utf8_decode($_REQUEST['fact_delai_paiement']));
      } else $fact_delai_paiement = '45fdm';
      
      if(isset($_REQUEST['fact_date_modif'])){
        $fact_date_modif = addslashes(utf8_decode($_REQUEST['fact_date_modif']));
      } else $fact_date_modif = date("Y-m-d");
      
      if(isset($_REQUEST['fact_total_ht'])){
        $fact_total_ht = addslashes(utf8_decode($_REQUEST['fact_total_ht']));
      } else $fact_total_ht = "0.0";
      
      
        
      if(isset($_REQUEST['fact_type_paiement'])){
        $fact_type_paiement = addslashes(utf8_decode($_REQUEST['fact_type_paiement']));
      } else $fact_type_paiement=dbUtil::get_compte_paiement($mysqli,$fact_com_id);
      
      if(isset($_REQUEST['fact_num_paiement'])){
        $fact_num_paiement = addslashes(utf8_decode($_REQUEST['fact_num_paiement']));
      } else $fact_num_paiement = '';
     
      if(isset($_REQUEST['fact_date_paiement'])){
        $fact_date_paiement = addslashes(utf8_decode($_REQUEST['fact_date_paiement']));
      } else {
          $fact_date_paiement = Utils::calcul_echeance($fact_date,$fact_delai_paiement);
      }

      if(isset($_REQUEST['fact_ref_paiement'])){
        $fact_ref_paiement = addslashes(utf8_decode($_REQUEST['fact_ref_paiement']));
      } else $fact_ref_paiement = "";

        if(isset($_REQUEST['fact_status'])){
        $fact_status = addslashes(utf8_decode($_REQUEST['fact_status']));
      } else $fact_status = "0";
     

      $q="INSERT INTO facture VALUES(null,'{$fact_date}','{$fact_com_id}','{$fact_num}','{$fact_delai_paiement}','{$fact_date_modif}','{$fact_total_ht}','{$fact_cout_ht}','{$fact_type_paiement}','{$fact_num_paiement}','{$fact_date_paiement}','{$fact_ref_paiement}','{$fact_status}')";
    //echo $q;
      //file_put_contents($file, $q,FILE_APPEND );
      
      if($result=$mysqli->query($q)){
        echo json_encode(array('groups'=>[1]));
      } else 
    	 echo json_encode(array('groups'=>["erreur mysql : ".$q]));
  }
?>
