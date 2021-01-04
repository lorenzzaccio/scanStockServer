<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

$quantity = $_GET['quantity'];
$dechetsCrd = $_GET['dechetsCrd'];
$dechetsMat = $_GET['dechetsMat'];
$transfo = $_GET['transfo'];
$machine = strtolower($_GET['machine']);
$numProd = $_GET['numProd'];
$timeStamp = Utils::getTimeStamp();
$date = date('Y-m-d');
$vides = 0;

$q = "select MAX(mat_compteur_fin) as compteur_fin from new_gestion_matiere where mat_machine='{$machine}'";

    if ($result = $mysqli->query($q)) {
    $correctedCompteurFin=0;
    $row = mysqli_fetch_assoc($result);
    $compteur = $row['compteur_fin'];
    $compteurDeb = $compteur;
    $compteurFin = $compteurDeb + $quantity + $dechetsCrd + $vides;
    if (strtolower($machine) === "marcel") {
        $delta = (4 - $compteurFin % 4);
        $delta = $delta % 4;
        $correctedCompteurFin = $compteurFin + $delta;
        $vides += $delta;
        $compteurFin = $correctedCompteurFin;
    }
    if (strtolower($machine) === "isidore") {
        $delta = (8 - $compteurFin % 8);
        $delta = $delta % 8;
        $correctedCompteurFin = $compteurFin + $delta;
        $vides += $delta;
        $compteurFin = $correctedCompteurFin;
    }
    $q = "INSERT INTO new_gestion_matiere VALUES('0','{$date}','','CAPS-TECH','{$compteurDeb}','{$compteurFin}','{$dechetsCrd}','{$timeStamp}','0','{$dechetsMat}','{$transfo}','{$machine}','{$numProd}')";
    if ($result = $mysqli->query($q)) {
        echo "ok";
    } else {
        echo "ko";
    }
}
?>