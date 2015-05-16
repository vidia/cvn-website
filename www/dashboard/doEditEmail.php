<?php 
session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$emailID = $_POST['ID'];
$emailSubject = $_POST['Email_Subject'];
$emailBody = $_POST['Email_Body'];

$SQL = "UPDATE Email SET Email_Subject='".$emailSubject."', Email_Body='".$emailBody."' WHERE ID='".$emailID."'";
mysql_query($SQL);

$_SESSION['success'] = "The email has successfully been edited";
header("Location: edit-email.php?ID=".$emailID);
?>