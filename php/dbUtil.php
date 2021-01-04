<?php


final class dbUtil {

    public static function getDb($mysqli,$table, $field,  $condition) {
        $val='0';
        $q = "SELECT {$field} FROM {$table} WHERE {$condition}";
        //echo $q.'<br>';
        if ($result = $mysqli->query($q)) {
            if ($row = $result->fetch_array()) {
                $val = $row[0];
            }
        }
        return intval($val);
    }

    public static function get_db_row($mysqli,$table,$condition) {
        $q = "SELECT * FROM {$table} WHERE {$condition}";
        if ($result = $mysqli->query($q)) {
            if ($row = $result->fetch_array()) {
                return $row;
            }
        }
        return null;
    }


    public static function console($q){
        echo '<script> console.log("'.$q.'")</script>';
    }

    public static function db_update_line($mysqli,$table, $field,$value,$condition) {
        $val='0';
        $q = "UPDATE {$table} SET {$field}={$value} WHERE {$condition}";
        //
        if ( $mysqli->query($q)) {
            echo '<script> console.log("'.$q.'")</script>';
        }
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
        $q = substr($q, 0, strlen($q) - 2); # loop off the extra trailing comma
        $q .= " WHERE {$id_field}={$newid}";
        //echo $q . "<BR>";
        $mysqli->query($q);

        // return the new id
        return $newid;
    }

    public static function db_copy_row($mysqli,$table,$key_field,$condition){
        $max_id = dbUtil::db_get_max_field($mysqli,$table,$key_field) + 1;
    
        $q="DROP TEMPORARY TABLE IF EXISTS tmptable ;";
        //echo $q;
        if ( $mysqli->query($q)) {} else return 0;
        $q="CREATE TEMPORARY TABLE tmptable SELECT * FROM {$table} WHERE $condition;";
        //echo $q;
        if ( $mysqli->query($q)) {} else return 0;
        $q="UPDATE tmptable SET {$key_field} = {$max_id} WHERE {$condition};";
        //echo $q;
        if ( $mysqli->query($q)) {} else return 0;
        $q="INSERT INTO ${table} SELECT * FROM tmptable;";
        //echo $q;
        if ( $mysqli->query($q)) {} else return 0;
        $q="DROP TEMPORARY TABLE IF EXISTS tmptable ;";
        //echo $q;
        if ( $mysqli->query($q)) {} else return 0;
        
        return $max_id;
    }

    public static function add_sql_row($mysqli,$table_name,$table){
        $liste_values="";
        $index=0;
        foreach ($table as $key => $key_value){
            print_r($key."=".$key_value[0]."=>".$liste_values."\n");
            //check string or date
            if((strpos($key_value[1], "varchar") !== false)||(strpos($key_value[1], "date") !== false)||(strpos($key_value[1], "timestamp") !== false)){
                if($index ===count($table)-1)
                    $liste_values .= "'".$key_value[0]."'";
                else
                    $liste_values .= "'".$key_value[0]."',";
    
            }else{
                if($index ===count($table)-1)
                    $liste_values .=$key_value[0];
                else
                    $liste_values .=$key_value[0].",";
            }
            $index++;
        }
 
        $q = "INSERT INTO {$table_name} VALUES({$liste_values})";
           echo $q;
        if($result=$mysqli->query($q))
            return true;
        else
            return false;
    }

    public static function db_get_max_field($mysqli,$table,$key_field){
        $q="select max({$key_field}) as max from {$table};";

        if ( $get_result=$mysqli->query($q)) {
            if($get_row = $get_result->fetch_assoc()) {
                return intval($get_row["max"]);
            }
        }else{
            return null;
        }
    }

    public static function db_delete_line($mysqli,$table, $field,$value,$condition) {
        $q = "DELETE FROM {$table} WHERE {$field}={$value}  {$condition}";
        //
        if ( $mysqli->query($q)) {
            //echo '<script> console.log("'.$q.'")</script>';
            return true;
        }else
            return false;
    }

	public static function get_new_num_remise($mysqli){
        $q="select MAX(CAST(com_article_id as UNSIGNED)) as max_r from commandes WHERE com_prefix='R00'";
        if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc()) {
                return intval($row["max_r"]) + 1;
            }
        }
        return 0;
    }
    public static function get_new_max($mysqli,$table,$column){
        $q="select MAX(CAST({$column} as UNSIGNED)) as max_r from {$table}";
        if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc()) {
                return intval($row["max_r"]) + 1;
            }
        }
        return 0;
    }

        public static function get_new_max_cond($mysqli,$table,$column,$cond){
        $q="select MAX(CAST({$column} as UNSIGNED)) as max_r from {$table} WHERE {$cond}";
        if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc()) {
                return intval($row["max_r"]) + 1;
            }
        }
        return 0;
    }

    public static function get_new_num_facture($mysqli){
        $q="select MAX(com_facture_num) as max_r from commandes";
        if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc()) {
                return intval($row["max_r"]) + 1;
            }
        }
        return 0;
    }

    public static function get_new_num_ordre($mysqli){
        $q = "select MAX(com_id) as new_id from commandes";
        if($result=$mysqli->query($q)){
        $row = $result->fetch_assoc();
        return intval($row["new_id"]) + 1;
        }else {echo "ko";return 0;}
    }

	public static function get_new_num_proforma($mysqli){
        $q="select MAX(fact_num) as max_r from proforma";
        if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc()) {
                return intval($row["max_r"]) + 1;
            }
        }
        return 0;
    }

	public static function get_compte_paiement($mysqli,$com_id){
		$q="select client_compte_paiement from commandes 
		JOIN client on client_id=com_client_id
		where com_id={$com_id} limit 1";

		if($result=$mysqli->query($q)){
            if($row = $result->fetch_assoc())
			 return $row["client_compte_paiement"];		
            else return 0;
		}else
			return 0;	
	}

    public static function get_compta_gm($mysqli){
        $compteur_deb=0;
        $compteur_fin=0;
        $dechets=0;
        $q="select date, text, type, centi, produit,dechet,debut,fin from
        (
            select mat_date as date,mat_texte_fiscal as text,mat_type_timbre as type,mat_centilisation as centi,mat_produits as produit,mat_dechets as dechet,mat_compteur_debut as debut,mat_compteur_fin as fin 
            from gestion_matiere 
            where mat_date between '2015-01-01' and '2017-12-31'
            and mat_operation='PROD_CRD'
        ) as prod_db
            order by date asc";
        //echo $q."<br>";
       if($result=$mysqli->query($q)){
            $index=0;
            echo("<TABLE class='descProdTable'><THEAD><TR><TD>Date</TD><TD>Texte</TD><TD>Type</TD><TD>Centilisation</TD><TD>Quantité</TD><TD>Déchets</TD><TD>Compteur départ</TD><TD>Compteur fin</TD></TR></THEAD>");
            while ($row = $result->fetch_assoc()) {
                $dechets = intval(rand(10,100));
                $compteur_deb = $compteur_fin;

                $compteur_fin += intval($row["produit"]) + $dechets;
                echo("<TR>"."<TD>".$row["date"]."</TD><TD>".$row["text"]."</TD><TD>".$row["type"]."</TD><TD>".$row["centi"]."</TD><TD>".$row["produit"]."</TD><TD>".$dechets."</TD><TD>".$compteur_deb."</TD><TD>".$compteur_fin."</TD></TR>");
                $index++;
            }
            echo("</TABLE>");
            if($index==0){
                return  0;
            }else
            return 1;
        }else
            return 0;   
    }

    public static function get_compta_ngm_cible($mysqli,$dateDeb,$dateFin,$machine,$param_record,$param_calcul,$compteur_cible){
        dbUtil::console("optimisation compteur cible".$compteur_cible);
        dbUtil::get_compta_ngm($mysqli,$dateDeb,$dateFin,$machine,$param_record,$param_calcul);
    }

    public static function get_compta_ngm($mysqli,$dateDeb,$dateFin,$machine,$param_record,$param_calcul){
        $compteur_deb=0;
        $compteur_fin=0;
        $dechets=0;

        $q="select mid,id,date, text, type, centi, produit,dechet,debut,fin,mid from
        (
            select distinct(ficheprod_id) as id,
            mat_date as date,
            sitecli_texteFiscal COLLATE latin1_swedish_ci as text,
            ficheprod_transfo  COLLATE latin1_swedish_ci as type,
            com_centilisation as centi ,
            ficheprod_quantity as produit,
            mat_dechets as dechet,
            mat_compteur_debut as debut,
            mat_compteur_fin as fin,
            mat_id as mid
            from ficheProduction 
            left join new_gestion_matiere on mat_num_prod=ficheprod_id and (mat_operation='PROD_CRD' or mat_operation='INTER' or mat_operation='INTER_FISCAL')
            left join commandes on ficheprod_ordre=com_id
            left join siteClient on sitecli_mere_id=com_client_id
            where mat_date between '{$dateDeb}' and '{$dateFin}' and mat_machine='{$machine}'
            group by id

            union ALL
            select 
            mat_id as id,
            mat_date as date,
            mat_texte_fiscal as text,
            mat_type_timbre as type,
            mat_centilisation as centi,
            mat_produits as produit,
            mat_dechets as dechet,
            mat_compteur_debut as debut,
            mat_compteur_fin as fin,
            mat_id as mid
            from gestion_matiere 
            where mat_date between '{$dateDeb}' and '{$dateFin}' and mat_machine='{$machine}'
            and (mat_operation='PROD_CRD' or mat_operation='INTER' or mat_operation='INTER_FISCAL')

        ) as prod_db
            order by date asc,mid asc";
        //echo $q."<br>";
       if($result=$mysqli->query($q)){
            $index=0;
            echo("<TABLE id='myTable' class='descProdTable'><THEAD><TR class='header'><TD>MID</TD><TD>ID</TD><TD>Date</TD><TD>Texte</TD><TD>Type</TD><TD>Centilisation</TD><TD>Quantité</TD><TD>Déchets</TD><TD>Compteur départ</TD><TD>Compteur fin</TD></TR></THEAD>");
            while ($row = $result->fetch_assoc()) {
                $id = intval($row["id"]);
                $mid = intval($row["mid"]);
                $date = $row["date"];
                $produits = intval($row["produit"]);
                $dechets = intval($row["dechet"]);

                if($param_calcul==1){
                    if($dechets==0)
                        $dechets = intval(rand(10,$produits*8.5/100));
                }else{
                    $dechets = intval($row["dechet"]);
                }

                if($index==0){
                    $compteur_deb = $row["debut"];
                    $compteur_fin = $compteur_deb;
                }else{
                    $compteur_deb = $compteur_fin;
                }

                $compteur_fin += $produits + $dechets + ($produits + $dechets)%4;

                //analyse d u type de transformation
                $transfo = $row["type"];
                $class='error';
                
                if (strpos($transfo,'VERT') !== false) {
                    $class='vert';
                }
                if (strpos($transfo,'VERT_CHAMPAGNE') !== false) {
                    $class='vertchampagne';
                }
                if (strpos($transfo,'LIE') !== false) {
                    $class='lie';
                }
                if (strpos($transfo,'BLEU') !== false) {
                    $class='bleu';
                }
                if (strpos($transfo,'BLANC') !== false) {
                    $class='blanc';
                }
                if (strpos($transfo,'GRIS') !== false) {
                    $class='gris';
                }
                if (strpos($transfo,'GRIS') !== false) {
                    $class='gris';
                }
                 if (strpos($transfo,'NO_TRANSFO') !== false) {
                    $class='no_transfo';
                }
                if (strpos($transfo,'INTER_FISCAL') !== false) {
                    $class='green_inter';
                }
                if ((strpos($transfo,'INTER') !== false) && (strpos($transfo,'INTER_FISCAL') == false)) {
                    $class='orange';
                }

                $limit_ngm = new DateTime('2016-06-21');
                $current_date = new DateTime($date);
                console("=>".$transfo." : ".$machine);
                //modify machine type according transfo
                if (strpos($transfo,'MAC') !== false) {
                    $class='fluo';
                    $machine='macpneumatique';
                    dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_machine',"'".$machine."'",'mat_id='.$mid);
                }
                if (strpos($transfo,'FAB_COIFFE') !== false) {
                    $class='fluo';
                    $machine='gierlich';
                    console("correction mid=".$mid);
                    dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_machine',"'".$machine."'",'mat_id='.$mid);
                }
                if (strpos($transfo,'NO_TRANSFO') !== false) {
                    dbUtil::db_delete_line($mysqli,'new_gestion_matiere','mat_id',$mid,'limit 1');
                }
                if (strpos($transfo,'DECOUPE') !== false) {
                    $class='fluo';
                    $machine='decoupe';
                    dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_machine',"'".$machine."'",'mat_id='.$mid);
                }
                //echo $current_date->format("Y-m-d")." ".$limit_ngm->format("Y-m-d").'<BR>';
                if($current_date->format("Y-m-d")<$limit_ngm->format("Y-m-d")) {
                    echo("<TR class='gm'>"."<TD class='row_id'>".$row["mid"]."</TD><TD>".$row["id"]."</TD><TD>".$row["date"]."</TD><TD>".$row["text"]."</TD><TD>".$row["type"]."</TD><TD>".$row["centi"]."</TD><TD>".number_format($produits, 0, ',', ' ')."</TD><TD>".number_format($dechets, 0, ',', ' ')."</TD><TD>".number_format($compteur_deb, 0, ',', ' ')."</TD><TD>".number_format($compteur_fin, 0, ',', ' ')."</TD></TR>");
                    if($param_record==1){
                        dbUtil::db_update_line($mysqli,'gestion_matiere','mat_compteur_debut',$compteur_deb,'mat_id='.$mid);
                        dbUtil::db_update_line($mysqli,'gestion_matiere','mat_compteur_fin',$compteur_fin,'mat_id='.$mid);
                        dbUtil::db_update_line($mysqli,'gestion_matiere','mat_dechets',$dechets,'mat_id='.$mid);
                    }
                }else{
                    echo("<TR class='ngm ".$class."'>"."<TD class='row_id'>".$row["mid"]."</TD><TD>".$row["id"]."</TD><TD>".$row["date"]."</TD><TD>".$row["text"]."</TD><TD>".$row["type"]."</TD><TD>".$row["centi"]."</TD><TD>".number_format($produits, 0, ',', ' ')."</TD><TD>".number_format($dechets, 0, ',', ' ')."</TD><TD>".number_format($compteur_deb, 0, ',', ' ')."</TD><TD>".number_format($compteur_fin, 0, ',', ' ')."</TD></TR>");
                    if($param_record==1){
                        dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_compteur_debut',$compteur_deb,'mat_id='.$mid);
                        dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_compteur_fin',$compteur_fin,'mat_id='.$mid);
                        dbUtil::db_update_line($mysqli,'new_gestion_matiere','mat_dechets',$dechets,'mat_id='.$mid);
                    }
                }
                $index++;
            }
            echo("</TABLE>");
            if($index==0){
                return  0;
            }else
            return 1;
        }else
            return 0;   
    }

    public static function get_compta_matiere($mysqli,$dateDeb,$dateFin,$machine){
        $compteur_deb=0;
        $compteur_fin=0;
        $dechets=0;
            echo("<TABLE class='descProdTable'><THEAD><TR><TD>Date</TD><TD>Texte</TD><TD>Type</TD><TD>Centilisation</TD><TD>Quantité</TD><TD>Déchets</TD><TD>Compteur départ</TD><TD>Compteur fin</TD></TR></THEAD>");
            dbUtil::get_compta_gm($mysqli);
            dbUtil::get_compta_ngm($mysqli,$dateDeb,$dateFin,$machine);
            echo("</TABLE>");
    }

    public static function updateDb($mysqli,$value,$table,$field,$condition){
        $q = "UPDATE {$table} SET {$field}=$value WHERE ".$condition;
        $mysqli->query($q);
    }

    public static function createRowDb($mysqli,$table,$values){
        //echo $q.'<br>';
        $q = "INSERT INTO {$table} VALUES({$values})";
        $mysqli->query($q);
    }
    
    public static function write_drm_value($mysqli,$deb,$fin,$type,$centi,$value){
        $id=dbUtil::getDb($mysqli,"drm","drm_id","drm_dateDeb='{$deb}' and drm_dateFin='{$fin}' and drm_type_boisson='{$type}' and drm_centilisation='{$centi}' and drm_type='CHIFFRES_MOIS'");
         if($id>0){
            dbUtil::updateDb($mysqli,$value,"drm","drm_quantite","drm_id='{$id}'");
        }else{
            //echo "null,'CHIFFRES_MOIS','{$deb}','{$fin}','2018-02-15','{$type}','{$centili}','{$value}'";
            dbUtil::createRowDb($mysqli,"drm","null,'CHIFFRES_MOIS','{$deb}','{$fin}','2018-02-15','{$type}','{$centi}','{$value}'");
        }
    }

    public static function getChiffreMoisPrec($mysqli, $dateDeb,$dateFin,$type,$centili) {
        $moisPrec = dbUtil::getDb($mysqli,"drm","drm_quantite","drm_type='CHIFFRES_MOIS' AND drm_dateDeb='{$dateDeb}' AND drm_dateFin='{$dateFin}' AND drm_type_boisson='{$type}' AND drm_centilisation='{$centili}'");
        return $moisPrec;
    }
//MISE_EN_DECHET
        public static function getDestructionsCrd($mysqli, $dateDeb,$dateFin,$type,$centili) {
        $q="
        SELECT typeTimbre,centili,sum(quant) as q FROM
        (
        SELECT SPLIT_STR(ficheprod_transfo,'-',4) as typeTimbre,  
        SPLIT_STR(ficheprod_transfo,'-',3) +0 as centili, 
        ficheprod_quantity as quant,
        mat_date as mdate
        FROM ficheProduction
        JOIN new_gestion_matiere on ficheprod_id=mat_num_prod
        WHERE 
        ficheprod_status=3 AND
        ficheprod_transfo like '%FISCAL' AND
        ficheprod_transfo not like '%INTER_FISCAL' AND
        ficheprod_transfo like 'DESTRUCTION%'

        UNION ALL

        SELECT 
        mat_type_timbre as typeTimbre,  
        mat_centilisation*10 as centili, 
        mat_produits as quant,
        mat_date as mdate
        FROM gestion_matiere
        WHERE 
        (mat_operation='MISE_EN_DECHET')
        ) as mixDB
        WHERE mdate BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
        typeTimbre='{$type}' and centili='{$centili}'";

        //echo $q."<br>";
        if($result=$mysqli->query($q)){
            $index=0;
            while ($row = $result->fetch_assoc()) {
                return intval($row["q"]);
                $index++;
            }
            if($index==0){
                return  0;
            }
        }else
            return 0;
        }
        //RETOUR_CLIENT_CRD
        public static function getRetour_ApproClient($mysqli, $dateDeb,$dateFin,$type,$centili) {
        $q="
        SELECT typeTimbre,centili,sum(quant) as q FROM
        (
        SELECT SPLIT_STR(ficheprod_transfo,'-',4) as typeTimbre,  
        SPLIT_STR(ficheprod_transfo,'-',3) +0 as centili, 
        ficheprod_quantity as quant,
        mat_date as mdate
        FROM ficheProduction
        left JOIN new_gestion_matiere on ficheprod_id=mat_num_prod
        WHERE 
        ficheprod_status=3 AND
        ficheprod_transfo like '%FISCAL' AND
        ficheprod_transfo not like '%INTER_FISCAL' AND
        (ficheprod_transfo  like 'APPRO_CLIENT%' OR ficheprod_transfo  like 'RETOUR_CLIENT%')

        UNION ALL

        SELECT 
        mat_type_timbre as typeTimbre,  
        mat_centilisation*10 as centili, 
        mat_produits as quant,
        mat_date as mdate
        FROM gestion_matiere
        WHERE 
        (mat_operation='RETOUR_CLIENT_CRD' OR mat_operation='APPRO_CLIENT_CRD')
        ) as mixDB
        WHERE mdate BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
        typeTimbre='{$type}' and centili='{$centili}'";

        //echo $q."<br>";
        if($result=$mysqli->query($q)){
            $index=0;
            while ($row = $result->fetch_assoc()) {
                return intval($row["q"]);
                $index++;
            }
            if($index==0){
                return  0;
            }
        }else
            return 0;
        }

public static function getMarge($mysqli,$dateDeb,$dateFin){
    $q="
    select sum(marge) from (
    select com_id,com_prefix,com_article_id,com_quantite as prod,com_type_timbre as type, com_centilisation*10 as cent,com_date_livraison as date,(com_prix_au_mille_ht - com_prix_au_mille_ht_achat)*com_quantite/com_unite as marge,ficheprod_transfo,mat_id,offrecom_offreNum, 
    (select GROUP_CONCAT(ficheprod_transfo SEPARATOR '+') from ficheProduction where ficheprod_ordre=com_id) as sumT, (select count(ficheprod_id) from ficheProduction where ficheprod_ordre=com_id) as nbrOp 
    from commandes 
    LEFT JOIN new_gestion_matiere on mat_num_prod=com_id and mat_operation='EXP_CRD'
    LEFT JOIN ficheProduction on ficheprod_ordre=com_id  
    LEFT JOIN offreCom on offrecom_comId=com_id
    WHERE (com_prefix like 'V%' or com_prefix like 'C%'or com_prefix like 'F%' or com_prefix like 'E%' or com_prefix like 'R%' or com_prefix like 'AC%' or com_prefix like 'A__') AND (com_status_id>=5 and com_status_id!=16 AND com_status_id !=15 AND com_status_id!=23 AND com_status_id!=20 AND com_status_id!=19)
    AND com_date_livraison between '{$dateDeb}' and '{$dateFin}'
    group by com_id
    ) as db
    ";
    //echo $q;
       if($result=$mysqli->query($q)){
            $index=0;
            //echo(ENETETE_TABLEAU_STOCK_CRD);
            while ($row = $result->fetch_assoc()) {
                return intval($row["sum(marge)"]);
                $index++;
            }if($index==0){
                return  0;
            }
        }else
            return 0;
        
}

public static function getCA($mysqli,$dateDeb,$dateFin){
    $q="
        select sum(price) from (
        (
        select com_id,com_prefix,com_article_id,com_quantite as prod,com_type_timbre as type, com_centilisation*10 as cent,com_date_livraison as date,com_prix_au_mille_ht*com_quantite/com_unite as price,ficheprod_transfo,mat_id,offrecom_offreNum, 
        (select GROUP_CONCAT(ficheprod_transfo SEPARATOR '+') from ficheProduction where ficheprod_ordre=com_id) as sumT, (select count(ficheprod_id) from ficheProduction where ficheprod_ordre=com_id) as nbrOp 
        from commandes 
        LEFT JOIN new_gestion_matiere on mat_num_prod=com_id and mat_operation='EXP_CRD'
        LEFT JOIN ficheProduction on ficheprod_ordre=com_id  
        LEFT JOIN offreCom on offrecom_comId=com_id
        WHERE (com_prefix like 'AC__' or com_prefix like 'R%' or com_prefix like 'V%' or com_prefix like 'C%'or com_prefix like 'F%' or com_prefix like 'E%') AND (com_status_id>5 and com_status_id!=16 AND com_status_id !=15 AND com_status_id!=23 AND com_status_id!=24 AND com_status_id!=20 AND com_status_id!=19)
        AND com_date_livraison between '{$dateDeb}' and '{$dateFin}'
        group by com_id
        )union 
        (
        select com_id,com_prefix,com_article_id,com_quantite as prod,com_type_timbre as type, com_centilisation*10 as cent,com_date_livraison as date,-com_prix_au_mille_ht*com_quantite/com_unite as price,ficheprod_transfo,mat_id,offrecom_offreNum, 
        (select GROUP_CONCAT(ficheprod_transfo SEPARATOR '+') from ficheProduction where ficheprod_ordre=com_id) as sumT, (select count(ficheprod_id) from ficheProduction where ficheprod_ordre=com_id) as nbrOp 
        from commandes 
        LEFT JOIN new_gestion_matiere on mat_num_prod=com_id and mat_operation='EXP_CRD'
        LEFT JOIN ficheProduction on ficheprod_ordre=com_id  
        LEFT JOIN offreCom on offrecom_comId=com_id
        WHERE com_prefix like 'A__' AND com_date_livraison between '{$dateDeb}' and '{$dateFin}'
        group by com_id
        )


        ) as db






        ";

    

       if($result=$mysqli->query($q)){
            $index=0;
            //echo(ENETETE_TABLEAU_STOCK_CRD);
            while ($row = $result->fetch_assoc()) {
                return intval($row["sum(price)"]);
                $index++;
            }if($index==0){
                return  0;
            }
        }else
            return 0;
        
}

public static function getCA_agent($mysqli,$dateDeb,$dateFin,$agent){
    $q="select com_id,com_prefix,com_article_id,com_status_id,sum(prix),client_nom,com_date_livraison,ficheprod_transfo, demPrix_id,demPrix_status,agent from (

select com_id,com_prefix,com_article_id,com_status_id,prix,client_nom,com_date_livraison,ficheprod_transfo, demPrix_id,demPrix_status,SUBSTRING(demPrix_num,1,2) as agent from (
select com_id,com_prefix,com_article_id,com_status_id,com_date_livraison,com_quantite*com_prix_au_mille_ht/com_unite as prix,ficheprod_transfo, client_nom,demPrix_id,demPrix_status,com_type_timbre,demPrix_num from commandes 
LEFT JOIN client on com_client_id=client_id
left join offreCom on com_id=offrecom_comId
left join offrePrix on offrecom_offrenum=offrePrix_num COLLATE latin1_swedish_ci
left join demandePrix on demPrix_num=offrePrix_demNum and demPrix_status>=4 and demPrix_prefix=offrePrix_prefix
left join ficheProduction on ficheprod_ordre=com_id 
where /*(com_prefix like 'C__' or com_prefix like 'CK__') AND*/ (com_status_id>=5 and com_status_id!=16 AND com_status_id !=15 AND com_status_id!=23 AND com_status_id!=20 AND com_status_id!=19 and  com_status_id!=24 and  com_status_id!=25)
AND  com_date_livraison BETWEEN '{$dateDeb}' and '{$dateFin}'
/*and  ficheprod_transfo like '%-FISCAL' and com_type_timbre!='EXPORT'*/
) as db 
group by com_id
order by com_id desc

)as db2 
where agent='{$agent}'
";
       if($result=$mysqli->query($q)){
            $index=0;
            //echo(ENETETE_TABLEAU_STOCK_CRD);
            while ($row = $result->fetch_assoc()) {
                return intval($row["sum(prix)"]);
                $index++;
            }if($index==0){
                return  0;
            }
        }else
            return 0;
        
}

public static function getOperator($mysqli){
    return $q;
    $q = "SELECT user_rhId,user_name,user_surname FROM users where user_active=1 and user_rhId!=-1 and user_pointe=1 ORDER BY user_id";
    return $q;
    echo $q;
    $i=0;
    if ($res = $mysqli->query($q)) {
        $arr = array();
        while ($obj = $res->fetch_object()) {
            $arr[$i] = array('id' => $obj->user_rhId,'nom' => $obj->user_name, 'prenom' => $obj->user_surname);
                $i++;
        }
    }
    return $arr;
}
public static function getProdCrd($mysqli, $dateDeb,$dateFin,$type,$centili) {
        $q="
        SELECT typeTimbre,centili,sum(quant) as q FROM
        (
        SELECT SPLIT_STR(ficheprod_transfo,'-',4) as typeTimbre,  
        SPLIT_STR(ficheprod_transfo,'-',3) +0 as centili, 
        ficheprod_quantity as quant,
        mat_date as mdate
        FROM ficheProduction
        JOIN new_gestion_matiere on ficheprod_id=mat_num_prod and mat_operation='PROD_CRD'
        WHERE 
        ficheprod_status=3 AND
        ficheprod_transfo like '%FISCAL' AND
        ficheprod_transfo not like '%INTER_FISCAL' AND
        ficheprod_transfo not like 'RETOUR_CLIENT%' AND
        ficheprod_transfo not like 'DESTRUCTION%' AND
        ficheprod_transfo not like 'APPRO_CLIENT%' 

        UNION ALL

        SELECT 
        mat_type_timbre as typeTimbre,  
        mat_centilisation*10 as centili, 
        mat_produits as quant,
        mat_date as mdate
        FROM gestion_matiere
        WHERE 
        mat_operation='PROD_CRD'
        ) as mixDB
        WHERE 
        mdate BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
        typeTimbre='{$type}' and centili='{$centili}'";

        //echo $q."<br>";
        if($result=$mysqli->query($q)){
            $index=0;
            while ($row = $result->fetch_assoc()) {
                return intval($row["q"]);
                $index++;
            }
            if($index==0){
                return  0;
            }
        }else
            return 0;
        }

        public static function getExpeditionsCrd($mysqli, $dateDeb,$dateFin,$type,$centili) {
        //convert centili
        $cent = floatval($centili)/10;
        $q="
        SELECT distinct(com_id),
        sitecli_texteFiscal as texte,
        com_type_timbre as type,
        com_centilisation*10 as centili,
        sum(com_quantite) as quant
        FROM commandes
        LEFT JOIN  siteClient on sitecli_mere_id=com_client_id and sitecli_num=com_client_site
        WHERE 
        com_status_id BETWEEN 6 AND 25
        AND com_status_id!='20'
        AND com_status_id!='24'  
        AND com_status_id!='23' 
        AND com_status_id!='19' 
        AND com_status_id!='18' 
        AND com_status_id!='15' 
        AND com_status_id!='16' 
        AND (com_prefix like 'C__' or  com_prefix like 'V__')
        AND com_type_timbre !='EXPORT'
        AND com_date_livraison BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
        com_type_timbre='{$type}' and com_centilisation='{$cent}'";
        //echo ($q);
        if($result=$mysqli->query($q)){
            $index=0;
            while ($row = $result->fetch_assoc()) {
                return intval($row["quant"]);
                $index++;
            }
            if($index==0){
                return  0;
            }
        }else
            return 0;
        }
        
    public static function getMaxNumCarton($mysqli, $id) {
        $numCom = dbUtil::getDb($mysqli,"stockScan","stockscan_numCom","stockscan_id='{$id}'");
        $prefix = dbUtil::getDb($mysqli,"stockScan","stockscan_prefix","stockscan_id='{$id}'");
        $article = dbUtil::getDb($mysqli,"stockScan","stockscan_article","stockscan_id='{$id}'");
        $numCarton = dbUtil::getDb($mysqli,"stockScan","MAX(stockscan_numCarton)" ,"stockscan_numCom='{$numCom[0]}' and stockscan_prefix='{$prefix[0]}' and stockscan_article='{$article[0]}'");
        return $numCarton;
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
    
    public static function calculVariation($mysqli, $dateDeb,$dateFin,$type) {
        $q="
        select sum(prod*cent/100000) as p,type from 
        (
        select mat_produits as prod,mat_type_timbre as type,mat_centilisation*10 as cent,mat_date as date from gestion_matiere 
        WHERE mat_operation='PROD_CRD' 
        UNION
        select ficheprod_quantity as prod, SPLIT_STR(ficheprod_transfo,'-',4) as type ,SPLIT_STR(ficheprod_transfo,'-',3) as cent,mat_date as date from ficheProduction
        JOIN new_gestion_matiere on ficheprod_id=mat_num_prod and mat_operation='PROD_CRD' and ficheprod_transfo like '%FISCAL' and ficheprod_transfo not like '%INTER_FISCAL'
        UNION
        select -com_quantite as prod,com_type_timbre as type, com_centilisation*10 as cent,com_date_livraison as date from commandes 
        LEFT JOIN new_gestion_matiere on mat_num_prod=com_id and mat_operation='EXP_CRD'
        LEFT JOIN ficheProduction on ficheprod_ordre=com_id and ficheprod_transfo like '%FISCAL'
        WHERE (com_prefix like 'V__' or com_prefix like 'C__') AND (com_status_id>=5 and com_status_id!=16 AND com_status_id !=15 AND com_status_id!=23 AND com_status_id!=20 AND com_status_id!=19)
        AND com_type_timbre !='EXPORT'
        )as db
        where date BETWEEN '{$dateDeb}' AND '{$dateFin}' AND 
        type='{$type}'";

        //echo $q."<br>";
        if($result=$mysqli->query($q)){
            $index=0;
            while ($row = $result->fetch_assoc()) {
                return floatval($row["p"]);
                $index++;
            }
            if($index==0){
                return  0;
            }
        }else
            return 0;
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
