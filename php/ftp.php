<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');  
if(empty($_GET['msg'])) 
    return -1;
else
    $msg= $_GET['msg'];

    $local_file = "localfile.txt";
    $server_file = "script.sh";
    
    //create file
    $loc = "script_".rand(1,1000).".sh";
    echo $loc;
    /*$myfile = fopen($loc, "w")  or die("Unable to open file!");
    fwrite($myfile, $msg);
    fclose($myfile);*/
    
    //create tmp file
    $temp = tempnam("ftp",$myfile);
    echo $temp;
    $file = fopen($temp,"w");
    echo "File = ".$file;
    fwrite($file, $msg);
    
    // connect and login to FTP server
    $ftp_server = "127.0.0.1";
    $ftp_username = "capstech";
    $ftp_userpass = "MARcel2301##@";
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
    
    
    // initiate upload
    //$d = ftp_nb_put($ftp_conn, $server_file, $loc, FTP_BINARY);
    ftp_chdir($ftp_conn, "ftp");
    if( ftp_put($ftp_conn, $loc, $temp, FTP_BINARY)){
        echo "1";//"Successfully uploaded $file.";
        echo "<BR> Successfully uploaded $loc.";
        unlink($loc);
    }else{
        echo "Error uploading $loc.";
        echo "-1";//"Error uploading $file.";
    }
   /* while ($d == FTP_MOREDATA)
    {
        // do whatever you want
        // continue uploading
        $d = ftp_nb_continue($ftp_conn);
    }
    
    if ($d != FTP_FINISHED)
    {
        echo "Error uploading $loc";
        exit(1);
    }*/
    
    // close connection
    ftp_close($ftp_conn);
    
    //This removes the file
    //fclose($file);
/*
//create file
$myfile = fopen("script.sh", "w")  or die("Unable to open file!");
fwrite($myfile, $msg);
fclose($myfile);


if(($ftp = ftp_connect("192.168.0.3", 21)) == false)
{
    echo 'Erreur de connexion...';
    echo "-1";
    exit;
}
    
if(!ftp_login($ftp, "garnier.laurent", "Lorenzo2301"))
{
    echo 'L\'identification a échoué...';
    echo "-1";
    exit;
}
ftp_chdir($ftp, "ftp");
  echo 'COUCOU1';

 echo 'COUCOU3';

if( ftp_put($ftp, "script.sh", "script.sh", FTP_BINARY)){
    echo "1";//"Successfully uploaded $file.";
    echo "Successfully uploaded $file.";
}else{
    echo "Error uploading $file.";
    echo "-1";//"Error uploading $file.";
}
// close connection
ftp_close($ftp);
*/
