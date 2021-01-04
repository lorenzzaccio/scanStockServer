<?php
	include("../../../php_conf/config1.php");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="export_remise_cheque.csv"');

	if(isset($_REQUEST['list_fact'])){
		$list_fact_tmp = explode(",",$_REQUEST['list_fact']);
		$list_fact="f.fact_num=".implode(" or f.fact_num=",$list_fact_tmp);
	}
	else
		echo("liste de facture absente");

	$data[0] = array('numéro', 'banque', 'total');

	$q="
	select 
	f.fact_num as numero_facture,
	f2.fact_ref_paiement as banque ,
	format((1+f1.fact_delai_paiement/100)*f1.fact_total_ht,2) as total_ttc 
	from facture as f 
	JOIN facture as f1 on f1.fact_num=f.fact_num and f1.fact_com_id=0
	JOIN facture as f2 on f2.fact_num=f.fact_num and f2.fact_com_id!=0
	where ({$list_fact})
	group by f.fact_num
	";

	//echo $q;
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