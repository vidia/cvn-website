<?php
if ($_SESSION['AccountType'] != 'ADMIN' && $_SESSION['AccountType'] != 'UC') {
    $_SESSION['security-error'] = "You do not have the proper account permission to access the requested pages.";
    header("Location: index.php");
    break;
}
?>