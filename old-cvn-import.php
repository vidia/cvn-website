<?php
//import users
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/constants.php");
$created = date("Y-m-d H:i:s");

$SQL = "SELECT * FROM User WHERE AcctType='USHER'";
$result = mysql_query($SQL);
while ($row = mysql_fetch_array($result)) {
    $Email = $row['Email'];
    $SQL2 = "UPDATE User SET ConfirmationKey='" . md5($Email) . "', Created='" . $created . "' WHERE Email='" . $Email . "'";
    mysql_query($SQL2);
    echo $SQL2 . "<br>";

    $Subject = "URGENT: New CVN Website - Password Change Required";
    $Body = "Hi Ushers,\n\n As part of the recent upgrade to the website, we request that you login in and reset your password on the new system as soon as possible. Using the URL and credentails below your will be able to do this.\n\n
	URL: http://web.ics.purdue.edu/~cvn/ \n
	Username: $UsherEmail \n
	Password: convos \n
	
	Thanks,\n CVN Team";
    //$headers = "Content-type: text/html\r\n";
    mail($Email, $Subject, $Body, $headers);
}

?>