<?php
	include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/codes.php");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Content-Type: application/json; charset=UTF-8");

    // Takes raw data from the request
$json = file_get_contents('php://input');
//print_r($_POST);
// Converts it into a PHP object
$data = json_decode($json);
/*print_r($_POST);
foreach($data as $key => $value) {
         echo $value; // This will show jsut the value f each key like "var1" will print 9
                       // And then goes print 16,16,8 ...
    }*/
    //var_dump($data);
    return_code($OPERATION_SUCCESS);

?>