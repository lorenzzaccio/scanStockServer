<?php
    include("../../php_conf/config1.php");
    include("Utils.php");
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header('Content-Type: application/json; charset=UTF-8');

$VAR_STATUS = "art_status";
$val=explode(",",$_GET['status']);
$status = implode(" OR ".$VAR_STATUS."=",$val);

$status = $VAR_STATUS."=".$status;

$data = array();



//printf("Jeu de caractère initial : %s\n", $mysqli->character_set_name());

/* Modification du jeu de résultats en utf8 */
if (!$mysqli->set_charset("utf8")) {
    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
    exit();
} else {
    //printf("Jeu de caractères courant : %s\n", $mysqli->character_set_name());
}


$q="SELECT 
art_id,
art_prefix,
art_num,
art_conicite,
art_cran,
art_cannelure,
art_ouverture,
art_grille,
art_adelphe,
art_repere,
art_dimensions,
art_couleur_fond,
art_impression_jupe,
art_impression_tete,
art_status,
art_nombre_alloc,
art_desc
FROM articles 
WHERE 
 ({$status}) AND (art_prefix like 'C__' or art_prefix like 'V__' or art_prefix like 'E__' or art_prefix like 'B__' )";
//echo $q;

if($result=$mysqli->query($q)){
    $index=0;
    while ($row = $result->fetch_assoc()) {
        
        /*printf ("\n%s \n", $row["art_id"]);
        printf ("%s \n", $row["art_prefix"]);
        printf ("%s \n", $row["art_num"]);
        printf ("%s \n", utf8_encode($row["art_conicite"]));
        printf ("%s \n", Encoding::toUTF8($row["art_cannelure"]));
        printf ("%s \n", Encoding::toUTF8($row["art_cran"]));
        printf ("%s \n", Encoding::toUTF8($row["art_ouverture"]));
        printf ("%s \n", Encoding::toUTF8($row["art_grille"]));
        printf ("%s \n", Encoding::toUTF8($row["art_adelphe"])); 
        printf ("%s \n", Encoding::toUTF8($row["art_impression_jupe"]));
        printf ("%s \n", Encoding::toUTF8($row["art_impression_tete"]));
        printf ("%s \n", $row["art_status"]); 
        printf ("%s \n", $row["art_nombre_alloc"]); 
        printf ("%s \n", Encoding::utf8_encode($row["art_desc"])); */
	    $data[]=($row["art_id"].';'.$row["art_prefix"].';'.$row["art_num"].';'.$row["art_conicite"].';'.$row["art_cran"].';'.$row["art_cannelure"].';'.$row["art_ouverture"].';'.$row["art_grille"].';'.$row["art_adelphe"].';'.$row["art_repere"].';'.$row["art_dimensions"].';'.$row["art_couleur_fond"].';'.$row["art_impression_jupe"].';'.$row["art_impression_tete"].';'.$row["art_status"].';'.$row["art_nombre_alloc"].';'.$row["art_desc"]);
        $index++;
    }
    if($index==0){
        echo json_encode(array('groups'=>['-1']));
    }else{
        echo json_encode(array('groups'=>$data));
    }
}else
    echo "-1";
?>
