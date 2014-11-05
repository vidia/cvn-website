<?php
//include("assets/includes/dbconn.php");
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);


$query = "SELECT * FROM User";
$result = mysql_query($query);


function getHour($plainDate)
{
    $year = substr($plainDate, 0, 4);
    return $year;
}

function getMonth($plainDate)
{
    $year = substr($plainDate, 5, 2);
    return $year;
}

while ($row = mysql_fetch_array($result)) {


    $currentDate = getHour(date("Y-m-d H:i:s"));
    $registerDate = getHour($row['Created']);
    $month = getMonth($row['Created']);
    $yearsInvolved = $currentDate - $registerDate;

    $total = 0;
    $total = $yearsInvolved * 2;

    if (($month == 01 || $month == 02) && getMonth(date("Y-m-d H:i:s")) > 05) {
        $total++;
    }


    echo "<br /><br />";
    echo $row["LastName"] . " " . $row["FirstName"] . " Years: " . $total . " month: " . $month . " End Total: " . $total;
    echo "<br /><br />";

    $query2 = "UPDATE User SET YearsInvolved='" . $total . "' WHERE Username= '" . $row["Username"] . "'";
    mysql_query($query2);


}

?>