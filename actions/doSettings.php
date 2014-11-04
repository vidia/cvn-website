<?php session_start();
include_once("../assets/includes/db.php");
include_once("../assets/includes/constants.php");
include("../assets/includes/verify-admin.php");


if($_SESSION["AccountType"] == "ADMIN") {
    if($_REQUEST["action"] == "enablemm") {
        $sql = "UPDATE Settings SET isMaintenance=1";
        mysql_query($sql);
        $_SESSION["success"] = "Maintenance Mode has been enabled.";
    }
    else if($_REQUEST["action"] == "disablemm") {
        $sql = "UPDATE Settings SET isMaintenance=0";
        mysql_query($sql);
        $_SESSION["success"] = "Maintenance Mode has been disabled.";
    }
    else {
        //error
        $_SESSION["error"] = "Something went wrong.";
    }
}
else {
    $_SESSION["error"] = "You do not have authorization to change site settings.";
}

header("Location: site-admin.php");

?>
