<option value="None">-- None --</option>
<?php
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

$SQL2 = "SELECT U.ID as ID, U.LastName as LastName, U.FirstName as FirstName, U.Email as Email, Atten.RequestStatus as RequestStatus FROM User U LEFT JOIN (SELECT * FROM Attendance WHERE EventID='" . $_GET['event'] . "') as Atten ON Atten.UserID=U.ID ORDER BY LastName";
echo $SQL2 . "<br>";
$result2 = mysql_query($SQL2);
while ($row2 = mysql_fetch_array($result2)) {
    if ($row2['RequestStatus'] != 'No-Show' && $row2['RequestStatus'] != 'Present' && $row2['RequestStatus'] != 'Ushering') {
        echo "<option value='" . $row2['ID'] . "'>" . $row2['LastName'] . ", " . $row2['FirstName'] . " - " . $row2['Email'] . "</option>";
    }
}
?>