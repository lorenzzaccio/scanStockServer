
	<?php
	    include("../../php_conf/config1.php");
	    include("../../scanStockServer/php/Utils.php");
	    include("../../scanStockServer/php/dbUtil.php");
	    include("../../scanStockServer/php/db_mapping.php");
	    include("../../scanStockServer/php/codes.php");
	    header("Access-Control-Allow-Origin: *");
	    header("Access-Control-Allow-Methods: GET, POST");
	    header("Content-Type: application/json; charset=UTF-8");

		echo $_REQUEST['arg'];
		$arr = explode(",",$_REQUEST['arg']);	

		add_ficheProduction_row($mysqli,$arr);

	  function add_ficheProduction_row($mysqli,$arg){
		    $table_name="ficheProduction"; 
			echo ("coucou");
		    $table = array(
			"ficheprod_id"=>[$arg[0],int(11)],
			"ficheprod_ordre"=>[$arg[1],int(11)],
			"ficheprod_etape"=>[$arg[2],int(2)],
			"ficheprod_pref"=>[$arg[3],varchar(5)],
			"ficheprod_art"=>[$arg[4],varchar(8)],
			"ficheprod_pref_trans"=>[$arg[5],varchar(5)],
			"ficheprod_art_trans"=>[$arg[6],varchar(8)],
			"ficheprod_quantity"=>[$arg[7],int(11)],
			"ficheprod_transfo"=>[$arg[8],varchar(64)],
			"ficheprod_date_prevue"=>[$arg[9],date],
			"ficheprod_machine"=>[$arg[10],varchar(64)],
			"ficheprod_comment"=>[$arg[11],varchar(512)],
			"ficheprod_time"=>[$arg[12],varchar(6)],
			"ficheprod_quantiteParCarton"=>[$arg[13],int(11)],
			"ficheprod_palette"=>[$arg[14],varchar(16)],
			"ficheprod_datedeb"=>[$arg[15],varchar(10)],
			"ficheprod_datefin"=>[$arg[16],varchar(10)],
			"ficheprod_heuredeb"=>[$arg[17],varchar(6)],
			"ficheprod_heurefin"=>[$arg[18],varchar(6)],
			"ficheprod_status"=>[$arg[19],int(11)],
			"ficheprod_date"=>[$arg[20],varchar(24)],
			"ficheprod_orientation"=>[$arg[21],varchar(8)],
			"ficheprod_gobelet"=>[$arg[22],varchar(8)],
			"ficheprod_sachet"=>[$arg[23],varchar(8)],
			"ficheprod_couleurEncre"=>[$arg[24],varchar(64)],
			"ficheprod_joinfile"=>[$arg[25],varchar(256)]
		);  
		echo $table;
      	return dbUtil::add_sql_row($mysqli,$table_name,$table);
    }

	?>
