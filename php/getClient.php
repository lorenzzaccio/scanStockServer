<?php
// Developed by TechnologyMantraBlog.com
// Author : Mr. Hrishabh Sharma
// FB : https://www.facebook.com/hrishabh123
// Website : http://technologymantrablog.com/
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
mb_internal_encoding('UTF-8');
include("../php/../../php_conf/config1.php");
include("../php/dbUtil.php");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
echo 'Client : </br><select onchange="getArticle(this.value);" name="client" id="clientList" >';
$toto =  utf8_encode("Sélection Client");
?>
    <option value=""><?php echo utf8_encode("Sélection Client") ?></option>
    <?php
$arr = dbUtil::getClient($mysqli);
$i=0;
while ($i<sizeof($arr, null)) {
    $id=$arr[$i]['id'];
    $nom=$arr[$i]['nom_client'];
    ?>
    <option value="<?php echo $id."-".$nom ; ?>"><?php echo $nom; ?></option>
    <?php
    $i++;
}
echo'</select>';