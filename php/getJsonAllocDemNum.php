<?php
    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/codes.php");
    include("../../scanStockServer/php/status.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dem_num = $_GET['dem_num'];
$agent = substr($dem_num,0,2);
$dem_num_canon = substr($dem_num,2);


$data = array();
$q="SELECT 
max(SPLIT_STR(demPrix_num,'-',3)) as dem_num
FROM demandePrix 
WHERE demPrix_num like '%{$dem_num_canon}-%'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
        $tmp  = $row["dem_num"];
        if($tmp==null)
            $data[]=$agent  . $dem_num_canon."-1";
        else{
            $index_dem = intval($tmp) + 1;
            $data[]=$agent . $dem_num_canon . '-'. $index_dem;
        }
	    
        $index++;
    }
    if($index==0){
        echo json_encode(array('groups'=>[$dem_num_canon."-1"]));
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    return_code($ERROR_DB_SQL);;
?>
