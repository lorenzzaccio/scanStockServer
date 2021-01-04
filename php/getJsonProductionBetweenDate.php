<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$dateDeb = $_GET['dateDeb'];
$dateFin = $_GET['dateFin'];

$data = array();
$q="SELECT 
ficheprod_id,
ficheprod_pref,
ficheprod_art,
ficheprod_pref_trans,
ficheprod_art_trans,
ficheprod_quantity,
ficheprod_transfo,
ficheprod_status,
ficheprod_comment,
ficheprod_date_prevue,
ficheprod_ordre,
ficheprod_couleurEncre,
plan_id,
plan_date,
plan_heure,
plan_delai,
plan_greffon,
plan_machine
FROM ficheProduction 
join commandes on com_id=ficheprod_ordre
left join planning on ficheprod_id=plan_numProd
WHERE ficheprod_date_prevue BETWEEN '{$dateDeb}' AND '{$dateFin}'";


//echo $q;
if($result=$mysqli->query($q)){
    $index=0;
	
	//echo "num=".$result->num_rows."\n";
    while ($row = $result->fetch_row()) {
        //printf ("ID : %s  Comment : %s \n", $row[0], $row[8]);
        //$comment = ($row[8]);
        //$row[8] = $comment;
	   $data[]=$row;
        $index++;
    }
    if($index==0){
        echo "-1";
    }else{
        //header('Content-Type: application/json');
		//echo("here\n".var_dump($data));
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
