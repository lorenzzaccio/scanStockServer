<?php

include("../../php_conf/config1.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
$q=$mysqli->query("SELECT * FROM articles");
if ($q) {
    echo "ok";
} else {
    echo "error";
}
