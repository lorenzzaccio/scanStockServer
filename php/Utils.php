<?php
final class Utils {

    private function __construct() {
        
    }

    public static function getTimeStamp() {
        date_default_timezone_set("Europe/Paris");
        $timeNow = date("h:m:s");
        $dateNow = time();
        return date("Y-m-d", $dateNow) . "," . $timeNow;
    }

    public static function check_arg_key($json,$key){
        // Converts it into a PHP object
        $data = json_decode($json);
        
        if($data->$key){
            return ($data->$key);
        }
        else{
            return_code($ERROR_NO_ARG);
            exit();
        }
    }


    public static function get_mail_address($mysqli,$facture_num){
        $data = array();
        $q="select client_email_fact from commandes join client on com_client_id=client_id WHERE com_facture_num='{$facture_num}'";
        
        if($result=$mysqli->query($q)){ 
            if ($row = $result->fetch_assoc()) {
                  $data[]=$row["client_email_fact"];
            }
        }
        return $data;
    }

    public static function check_req_arg_key($key){
        // Converts it into a PHP object
        if(isset($_REQUEST[$key])){
            return ($_REQUEST[$key]);
        }
        else{
            echo ($key." error");
            return_code($ERROR_NO_ARG);
            exit();
        }
    }

    public static function get_field_list($table){
        $data = array();
        $q="select COLUMN_NAME FROM `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE `TABLE_SCHEMA`='capstech' AND `TABLE_NAME`='".$table."'";
        if($result=$mysqli->query($q)){ 
            while ($row = $result->fetch_assoc()) {
                  $data[].=$row["COLUMN_NAME"];
            }
        }
        return $data;
    }

    public static function create_add_table_row_function ($mysqli,$table){
        $q="select COLUMN_NAME,COLUMN_TYPE FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='capstech' 
        AND `TABLE_NAME`='".$table."'";

        $p2='public static function add_'.$table.'_row($mysqli,$arg){
            $table_name="'.$table.'"; 
            $table = array(';

        $index=0;
        if($result=$mysqli->query($q)){ 
            $num_rows = $result->num_rows; 

            if($num_rows===0) 
            {
                return_code($ERROR_NO_ARG);
                exit();
            }

            while ($row = $result->fetch_assoc()) {
              $data[]="\"".$row["COLUMN_NAME"]."\"=>[\$arg[".$index."],".$row["COLUMN_TYPE"]."]";
                if($index<$num_rows-1)
                    $line.= $data[$index].",\n";
                else
                    $line.= $data[$index]."\n";
                $index++;
            }
        }else{
            return_code($ERROR_NO_ARG);
            exit();
        }

        $p3=');';
        
        $p4='  
          return dbUtil::add_sql_row($mysqli,$table_name,$table);
        }';

        return $p2.$line.$p3.$p4;

    }


    public static function createLink($page, array $params = array()) {
        $params = array_merge(array('page' => $page), $params);
        return 'index.php?' . http_build_query($params);
    }

    public static function getTypeTimbre($value) {
        $splitter = explode("=", $value);
        return $splitter[1];
    }

    public static function getTexteFiscal($value) {
        $splitter = explode("=", $value);
        return $splitter[0];
    }

    public static function getCentilisation($value) {
        $splitter = explode("=", $value);
        return $splitter[2];
    }

    public static function getPrefix($value) {
        $splitter = explode("-", $value);
        return $splitter[0];
    }

    public static function getArticle($value) {
        $splitter = explode("-", $value);
        if (sizeof($splitter, NULL) >= 2)
            return $splitter[1];
        else
            return "";
    }

    public static function getRootArticle($value) {
        $root = substr($value, -4);
        return $root;
    }

    public static function getClientId($value) {
        $splitter = explode("-", $value);
        return $splitter[0];
    }

    public static function getClientNom($value) {
        $splitter = explode("-", $value);
        return $splitter[1];
    }

    public static function getStockCrd($mysqli, $prefix, $article) {
        //echo("Article=".$article);
        $data = array();
        $q = "SELECT SUM(stockscan_quantite) as stock FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and " . "(stockscan_typeStock='2')";
        //echo("Article=".$article);
        if ($result = $mysqli->query($q)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
                if($data[stock]<=0){
                    $data = array('stock'=>'-1');
                }
            }
            
        }else {
            $data= array('stock'=>'-1');
        }
        return $data;
    }

    public static function getStockMat($mysqli, $prefix, $article) {
        //echo("Article=".$article);
        $data = array();
        $q = "SELECT SUM(stockscan_quantite) as stock FROM stockScan WHERE stockscan_prefix='" . $prefix . "' and stockscan_article='" . $article . "' and "
                . "(stockscan_typeStock='0' or "
                . "stockscan_typeStock='1' or "
                . "stockscan_typeStock like'5_' or "
                . "stockscan_typeStock like'5__' or "
                . "stockscan_typeStock='6' )";
        if ($result = $mysqli->query($q)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
                if($data[stock]<=0){
                    $data = array('stock'=>'-1');
                }

            }
        }else {
            $data = array('stock'=>-1);
        }
        return $data;
    }

        public static function update_echeance($mysqli,$echeance,$facture_num){
        $q = "UPDATE facture SET fact_date='".$echeance."' WHERE fact_num=".$facture_num." and fact_com_id=0 limit 1";
        if ($result = $mysqli->query($q)) {
                return 1;
        }
        return 0;
    }

    public static function calcul_echeance($fact_date,$fact_delai_paiement){
        if (strpos($fact_delai_paiement, 'fdm') != false) {
            $nbr_jours = explode("fdm",$fact_delai_paiement)[0];
        }else{
            if (strpos($fact_delai_paiement, 'net') !== false) {
                $nbr_jours = explode("net",$fact_delai_paiement)[0];
            }else{
                $nbr_jours = $fact_delai_paiement;
            }
            //echo 'jours='.$nbr_jours;
        }
        //echo "delai paiement=".$fact_delai_paiement;
        $date = new DateTime($fact_date);
        $date->add(new DateInterval('P'.$nbr_jours.'D'));
        //echo "date=".$date->format('Y-m-d');     
        if (strpos($fact_delai_paiement,'fdm') != false) {
            $date->add(new DateInterval('P1M'));
            $mod_date=$date->format('Y-m-d');
            $splitted_date = explode("-",$mod_date);
            $str_new_date = $splitted_date[0]."-".str_pad( (intval($splitted_date[1])-1), 2, "0", STR_PAD_LEFT)."-01";
            $date = new DateTime($str_new_date);
            $date->sub(new DateInterval('P1D'));
            $fact_date_paiement = $date->format('Y-m-d');
            //echo ("here");
        }else
            $fact_date_paiement = $date->format('Y-m-d');
            //echo "fact_date_paiement=".$fact_date_paiement; 
        return $fact_date_paiement;
    }

        public static function check_row_exist($mysqli,$table,$cond){
        $q = "SELECT * FROM {$table} WHERE {$cond}";
        //echo $q."\n\r";
        if ($result = $mysqli->query($q)) {
            if($row = mysqli_fetch_assoc($result)){
                return 1;
            }
        }
        return 0;
    }

    public static function get_ofx_to_array($url){
        $source = fopen($url, 'r');
        if (!$source) {
            throw new Exception('Unable to open OFX file.');
        }

        // skip headers of OFX file
        $headers = array();
        $charsets = array(
            1252 => 'WINDOWS-1251',
        );
        while(!feof($source)) {
            $line = trim(fgets($source));
            if ($line === '') {
                break;
            }
            list($header, $value) = explode(':', $line, 2);
            $headers[$header] = $value;
        }

        $buffer = '';

        // dead-cheap SGML to XML conversion
        // see as well http://www.hanselman.com/blog/PostprocessingAutoClosedSGMLTagsWithTheSGMLReader.aspx
        while(!feof($source)) {

            $line = trim(fgets($source));

            if ($line === '') continue;
            //$line=str_replace(' ', '', $line);
            //echo $line ."==>length=".strlen($line)."<BR>";

            $line = iconv($charsets[$headers['CHARSET']], 'UTF-8', $line);

            if (substr($line, -1, 1) !== '>') {
                list($tag) = explode('>', $line, 2);
                $line .= '</' . substr($tag, 1) . '>';
            }
            $buffer .= $line ."\n";
        }

        // use DOMDocument with non-standard recover mode
        $doc = new DOMDocument();
        $doc->recover = true;
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $save = libxml_use_internal_errors(true);
        $doc->loadXML($buffer);
        libxml_use_internal_errors($save);
        $bank=Utils::get_bank_ref($doc);
        $transfert = array();
        //$referred_tags = array('TRNTYPE','DTAVAIL','TRNAMT','REFNUM','NAME','MEMO','FITID');//cdn
        //$tag_date='DTAVAIL';

        $referred_tags = array('TRNTYPE','DTPOSTED','TRNAMT','REFNUM','NAME','MEMO','FITID');//cic
        $tag_date='DTPOSTED';

        //echo $doc->saveXML();
        $root = $doc->getElementsByTagName("OFX")->item(0);
        $books = $root->getElementsByTagName('STMTTRN');
        foreach ($books as $book) {
            $row=array();
            if($book->hasChildNodes()){
                $els=$book->childNodes;
                for ($i = 0; $i<$els->length;$i++) {
                  $el = $els->item($i);
                  
                  foreach ($referred_tags as $key) {
                    if($el->tagName===$key)
                        if($key===$tag_date)
                            array_push($row,substr($el->nodeValue,0,4)."-".substr($el->nodeValue,4,2)."-".substr($el->nodeValue,6,2));
                        else
                            array_push($row,$el->nodeValue);
                  }
                }
            }
            if(sizeof($row)>0){
                    //add bank account
                    array_push($row, $bank);
                    //print_r($row);
                    array_push($transfert,Utils::sort_for_jrnl_banque($bank,$row));
                    //print_r($row);
                    //print_r(Utils::sort_for_jrnl_banque($bank,$row));
            }
            //echo "<BR>";
        }

        return $transfert;
    }

    public static function get_bank_ref($doc){
        $root = $doc->getElementsByTagName("OFX")->item(0);
        $bankid = $root->getElementsByTagName('BANKID');

        if($bankid->item(0)->nodeValue==="30087") return "cic";
        if($bankid->item(0)->nodeValue==="30076") return "cdn";

    }
    public static function sort_for_jrnl_banque($bank,$row){
        if($bank==="cdn") return Utils::cdn_for_jrnl_banque($row);
        if($bank==="cic") return Utils::cic_for_jrnl_banque($row);
    }

    public static function cdn_for_jrnl_banque($row){
        //print_r($row);
        $new_row=array();
        array_push($new_row,$row[1]);//date
        array_push($new_row,addslashes($row[4]));//pièce=name
        array_push($new_row,"");//jnl
        array_push($new_row,addslashes($row[5]));//ref
        if(sizeof($row)===6)
            array_push($new_row,"");//memo
        else
            array_push($new_row,addslashes($row[6]));//memo
        array_push($new_row,"");//lettrage

        if($row[0]==="DEBIT"){
            array_push($new_row,"0");//credit
            array_push($new_row,$row[2]);//débit
        }else{
            array_push($new_row,$row[2]);//credit
            array_push($new_row,"0");//débit
        }
        array_push($new_row,"0");//solde
        array_push($new_row,$row[3]);//fitid
        array_push($new_row,$row[sizeof($row)-1]);
        return $new_row;
    }

    public static function cic_for_jrnl_banque($row){
        //print_r($row);
        $new_row=array();
        array_push($new_row,$row[1]);//date
        array_push($new_row,addslashes($row[4]));//pièce=name
        array_push($new_row,"");//jnl
        array_push($new_row,"");//ref
        //if(sizeof($row)===6)
            array_push($new_row,"");//memo
        //else
        //    array_push($new_row,addslashes($row[5]));//memo
        array_push($new_row,"");//lettrage

        if($row[0]==="DEBIT"){
            array_push($new_row,"0");//credit
            array_push($new_row,$row[2]);//débit
        }else{
            array_push($new_row,$row[2]);//credit
            array_push($new_row,"0");//débit
        }
        array_push($new_row,"0");//solde
        array_push($new_row,$row[3]);//fitid
        array_push($new_row,$row[sizeof($row)-1]);
        return $new_row;
    }

}
