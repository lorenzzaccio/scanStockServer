<?php
include "vendor/autoload.php";
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
use mikehaertl\wkhtmlto\Pdf;


if(isset($_GET['num_facture']))
    $num_facture = $_GET['num_facture'];
else{
	echo("Pas de numéro de facture");
	return;
}
$url = "http://127.0.0.1/PhpFormulaire/facture_print.php?num_facture=".$num_facture;//."&cgv";
$cgv = "http://127.0.0.1/PhpFormulaire/cgv.php";
$out_file="facture_".$num_facture.".pdf";

/*
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";*/

// You can pass a filename, a HTML string, an URL or an options array to the constructor
$pdf = new Pdf(array('no-outline',         // Make Chrome not complain
    'print-media-type',
    'disable-smart-shrinking',
    'enable-internal-links',
    'lowquality',
    'margin-top'    => 0,
    'margin-right'  => 0,
    'margin-bottom' => 0,
    'margin-left'   => 0));
$pdf->addPage($url);
$pdf->addPage($cgv);
//$pdf = new Pdf($url);

// On some systems you may have to set the path to the wkhtmltopdf executable
// $pdf->binary = 'C:\...';

if (!$pdf->saveAs($out_file)) {
    throw new Exception('Could not create PDF: '.$pdf->getError());
}

?>