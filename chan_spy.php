<?php
require_once "/var/lib/asterisk/agi-bin/phpagi-asmanager.php" ;
require_once "/var/www/html/libs/paloSantoDB.class.php" ;

$cadena_dsn = "mysql://asterisk:asterisk@ivrdb/call_center";

function getDB() {
    global $cadena_dsn;
    $pDB = new paloDB($cadena_dsn);
    return $pDB;
}

if( isset($_GET["spyexten"]) and $_GET["spyexten"] != "" ) {

        $ami = new AGI_AsteriskManager();
        $ami->connect();
        $ami->Events("Off");
        $spyext = $_GET["spyexten"];
        $exten = $_GET["exten"];
        $res = $ami->Originate("SIP/{$exten}","130","from-internal","1",NULL,"Agent Spy","SPY_CHAN={$spyext}",NULL,NULL,NULL);
        echo $res["Response"];

}
else
echo "Please set the exten in user profile";
?>


