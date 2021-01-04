<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$type_prefix = $_GET['type_prefix'];


$data = array();
$q="SELECT 
max(art_num) as article
FROM articles 
WHERE art_prefix like '%{$type_prefix}%'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
        //echo "<BR> here".$row["offre"];
        $tmp  = $row["article"];
        
            
            $article = intval($tmp) + 1;
            $data[]=$article;
        $index++;
    }
    if($index==0){
        echo "0";
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
