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
	    header("Access-Control-Allow-Origin: *");
	    header("Access-Control-Allow-Methods: GET, POST");
	    header("Content-Type: application/json; charset=UTF-8");
	';
    
    $key="table";

    if(isset($_REQUEST[$key])){
          $table = $_REQUEST[$key];
        }
        else{
            echo($key." manquant\n");
            return_code($ERROR_NO_ARG);
            exit();
    }
    
    $key="php_file";
    if(isset($_REQUEST[$key])){
          $php_file = $_REQUEST[$key];
    }
    else{
        return_code($ERROR_NO_ARG);
        exit();
    }


    $q="select COLUMN_NAME,COLUMN_TYPE FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='capstech' 
        AND `TABLE_NAME`='".$table."';";

  	$p2='public static function add_'.$table.'_row($mysqli,$arg){
        $table_name="'.$table.'"; 
        $table = array(';

    $index=0;
    if($result=$mysqli->query($q)){ 
        $num_rows = $result->num_rows; 

        if($num_rows===0) 
        {
            //echo("nom de table SQL invalide\n");
            return_code($ERROR_NO_ARG);
            exit();
        }

        while ($row = $result->fetch_assoc()) {
          $data[]="\"".$row["COLUMN_NAME"]."\"=>[\$arg[".$index."],".$row["COLUMN_TYPE"]."]";
            if($index<$num_rows-1)
                $line.= $data[$index].",\n";
            else
                $line.= $data[$index]."\n";
            $index++;
        }
    }else{
        return_code($ERROR_NO_ARG);
        exit();
    }

    $p3=');';
  	
  	$p4='  
      return dbUtil::add_sql_row($mysqli,$table_name,$table);
    }

	?>';


$total = $p0."\n".$p2.$line.$p3.$p4;

// Ecrit le contenu dans le fichier, en utilisant le drapeau
// FILE_APPEND pour rajouter à la suite du fichier et
// LOCK_EX pour empêcher quiconque d'autre d'écrire dans le fichier
// en même temps
file_put_contents($php_file, $total, LOCK_EX);
?>