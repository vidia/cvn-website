<?php
session_start();
$_SESSION['Name'] = "";
$_SESSION['Login'] = "";
$_SESSION['Acct'] = "";
session_destroy();
session_start();
$_SESSION["success"] = "Your account has been logged out.";
header("Location: login.php");
?>