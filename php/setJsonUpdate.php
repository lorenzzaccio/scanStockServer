<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

    $table = $_GET['table'];
    $name = $_GET['name'];
    if(isset($_REQUEST['type'])){
        $type=$_REQUEST['type'];
    }else
        $type=null;
/*
    if(is_float($_GET['val']) || is_double($_GET['val']) || is_integer($_GET['val']))
            $val = $_GET['val'];
    else
        $val = "'".addslashes($_GET['val'])."'";
*/
    
    if($type==='string' || $type==='date'||$type==='timestamp')    
        $val = "'".addslashes($_GET['val'])."'";
    else
        $val = $_GET['val'];
    
    $condition = $_GET['condition'];
    $data = array();
    $q="UPDATE {$table} SET {$name}={$val} WHERE {$condition} LIMIT 1";

    echo $q;
    if($result=$mysqli->query($q)){
        //echo "1";
        echo json_encode(array('groups'=>[1]));
    }else{
      //echo "-1";
      echo json_encode(array('groups'=>[-1]));
    }
?>