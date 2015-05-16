<?php session_start();
include_once("verify.php");
include_once("verify-admin.php");
include_once("db.php");
include_once("constants.php");


$sql = "SELECT * FROM User";
$results = mysql_query($sql);
while($user = mysql_fetch_array($results)) {
    echo $user["ID"] . " | " . $user["Username"] . " | " . calculatePointTotalDB($user["ID"]) . " <br />";
}

echo "<h1>" . $count . "</h1>";


?>