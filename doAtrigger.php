<?php
require_once("assets/includes/atrigger.php");


//Get real IP of request
//http://stackoverflow.com/a/5785956/172163
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


//Check IP
if(ATrigger::verifyRequest(getRealIpAddr())) {
    //Valid request:
    syslog(1, "ATRIGGER: Hello this is a test");

    //Do the task here
} else {
    //Invalid request:
    //The request is not called from ATrigger servers.
}


?>