<?php
session_start();
if ($_SESSION['AccountType'] != 'ADMIN' && $_SESSION['AccountType'] != 'UC') {
    $_SESSION['error'] = "You must be an administrator to view the requested page.";
    header("Location: dashboard.php");
    break;
}
?>