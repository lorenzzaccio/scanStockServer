<?php
function update_facture($fact_num,arr){
	$q="select client_tva as tva,client_echeance as delai_paiement,client_compte_paiement,fact_date,sum(fact_total_ht) as total_ht from facture 
        JOIN commandes on fact_com_id=com_id
        JOIN client on client_id=com_client_id
        WHERE fact_num='{$fact_num}' and fact_com_id!=0";

  	if($result=$mysqli->query($q)){
    	$index=0;
    	if ($row = $result->fetch_assoc()) {
        	$fact_tva = $row['tva'];
        	$delai_paiement = $row['delai_paiement'];
        	$compte_paiement = $row['client_compte_paiement'];
        	$fact_date = $row['fact_date'];
        	$fact_total_ht = $row['total_ht'];
    	}else{
      		echo json_encode(array('groups'=>["erreur mysql update facture"]));
      		return;
    	}
  	}else{
    	echo json_encode(array('groups'=>["erreur pas de donnée"]));
    	return;
  	}


  if(isset(arr['fact_date'])){
    $fact_date = addslashes(utf8_decode(arr['fact_date']));
  } 

   $fact_com_id = 0;

  if(isset(arr['fact_tva'])){
    $fact_tva = addslashes(utf8_decode(arr['fact_tva']));
  }
  
  if(isset(arr['fact_date_modif'])){
    $fact_date_modif = addslashes(utf8_decode(arr['fact_date_modif']));
  } else $fact_date_modif = date("Y-m-d");
  
  if($fact_tva==1)
    $fact_tva = "20.0";
  else
    $fact_tva = "0";

  $fact_cout_ht ="0.0";
    
  $fact_type_paiement = 0;
  
  $fact_num_paiement = '';
  
  $fact_date_paiement = '2007-01-01';
  
  $fact_ref_paiement = "";

  $fact_status = 0;
 
  if(isset(arr['fact_date_paiement'])){
    $fact_date_paiement = addslashes(utf8_decode(arr['fact_date_paiement']));
  }else
    $fact_date_paiement = Utils::calcul_echeance($fact_date,$delai_paiement);
 
  $condition = "fact_com_id=0 AND fact_num='{$fact_num}'";
  $row_exist = Utils::check_row_exist($mysqli,"facture",$condition);

  if($row_exist==1){
    $q="UPDATE facture SET  fact_date_modif='{$fact_date_modif}',fact_total_ht='{$fact_total_ht}' WHERE  {$condition}";
    //echo $q;
    if($result=$mysqli->query($q)){
      echo json_encode(array('groups'=>[1]));
    } else echo json_encode(array('groups'=>["erreur mysql update facture"]));
  }else{
    $q="INSERT INTO facture VALUES(null,'{$fact_date}','{$fact_com_id}','{$fact_num}','{$fact_tva}','{$fact_date_modif}','{$fact_total_ht}','{$compte_paiement}','{$fact_type_paiement}','{$fact_num_paiement}','{$fact_date_paiement}','{$fact_ref_paiement}','{$fact_status}')";

  
    if($result=$mysqli->query($q)){
      echo json_encode(array('groups'=>[1]));
    } else echo json_encode(array('groups'=>["erreur mysql update facture"]));
  }

}

?>