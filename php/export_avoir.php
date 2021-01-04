<?php
	include("../../php_conf/config1.php");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="export_avoir.csv"');

	if(isset($_REQUEST['list_av'])){
		$list_av_tmp = explode(",",$_REQUEST['list_av']);
		$list_av="av_num=".implode(" or av_num=",$list_av_tmp);
	}
	else
		echo("liste d'avoir absente");

	$data[0] = array('numéro', 'date avoir','total_ht','tva','total_ttc');

	$q="select 
	av_num as numero_avoir, 
	av_date as date_avoir,
	total_ht,
	tva,
	total_ttc
	from( 
		select av_num, 
		av_date,
		av_date_modif,
		format(av_total_ht,2) as total_ht,
		format(av_delai_paiement*av_total_ht/100,2) as tva,
		format((1+av_delai_paiement/100)*av_total_ht,2) as total_ttc
		from avoir where ({$list_av}) and av_com_id=0 
	) as db";

	if ($result = $mysqli->query($q)) {
		
        while ($row = $result->fetch_array(MYSQLI_NUM)){
        	$data[]=$row;
        }
    }
    $user_CSV=$data;

	$fp = fopen('php://output', 'wb');
	foreach ($user_CSV as $line) {
	    fputcsv($fp, $line, ',');
	}
	fclose($fp);
?>