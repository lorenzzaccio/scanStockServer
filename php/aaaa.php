
	<?php
	    include("../../php_conf/config1.php");
	    include("../../scanStockServer/php/Utils.php");
	    include("../../scanStockServer/php/dbUtil.php");
	    include("../../scanStockServer/php/db_mapping.php");
	    include("../../scanStockServer/php/codes.php");
	    header("Access-Control-Allow-Origin: *");
	    header("Access-Control-Allow-Methods: GET, POST");
	    header("Content-Type: application/json; charset=UTF-8");
	
public static function add_new_gestion_matiere_row($mysqli,$arg){
        $table_name="new_gestion_matiere"; 
        $table = array("mat_id"=>[$arg[0],int(11)],
"mat_date"=>[$arg[1],date],
"mat_daa"=>[$arg[2],varchar(24)],
"mat_expediteur"=>[$arg[3],varchar(250)],
"mat_compteur_debut"=>[$arg[4],int(15)],
"mat_compteur_fin"=>[$arg[5],int(11)],
"mat_dechets"=>[$arg[6],int(11)],
"mat_timestamp"=>[$arg[7],timestamp],
"mat_coups_vide"=>[$arg[8],int(11)],
"mat_poubelle"=>[$arg[9],varchar(10)],
"mat_operation"=>[$arg[10],varchar(32)],
"mat_machine"=>[$arg[11],varchar(32)],
"mat_num_prod"=>[$arg[12],int(11)]
);  
      return dbUtil::add_sql_row($mysqli,$table_name,$table);
    }

	?>