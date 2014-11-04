<?php session_start();
include("../assets/includes/db.php");
include("../assets/includes/verify.php");
include("../assets/includes/verify-uc.php");
include("../assets/includes/constants.php");

$eventID = $_POST['eventID'];

$numberWanted = $_POST['number-pull'];
$body = "UC Who Pulled: ".$_SESSION['Name'].'<br><pre>'.print_r($_POST,true).'</pre><br><br>';

$body .= "<strong>Now: ". date("Y-m-d H:i:s")."</strong><br>";
$body .= pullAttendance($numberWanted,$eventID,0,0);
mail("cvn2@purdue.edu, purduekenny@gmail.com", "[debug] Pull attendance debug email", $body, "Content-type: text/html\r\n");

$_SESSION['success'] = "The attendance has been successfully pulled and the ushers have been notified.";
header("Location: attendance-admin.php");

?>