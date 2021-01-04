<?php
final class db_mapping {

    private function __construct() {
        
    }

    public static function add_commandes_row($mysqli,$arg){
	  $table_name="commandes";
var_dump($arg);
	  $table = array(
	    "com_id"=>[$arg[0],"int(10)"],
	    "com_client_id"=>[$arg[1],"int(11)"],
	    "com_client_site"=>[$arg[2],"int(11)"],
	    "com_prefix"=>[$arg[3],"varchar(8)"],
	    "com_article_id"=>[$arg[4],"varchar(8)"],
	    "com_quantite"=>[$arg[5],"int(11)"],
	    "com_date_modif"=>[$arg[6],"date"],
	    "com_status_id"=>[$arg[7],"int(10)"],
	    "com_prix_au_mille_ht"=>[$arg[8],"varchar(100)"],
	    "com_desc_ordre"=>[$arg[9],"varchar(100)"],
	    "com_num_com_client"=>[$arg[10],"varchar(100)"],
	    "com_date_livraison"=>[$arg[11],"date"],
	    "com_facture_num"=>[$arg[12],"int(11)"],
	    "com_centilisation"=>[$arg[13],"double"],
	    "com_type_timbre"=>[$arg[14],"varchar(24)"],
	    "com_ref_article_client"=>[$arg[15],"varchar(256)"],
	    "com_stock_alloue"=>[$arg[16],"double"],
	    "com_stock_commande"=>[$arg[17],"double"],
	    "com_stockfourn_num_commande"=>[$arg[18],"varchar(24)"],
	    "com_ref_article_client_etiq"=>[$arg[19],"varchar(256)"],
	    "com_prix_au_mille_ht_achat"=>[$arg[20],"varchar(100)"],
	    "com_transformation"=>[$arg[21],"tinyint(1)"],
	    "com_type"=>[$arg[22],"int(3)"],
	    "com_ref_article_client_fact"=>[$arg[23],"varchar(256)"],
	    "com_unite"=>[$arg[24],"int(11)"]
	  );
    //echo "coucou";
	  return dbUtil::add_sql_row($mysqli,$table_name,$table);
	}

	public static function add_new_gestion_matiere_row($mysqli,$arg){
  $table_name="new_gestion_matiere";
  $table = array(
    "mat_id"=>[$arg[0],"int(11)"],
    "mat_date"=>[$arg[1],"date"],
    "mat_daa"=>[$arg[2],"varchar(24)"],
    "mat_expediteur"=>[$arg[3],"varchar(250)"],
    "mat_compteur_debut"=>[$arg[4],"int(15)"],
    "mat_compteur_fin"=>[$arg[5],"int(11)"],
    "mat_dechets"=>[$arg[6],"int(11)"],
    "mat_timestamp"=>[$arg[7],"timestamp"],
    "mat_coups_vide"=>[$arg[8],"int(11)"],
    "mat_poubelle"=>[$arg[9],"varchar(10)"],
    "mat_operation"=>[$arg[10],"varchar(32)"],
    "mat_machine"=>[$arg[11],"varchar(32)"],
    "mat_num_prod"=>[$arg[12],"int(11)"]
);

return dbUtil::add_sql_row($mysqli,$table_name,$table);
}

public static function add_ficheproduction_row($mysqli,$arg){
  $table_name="ficheProduction";
  $table = array(
    "ficheprod_id"=>[$arg[0],"int(11)"],
    "ficheprod_ordre"=>[$arg[1],"int(11)"],
    "ficheprod_etape"=>[$arg[2],"int(2)"],
    "ficheprod_pref"=>[$arg[3],"varchar(5)"],
    "ficheprod_art"=>[$arg[4],"varchar(8)"],
    "ficheprod_pref_trans"=>[$arg[5],"varchar(5)"],
    "ficheprod_art_trans"=>[$arg[6],"varchar(8)"],
    "ficheprod_quantity"=>[$arg[7],"int(11)"],
    "ficheprod_transfo"=>[$arg[8],"varchar(64)"],
    "ficheprod_date_prevue"=>[$arg[9],"date"],
    "ficheprod_machine"=>[$arg[10],"varchar(64)"],
    "ficheprod_comment"=>[$arg[11],"varchar(512)"],
    "ficheprod_time"=>[$arg[12],"varchar(6)"],
    "ficheprod_quantiteParCarton"=>[$arg[13],"int(11)"],
    "ficheprod_palette"=>[$arg[14],"varchar(16)"],
    "ficheprod_datedeb"=>[$arg[15],"varchar(10)"],
    "ficheprod_datefin"=>[$arg[16],"varchar(10)"],
    "ficheprod_heuredeb"=>[$arg[17],"varchar(6)"],
    "ficheprod_heurefin"=>[$arg[18],"varchar(6)"],
    "ficheprod_status"=>[$arg[19],"int(11)"],
    "ficheprod_date"=>[$arg[20],"varchar(24)"],
    "ficheprod_orientation"=>[$arg[21],"varchar(8)"],
    "ficheprod_gobelet"=>[$arg[22],"varchar(8)"],
    "ficheprod_sachet"=>[$arg[23],"varchar(8)"],
    "ficheprod_couleurEncre"=>[$arg[24],"varchar(64)"],
    "ficheprod_joinfile"=>[$arg[25],"varchar(256)"]
  );

  return dbUtil::add_sql_row($mysqli,$table_name,$table);
}

public static function add_stockscan_row($mysqli,$arg){
  $table_name="stockScan";
  $table=array(
    "stockscan_id"=>[$arg[0],"int(11) unsigned"],
    "stockscan_prefix"=>[$arg[1],"varchar(3)"],
    "stockscan_article"=>[$arg[2],"int(8)"],
    "stockscan_numCom"=>[$arg[3],"varchar(128)"],
    "stockscan_numProd"=>[$arg[4],"varchar(64)"],
    "stockscan_timestamp"=>[$arg[5],"timestamp"],
    "stockscan_quantite"=>[$arg[6],"int(11)"],
    "stockscan_numCarton"=>[$arg[7],"int(11)"],
    "stockscan_lieu"=>[$arg[8],"int(11)"],
    "stockscan_palette"=>[$arg[9],"varchar(11)"],
    "stockscan_user"=>[$arg[10],"int(11)"],
    "stockscan_status"=>[$arg[11],"int(2) unsigned"],
    "stockscan_typeStock"=>[$arg[12],"int(4) unsigned"]
  );
  return dbUtil::add_sql_row($mysqli,$table_name,$table);
}

public static function add_ordine_row($mysqli,$arg){
	echo("ordine \n");
	$table_name="ordine";
	 $table = array(
	    "ord_id"=>[$arg[0],"int(11)"],
  		"ord_pref"=>[$arg[1],"varchar(5)"],
  		"ord_art"=>[$arg[2],"varchar(8)"],
  		"ord_quantite"=>[$arg[3],"double"],
  		"ord_prix"=>[$arg[4],"varchar(100)"],
  		"ord_num"=>[$arg[5],"varchar(512)"],
  		"ord_com_num"=>[$arg[6],"varchar(512)"],
  		"ord_date"=>[$arg[7],"date"],
  		"ord_date_liv"=>[$arg[8],"date"],
  		"ord_quantite_liv"=>[$arg[9],"double"],
  		"ord_fact_num"=>[$arg[10],"int(32)"],
  		"ord_prix_ht"=>[$arg[11],"varchar(64)"],
  		"ord_status"=>[$arg[12],"int(11)"],
  		"ord_date_paiement"=>[$arg[13],"date"],
  		"ord_fourn"=>[$arg[14],"int(11)"],
  		"ord_timeStamp"=>[$arg[15],"timestamp"]
	  );
	  return dbUtil::add_sql_row($mysqli,$table_name,$table);
	}
}
?>
