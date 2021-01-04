
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

        // Takes raw data from the request

/*$foo = file_get_contents("php://input");
$arr = json_decode($foo, true);
$in_request = $arr["group"];*/

//liste des données à recevoir
$input = array(
	        "com_client_id",
	        "com_client_site",
	        "com_prix_au_mille_ht",
	        "com_rem",
	        "com_num_com_client",
	        "desc"
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
    //var_dump($in_arr);
    $arg=array();
    $arg[0]='null';
    $arg[1]=$in_arr["com_client_id"];
    $arg[2]=$in_arr["com_client_site"];
    $arg[3]="C10";
    $arg[4]=dbUtil::get_new_max_cond($mysqli,"commandes","com_article_id","com_prefix like 'C__'");
    $arg[5]="1";
    $arg[6]=date('Y-m-d');
    $arg[7]=$COM_STATUS_FACTURE;
    $arg[8]=$in_arr["com_prix_au_mille_ht"];
    $arg[9]=$in_arr["com_rem"];
    $arg[10]=$in_arr["com_num_com_client"];
    $arg[11]=date('Y-m-d');
    $arg[12]=0;
    $arg[13]="0";
    $arg[14]="";
    $arg[15]=$in_arr["desc"];
    $arg[16]=0;
    $arg[17]=0;
    $arg[18]="";
    $arg[19]="";
    $arg[20]="0";
    $arg[21]=0;
    $arg[22]=1;
    $arg[23]=$in_arr["desc"];
    $arg[24]=1;

    if(!db_mapping::add_commandes_row($mysqli,$arg)){
        return_code($ERROR_COMMANDE_DB);
        exit();
    }
?>
