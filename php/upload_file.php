<?php

    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/codes.php");
    include("../../scanStockServer/php/status.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');
    
    //1-check Args 
    /*$arg = array(
        'url'=>''
    );

    foreach ($arg as $key=>$value) {
      $arg[$key]=Utils::check_req_arg_key($key);
    }*/

$uploaddir = './uploads/';
//echo get_code_file_name()."\n\r";
//echo "file = ".$_REQUEST['myFile']."\n\r";
//echo "file = ".basename($_FILES['myFile']['name']);

$new_file_name = rename_file(basename($_FILES['myFile']['name']),get_code_file_name());
$uploadfile = $uploaddir . $new_file_name;
echo $uploadfile;
echo '<pre>';
if (move_uploaded_file($_FILES['myFile']['tmp_name'], $uploadfile)) {
    echo "Le fichier est valide, et a été téléchargé
           avec succès. Voici plus d'informations :\n";
} else {
    echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :\n";
}

echo 'Voici quelques informations de débogage :';
print_r($_FILES);

echo '</pre>';


function get_code_file_name(){
	$date = date("Ymd");
	$code = str_pad(rand(), 8, "0", STR_PAD_LEFT);
	return $date.$code;
}

function rename_file($file_uri,$new_name){
	$path_parts = pathinfo($file_uri);
	$extension = $path_parts['extension'];
	return $new_name.".".$extension;

}
?>
