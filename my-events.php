<?php session_start();
include("assets/includes/verify.php");
$hostname = 'mydb.ics.purdue.edu';
$username = 'cvn';
$password = 'stag3d00r';
$dbname = 'cvn';
mysql_connect($hostname, $username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <link rel="stylesheet" type="text/css" href="assets/css/screen.css"/>
        <!--[if lt IE 8]>
        <link href="assets/css/ie.css" rel="stylesheet" type="text/css"/>
        <![endif]-->
        <title>Purdue CVN || Usher Tracker</title>
    </head>

    <body class="cvn faqs">
    <div id="container">
        <div id="header">
            <img src="assets/images/cvn-header.jpg" alt="CVN Header"/>
            <?php
            if ($_SESSION['Login'] != '') {
                include("assets/includes/admin-menu.php");
            } else {
                include("assets/includes/menu.php");
            }
            if ($_SESSION['AccountType'] == 'ADMIN') {
                include("assets/includes/site-admin-menu.php");
            } elseif ($_SESSION['AccountType'] == 'UC') {
                include("assets/includes/uc-admin-menu.php");
            }
            ?>
        </div>
        <!-- end header -->

        <div id="content">
            <div id="main" class="float-left">
                <h2>My Events</h2><br/>
                <?php if ($_SESSION['request-message'] != '') {
                    echo "<div class='success'>" . $_SESSION['request-message'] . "</div>";
                    $_SESSION['request-message'] = "";
                }
                ?>
                <?php if ($_SESSION['error'] != '') {
                    echo "<div class='error'>" . $_SESSION['error'] . "</div>";
                    $_SESSION['error'] = "";
                }
                ?>
                <div class="box">
                    <strong>Available Events</strong>
                    <?php

                    $query = "SELECT E.ID AS ID, E.UpTime AS UpTime, E.EndTime AS EndTime, E.Name AS Name, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, E.Type AS Type, E.Description AS Description, Atten.RequestStatus AS RequestStatus FROM Event E LEFT JOIN (SELECT * FROM Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "') AS Atten ON E.ID = Atten.EventID ORDER BY E.CallTime ASC";
                    //echo $query;
                    $result = mysql_query($query);
                    while ($row = mysql_fetch_array($result)) {
                        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s") && $row['RequestStatus'] == '') {
                            ?>
                            <div class="event"><?php echo $row['Name']; ?></div>

                            <div class="toggle-container">
                                <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                                <div class="event-time"><strong>Call
                                        Time:</strong> <?php echo date("F j, Y, g:i a", strtotime($row['CallTime'])); ?>
                                </div>
                                <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?>
                                </div>
                                <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth
                                    <u><?php echo $row['Point']; ?></u> points.
                                </div>
                                <div class="event-description"><strong>Description:</strong>
                                    <br/><?php echo $row['Description']; ?></div>
                                <br/>
                                <a class="request" href="doRequest.php?id=<?php echo $row['ID']; ?>">Request Event</a>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <div class="box">
                    <strong>Events I've Requested</strong>
                    <?php
                    $query = "SELECT E.ID AS ID, E.Name AS Name, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, UpTime, EndTime, E.Type AS Type, E.Description AS Description FROM Event E, Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "' AND E.ID=A.EventID AND A.RequestStatus='Requested' ORDER BY E.CallTime ASC";
                    //echo $query;
                    $result = mysql_query($query);
                    while ($row = mysql_fetch_array($result)) {
                        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s")) {
                            ?>
                            <div class="event"><?php echo $row['Name']; ?></div>
                            <div class="toggle-container">
                                <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                                <div class="event-time"><strong>Call
                                        Time:</strong> <?php echo date("n-j-Y g:i a", strtotime($row['CallTime'])); ?>
                                </div>
                                <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?>
                                </div>
                                <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth
                                    <u><?php echo $row['Point']; ?></u> points.
                                </div>
                                <div class="event-description"><strong>Description:</strong>
                                    <br/><?php echo $row['Description']; ?></div>
                                <br/>
                                <a class="cancel" href="doCancelRequest.php?id=<?php echo $row['ID']; ?>">Cancel
                                    Request</a>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>
                <div class="box">
                    <strong>Events I'm Scheduled to Usher</strong>
                    <?php
                    $query = "SELECT E.Name AS Name, UpTime, EndTime, E.ID AS ID, E.CallTime AS CallTime, E.Location AS Location, E.Point AS Point, E.Type AS Type, E.Description AS Description  FROM Event E, Attendance A WHERE A.UserID='" . $_SESSION['UID'] . "' AND E.ID=A.EventID AND A.RequestStatus='Ushering' AND E.CallTime >= '" . date("Y-m-d H:i:s") . "' ORDER BY RequestDate DESC";
                    $result = mysql_query($query);
                    while ($row = mysql_fetch_array($result)) {
                        if ($row['UpTime'] <= date("Y-m-d H:i:s") && $row['EndTime'] >= date("Y-m-d H:i:s")) {
                            ?>
                            <div class="event"><?php echo $row['Name']; ?></div>
                            <div class="toggle-container">
                                <div class="event-name"><strong>Name:</strong> <?php echo $row['Name']; ?></div>
                                <div class="event-time"><strong>Call
                                        Time:</strong> <?php echo date("n-j-Y g:i a", strtotime($row['CallTime'])); ?>
                                </div>
                                <div class="event-location"><strong>Location:</strong> <?php echo $row['Location']; ?>
                                </div>
                                <div class="event-points">This <u><?php echo $row['Type']; ?></u> is worth
                                    <u><?php echo $row['Point']; ?></u> points.
                                </div>
                                <div class="event-description"><strong>Description:</strong>
                                    <br/><?php echo $row['Description']; ?></div>
                                <br/>
                                <a class="cancel" href="doCancelRequest.php?id=<?php echo $row['ID']; ?>">Cancel
                                    Request</a>
                            </div>
                        <?php
                        }
                    }
                    ?>
                </div>


            </div>
            <!-- end main -->

            <?php include('assets/includes/sidebar.php'); ?>
            <br class="clear"/>
        </div>
        <!-- end content -->

        <div id="footer">
            © 2008-2010 all rights reserved.
        </div>
        <!-- end footer -->
    </div>
    </body>
    </html>
<?php $_SESSION['request-message'] = ""; ?>