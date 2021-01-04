<?php
	include("../../../php_conf/config1.php");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="export_facture.csv"');

	if(isset($_REQUEST['list_fact'])){
		$list_fact_tmp = explode(",",$_REQUEST['list_fact']);
		$list_fact="fact_num=".implode(" or fact_num=",$list_fact_tmp);
	}
	else
		echo("liste de facture absente");

	$data[0] = array('numéro', 'date facturation', 'date de paiement','total_ht','tva','total_ttc');

	$q="select 
	fact_num as numero_facture, 
	fact_date as date_facturation,
	fact_date_modif as date_paiement,
	total_ht,
	tva,
	total_ttc
	from( 
		select fact_num, 
		fact_date,
		fact_date_modif,
		format(fact_total_ht,2) as total_ht,
		format(fact_delai_paiement*fact_total_ht/100,2) as tva,
		format((1+fact_delai_paiement/100)*fact_total_ht,2) as total_ttc
		from facture where ({$list_fact}) and fact_com_id=0 
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