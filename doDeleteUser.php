<?php 
session_start(); 
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");

$userid = $_GET['ID'];

$SQL = "DELETE FROM User WHERE ID='".$userid."'";
mysql_query($SQL);

$SQL = "DELETE FROM Attendance WHERE UserID='".$userid."'";
mysql_query($SQL);

$_SESSION['success'] = "You have successfully deleted the user.";
header("Location: user-admin.php");
?>