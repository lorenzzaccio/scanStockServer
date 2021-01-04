<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    //mb_internal_encoding('UTF-8');
    $offre_id = $_GET['offre_id'];
    $client_id = $_GET['client_id'];
	$site_client=1;
    $prefix = $_GET['prefix'];
    $article = $_GET['article'];
    $quantity = $_GET['quantity'];
	$date_modif = date('Y-m-d');
    $status = 6;   
	$price = $_GET['price'];
	$desc_ordre = '';
    $ref_ordre_client = addslashes(utf8_decode($_GET['ref_ordre']));
	$date_livraison = date('Y-m-d');
	$facture_num=0;
	$com_centilisation=0;
	$com_type_timbre='';    
	$ref_article_client = addslashes(utf8_decode($_GET['ref_article_client']));
	$ref_article_client_etiq = addslashes(utf8_decode($ref_article_client));
	$stock_alloue = 1;
	$stock_commande = 1;
	$stock_fourn_num_commande = 1;    
	$ref_article = $_GET['ref_article'];
	$prix_achat=0;
	$transformation=0;
	$type_produit=-1;
	$ref_article_client_fact = $ref_article_client;
    $unity = intval($_GET['unity']);
  
    $data = array();
    $q="INSERT INTO commandes VALUES(null ,'{$client_id}','{$site_client}','{$prefix}','{$article}','{$quantity}','{$date_modif}','{$status}','{$price}','{$desc_ordre}','{$ref_ordre_client}','{$date_livraison}','{$facture_num}','{$com_centilisation}','{$com_type_timbre}','{$ref_article_client}','{$stock_alloue}','{$stock_commande}','{$stock_fourn_num_commande}','{$ref_article_client_etiq}','{$prix_achat}','{$transformation}','{$type_produit}','{$ref_article_client_fact}','{$unity}')";

    echo $q;
	
    if($result=$mysqli->query($q)){
    	echo "1";
    }else{
      	echo "-1";
    }
?>
