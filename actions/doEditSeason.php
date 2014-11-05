<?php session_start();
include_once("../assets/includes/db.php");
include_once("../assets/includes/constants.php");
include("../assets/includes/verify-admin.php");


if($_REQUEST["action"] == "edit") {
    $seasonName = mysql_escape_string($_POST["seasonName"]);
    $seasonID = (int) mysql_escape_string($_POST["seasonID"]);

    $sql = "UPDATE Season SET Season='" . $seasonName . "' WHERE SeasonID=". $seasonID;
    mysql_query($sql);
    $_SESSION["success"] = "You have updated the season name.";
}
else if($_REQUEST["action"] == "delete") {
    // $seasonID = (int) $_GET["id"];
    // $sql = "DELETE FROM Season WHERE SeasonID=" . $seasonID . " LIMIT 1";
    // mysql_query($sql);
    // $_SESSION["success"] = "You've deleted that Season";
    $_SESSION["error"] = "Deleting seasons is not enabled.";
}
else if($_REQUEST["action"] == "add") {
    $seasonName = mysql_escape_string($_POST["seasonName"]);
    $sql = "INSERT INTO Season (Season) VALUES ('" . $seasonName . "')";
    mysql_query($sql);
    $_SESSION["success"] = "You've successfully created <strong>" . $seasonName . "</strong>.";
}
else {
    //error
}

header("Location: /season-admin.php");

?>