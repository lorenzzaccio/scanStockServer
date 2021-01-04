<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$offre_num = $_GET['offre_num'];
$agent = substr($offre_num,0,2);
$offre_num_canon = substr($offre_num,2);


$data = array();
$q="SELECT 
max(SPLIT_STR(offrePrix_num,'-',3)) as offre
FROM offrePrix 
WHERE offrePrix_num like '%{$offre_num_canon}-%'";

//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
    
    while ($row = $result->fetch_assoc()) {
        //echo "<BR> here".$row["offre"];
        $tmp  = $row["offre"];
        if($tmp==null)
            $data[]=$agent  . $offre_num_canon."-1";
        else{
            //$splitter=explode('-', $tmp);
            //echo $tmp;
            $index_offre = intval($tmp) + 1;
            //echo $splitter[0];
            //echo $splitter[1];
            //echo intval($splitter[2]) + 1;
            //echo($splitter[0] . '-' . $splitter[1] . '-'. intval($splitter[2]) + 1);
            //$val = $splitter[0] . '-' . $splitter[1] . '-'. $index_offre;
            $data[]=$agent . $offre_num_canon . '-'. $index_offre;
        }
	    
        $index++;
    }
//echo "nombre de lignes : ".$index;
    if($index==0){
        echo "0";
    }else{
      //echo $data[0];
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
