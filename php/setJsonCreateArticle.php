<?php

include("../../php_conf/config1.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');


if(isset($_REQUEST['prefix']))
    $prefix = $_REQUEST['prefix'];
    else
        return "-1";

if(isset($_REQUEST['article']))
    $article = $_GET['article'];
else
    return "-1";


$q = "INSERT INTO articles VALUES(null,'{$prefix}','{$article}','','','','','','','','','','','','','','','','','',0,1,0)";

if ($result = $mysqli->query($q))
    echo "1";
else
    echo "-1";

?>