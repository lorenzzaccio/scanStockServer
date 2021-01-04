<?php
	include("../../php_conf/config1.php");
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="sample.csv"');

	if(isset($_REQUEST['list_fact'])){
		$list_fact_tmp = explode(",",$_REQUEST['list_fact']);
		$list_fact="fact_num=".implode(" or fact_num=",$list_fact_tmp);
	}
	else
		echo("liste de facture absente");

	//echo $list_fact;
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
	//echo $q;
	if ($result = $mysqli->query($q)) {
		
        while ($row = $result->fetch_array(MYSQLI_NUM)){
        	$data[]=$row;
        }
    }
    $user_CSV=$data;
	// very simple to increment with i++ if looping through a database result 
	//$user_CSV[1] = array('Quentin', 'Del Viento', 34);
	//$user_CSV[2] = array('Antoine', 'Del Torro', 55);
	//$user_CSV[3] = array('Arthur', 'Vincente', 15);

	$fp = fopen('php://output', 'wb');
	foreach ($user_CSV as $line) {
	    // though CSV stands for "comma separated value"
	    // in many countries (including France) separator is ";"
	    fputcsv($fp, $line, ',');
	    //echo(implode(";",$line)."<BR>");
	}
	fclose($fp);
?>