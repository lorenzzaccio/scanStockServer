<?php
	include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/codes.php");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Content-Type: application/json; charset=UTF-8");

	
	// Une nouvelle personne à ajouter
	$p0 = '
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
	';
    $json = file_get_contents('php://input');
    $table=Utils::check_arg_key($json,"table");
    $php_file = Utils::check_arg_key($json,"php_file");

    $p1 = '
        $arg = json_decode(Utils::check_arg_key($data_list));

        if(!add_'.$table.'_row($mysqli,$arg)){
            return_code($ERROR_ORDINE_DB);
            exit();
        }
    ';
    
    $func = Utils::create_add_table_row_function($mysqli,$table);


    $total = $p0."\n".$p1."\n".$func."\n"."?>";

    // Ecrit le contenu dans le fichier, en utilisant le drapeau
    // FILE_APPEND pour rajouter à la suite du fichier et
    // LOCK_EX pour empêcher quiconque d'autre d'écrire dans le fichier
    // en même temps
    file_put_contents($php_file, $total, LOCK_EX);
    return_code($OPERATION_SUCCESS);
?>

