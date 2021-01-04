
<?php
    include("../../php_conf/config1.php");
    include("../../scanStockServer/php/Utils.php");
    include("../../scanStockServer/php/dbUtil.php");
    include("../../scanStockServer/php/db_mapping.php");
    include("../../scanStockServer/php/codes.php");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Content-Type: application/json; charset=UTF-8");

    
    //$json = isset("json")?$_REQUEST["json"]:return_code($ERROR_NO_ARG);
    //$input = json_decode($json, true);

    $key="table";
    if(isset($_REQUEST[$key])){
          $table = $_REQUEST[$key];
        }
        else{
            echo($key." manquant\n");
            return_code($ERROR_NO_ARG);
            exit();
        }

    $key="data_json";

    
    if(isset($_REQUEST[$key])){
        $data = $_REQUEST[$key];
        $input = json_decode($data, true);

    }
    else{
        echo($key." manquant\n");
        return_code($ERROR_NO_ARG);
        exit();
    }

    echo("data json=".$input["x"]."\n");

    $q="select COLUMN_NAME,COLUMN_TYPE FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='capstech' 
        AND `TABLE_NAME`='".$table."';\n";


    echo "public static function add_".$table."_row(\$mysqli,\$arg){
        \$table_name=\"".$table."\";
        \$table = array(\n";


    $index=0;
    if($result=$mysqli->query($q)){ 
        while ($row = $result->fetch_assoc()) {
            $data[]="\"".$row["COLUMN_NAME"]."\"=>[\$arg[".$index."],".$row["COLUMN_TYPE"]."]";
            //echo" count=".$result->num_rows;
            if($index<$result->num_rows-1)
                echo $data[$index].",\n";
            else
                echo $data[$index]."\n";
            $index++;
        }
    }
    echo");
      return dbUtil::add_sql_row(\$mysqli,\$table_name,\$table);
    }";
?>