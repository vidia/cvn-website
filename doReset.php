<?php session_start();
include_once("assets/includes/db.php");

$Password = $_POST['Password'];
$CPassword = $_POST['CPassword'];
$ConfirmationKey = $_POST['Key'];
$Email = $_POST['Email'];

$query = "SELECT * FROM User WHERE Email='" . $Email . "' AND ConfirmationKey='" . $ConfirmationKey . "'";
//echo $query; 
$result = mysql_query($query);
$num_rows = mysql_num_rows($result);

if ($num_rows > 0) {
    //echo "valid";
    while ($row = mysql_fetch_array($result)) {
        $name = $row['FirstName'] . " " . $row['LastName'];
        $Username = $row['Username'];
        $ID = $row['ID'];
        $AcctType = $row['AcctType'];
        $LastLogin = $row['LastLogin'];
    }

    if ($Password != $CPassword || $Password == '' || $CPassword == '') {
        $_SESSION['error'] = "Your passwords didnt match.";
        header("Location: reset-password.php?Email=" . $Email . "&Key=" . $ConfirmationKey);
    } else {
        //update db
        $Password = md5($Password);
        $sql = "UPDATE User SET Password='" . $Password . "' WHERE Username='" . $Username . "'";
        mysql_query($sql);
        // $_SESSION['Login'] = $Username;
        // $_SESSION['Name'] = $name;
        // $_SESSION['UID'] = $ID;
        // $_SESSION['AccountType'] = $AcctType;
        // $_SESSION['LastLogin'] = $LastLogin;
        $_SESSION['success'] = "Your password has successfully been updated. Please login to verify your changes.";
        header("Location: login.php");
    }


} else {
    //echo "not valid";
    $_SESSION['error'] = "Our system has encountered an error while trying to reset your password. For security purposes please start the recovery process over by <a href='recover-password.php'>clicking here.</a>";
    header("Location: reset-password.php");
}

?>