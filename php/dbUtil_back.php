<?php

final class dbUtil {

    public static function getDb($mysqli,$table, $field,  $condition) {
        $index=0;
        $q = "SELECT {$field} FROM {$table} WHERE {$condition}";
        //echo $q;
        if ($result = $mysqli->query($q)) {
            while ($row = $result->fetch_array()) {
                $data[] = $row[0];
                $index++;
            }
            if ($index == 0) {
                return "-1";
            } else {
                return $data;
            }
        }
    }

    public static function getMaxNumCarton($mysqli, $id) {
        $numCom = dbUtil::getDb($mysqli,"stockScan","stockscan_numCom","stockscan_id='{$id}'");
        $prefix = dbUtil::getDb($mysqli,"stockScan","stockscan_prefix","stockscan_id='{$id}'");
        $article = dbUtil::getDb($mysqli,"stockScan","stockscan_article","stockscan_id='{$id}'");
        $numCarton = dbUtil::getDb($mysqli,"stockScan","MAX(stockscan_numCarton)" ,"stockscan_numCom='{$numCom[0]}' and stockscan_prefix='{$prefix[0]}' and stockscan_article='{$article[0]}'");
        return $numCarton;
    }

    public static function DuplicateMySQLRecord($mysqli, $table, $id_field, $id) {
// load the original record into an array
        $q = "SELECT * FROM {$table} WHERE {$id_field}={$id}";
//echo $q . "<BR>";
        $result = $mysqli->query($q);
        $original_record = mysqli_fetch_assoc($result);

// insert the new record and get the new auto_increment id
        $q = "INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)";
//echo $q . "<BR>";
        $mysqli->query($q);
        $newid = $mysqli->insert_id;

// generate the query to update the new record with the previous values
        $q = "UPDATE {$table} SET ";
        foreach ($original_record as $key => $value) {
            if ($key != $id_field) {
                $q .= '`' . $key . '` = "' . str_replace('"', '\"', $value) . '", ';
            }
        }
        $q = substr($q, 0, strlen($q) - 2); # lop off the extra trailing comma
        $q .= " WHERE {$id_field}={$newid}";
//echo $q . "<BR>";
        $mysqli->query($q);

// return the new id
        return $newid;
    }

    public static function extractFicheProdData($mysqli,$texteFiscal) {
        $data = array();
        $q = " select ficheprod_quantity ,ficheprod_transfo from ficheProduction where ficheprod_transfo like '%'"+$texteFiscal+"'%'";
        if ($result = $mysqli->query($q)) {
            $index = 0;
            while ($row = $result->fetch_array()) {
                $data[] = $row[0] . ";" . $row[1] ;
                $index++;
            }
            if ($index == 0) {
                return "-1";
            } else {
                return $data;
            }
        }
    }
    
    public static function getBonCi($mysqli, $texteFiscal) {
        $data = array();
        $texteFiscalNoSpace = preg_replace('/\s+/', '', $texteFiscal);
        $q = " select sum(quantite) as q,typeTimbre as t,centili as c from ("
                . "( SELECT sum(bon_quantite) as quantite, bon_type_timbre as typeTimbre, bon_centilisation as centili FROM bonsDeCI_CRD "
                . "WHERE bon_texte_fiscal='" . $texteFiscal . "' group by bon_type_timbre, bon_centilisation ) union "
                . "( SELECT -sum(mat_produits) as quantite, mat_type_timbre as typeTimbre, mat_centilisation as centili "
                . "FROM gestion_matiere "
                . "WHERE mat_texte_fiscal='" . $texteFiscal . "' "
                . "and (mat_operation='PROD_CRD' or mat_operation='RETOUR_CLIENT_CRD') "
                . "and mat_date<'2016-06-21' "
                . "group by mat_type_timbre,mat_centilisation ) union "
                . "( select -sum(ficheprod_quantity) as quantite,split_str(ficheprod_transfo,'-',4) as typeTimbre,split_str(ficheprod_transfo,'-',3)/10 as centili FROM ficheProduction where ficheprod_transfo like '%FISCAL' and ficheprod_transfo like '%" . $texteFiscalNoSpace . "%'  and ficheprod_date_prevue>='2016-06-21' and ficheprod_status=3 group by ficheprod_transfo )"
                . ")as total group by typeTimbre,centili ";

        if ($result = $mysqli->query($q)) {
            $index = 0;
            while ($row = $result->fetch_array()) {
                $data[] = $row[0] . ";" . $row[1] . ";" . $row[2];
                $index++;
            }
            if ($index == 0) {
                return "-1";
            } else {
                return $data;
            }
        }
    }
    
    

    public static function getStock($mysqli, $fullArticle) {
        $prefix = Utils::getPrefix($fullArticle);
        $article = Utils::getArticle($fullArticle);
        $q = "SELECT max(stock_date),stock_crd,stock_fromCom FROM stock WHERE stock_pref='" . $prefix . "' and stock_art='" . $article . "'";
        if ($res = $mysqli->query($q)) {
            $obj = $res->fetch_object();
        }

        $stockCrd = $obj->stock_crd;
        $stockMat = $obj->stock_fromCom;
        return array(0 => $stockCrd, 1 => $stockMat);
    }

    public static function checkBonCi($mysqli, $texteFiscal, $typeTimbre, $centilisation) {
        $quantiteBonCi = 0;
        if (!isset($texteFiscal))
            return;
        if (!isset($centilisation))
            return;
        if (!isset($typeTimbre))
            return;

        if ($texteFiscal !== '') {
//type timbre
            $q = " select sum(quantite) as quantity from ("
                    . "SELECT sum(bon_quantite) as quantite "
                    . "FROM bonsDeCI_CRD  "
                    . "WHERE bon_type_timbre='" . $typeTimbre . "' "
                    . "and bon_texte_fiscal='" . $texteFiscal . "' "
                    . "and bon_centilisation='" . $centilisation . "' "
                    . "union "
                    . "select -sum(mat_produits) as quantite "
                    . "FROM gestion_matiere "
                    . "WHERE mat_texte_fiscal='" . $texteFiscal . "' "
                    . "and mat_type_timbre='" . $typeTimbre . "' "
                    . "and mat_centilisation='" . $centilisation . "' "
                    . "and (mat_operation='PROD_CRD' or mat_operation='RETOUR_CLIENT_CRD') "
                    . ") as total";
            if ($res = $mysqli->query($q)) {
                if ($obj = $res->fetch_object()) {
                    $quantiteBonCi = $obj->quantity;
                }
            }
        }
        return $quantiteBonCi;
    }

    public static function getClient($mysqli) {
        $q = "SELECT client_id,client_nom FROM client ORDER BY client_id";
        $i = 0;
        if ($res = $mysqli->query($q)) {
            $arr = array();
            while ($obj = $res->fetch_object()) {
                $arr[$i] = array('id' => $obj->client_id, 'nom_client' => $obj->client_nom);
                $i++;
            }
        }
        return $arr;
    }

    public static function getCentilisation($mysqli) {
        $q = "SELECT DISTINCT(bon_centilisation) FROM bonsDeCI_CRD GROUP by bon_centilisation";
        $i = 0;
        if ($res = $mysqli->query($q)) {
            $arr = array();
            while ($obj = $res->fetch_object()) {
                $arr[$i] = array('bon_centilisation' => $obj->bon_centilisation);
                $i++;
            }
        }
        return $arr;
    }

}
