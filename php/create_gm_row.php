
	<?php
	    include("../../php_conf/config1.php");
	    include("../../scanStockServer/php/Utils.php");
	    include("../../scanStockServer/php/dbUtil.php");
	    include("../../scanStockServer/php/db_mapping.php");
	    include("../../scanStockServer/php/codes.php");
        include("../../scanStockServer/php/status.php");
	    header("Access-Control-Allow-Origin: *");
	    header("Access-Control-Allow-Methods: GET, POST");
	    header("Content-Type: application/json; charset=UTF-8");
	

        $arg = json_decode(Utils::check_arg_key($data_list));

        if(!add_gestion_matiere_row($mysqli,$arg)){
            return_code($ERROR_ORDINE_DB);
            exit();
        }
    
public static function add_gestion_matiere_row($mysqli,$arg){
            $table_name="gestion_matiere"; 
            $table = array("mat_id"=>[$arg[0],int(11)],
"mat_date"=>[$arg[1],date],
"mat_daa"=>[$arg[2],varchar(24)],
"mat_prefix"=>[$arg[3],varchar(10)],
"mat_article"=>[$arg[4],varchar(8)],
"mat_expediteur"=>[$arg[5],varchar(250)],
"mat_texte_fiscal"=>[$arg[6],varchar(50)],
"mat_compteur_debut"=>[$arg[7],int(15)],
"mat_compteur_fin"=>[$arg[8],int(11)],
"mat_dechets"=>[$arg[9],int(11)],
"mat_produits"=>[$arg[10],int(11)],
"mat_type_timbre"=>[$arg[11],varchar(25)],
"mat_centilisation"=>[$arg[12],double],
"mat_droits_crd"=>[$arg[13],int(11)],
"mat_timestamp"=>[$arg[14],timestamp],
"mat_coups_vide"=>[$arg[15],int(11)],
"mat_machine"=>[$arg[16],varchar(32)],
"mat_poubelle"=>[$arg[17],varchar(10)],
"mat_article_base"=>[$arg[18],varchar(8)],
"mat_operation"=>[$arg[19],varchar(32)],
"mat_num_ordre"=>[$arg[20],int(11)]
);  
          return dbUtil::add_sql_row($mysqli,$table_name,$table);
        }
?>