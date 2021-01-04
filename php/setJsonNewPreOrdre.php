<?php

include("../../php_conf/config1.php");
include("Utils.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

const PREORDRE_ATTENTE_VALIDATION = 0;

$quantity = $_GET['quantity'];
$client = $_GET['client'];
$fullArticle = $_GET['article'];
$prefix = Utils::getPrefix($fullArticle);
$article = Utils::getArticle($fullArticle);
$operation = $_GET['operation'];
$datePrevue = strtolower($_GET['datePrevue']);
$comment = $_GET['comment'];
$user = $_GET['user'];
$timeStamp = Utils::getTimeStamp();
$status=PREORDRE_ATTENTE_VALIDATION;
$numOffre=0;

$q = "INSERT INTO preOrdre VALUES('0','0','{$prefix}','{$article}','{$quantity}','{$client}','{$datePrevue}','{$operation}','{$status}','{$numOffre}','{$comment}','{$user}','{$timeStamp}')";
if ($result = $mysqli->query($q)) {
        echo "ok";
    } else {
        echo "ko";
    }
?>
