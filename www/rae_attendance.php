<?php session_start();
$hostname='mydb.ics.purdue.edu';
$username='cvn';
$password='stag3d00r';
$dbname='cvn';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);
include("assets/includes/verify.php");
include("assets/includes/verify-uc.php");
include("assets/includes/constants.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" type="text/css" href="../assets/css/screen.css"/>
<!--[if lt IE 8]>
    <link href="../assets/css/ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
<title>Purdue CVN || Usher Tracker</title>
</head>

<body class="admin">
	<div id="container">
    	<div id="header">
        	<img src="../assets/images/cvn-header.jpg" alt="CVN Header" />
        	<?php 
			if($_SESSION['Login'] != '') {
				include("assets/includes/admin-menu.php");
			} else {
				include("assets/includes/menu.php");
			}
			if($_SESSION['AccountType'] == 'ADMIN') {
				include("assets/includes/site-admin-menu.php");
			} elseif($_SESSION['AccountType'] == 'UC') {
				include("assets/includes/uc-admin-menu.php");
			}
			
			?>
        </div><!-- end header -->
        
        <div id="content">
        	<div id="main" class="float-left">
           <h2>Event Attendance</h2><br />
		  <p>Please note that this page is loading a lot of information. Loading times may be longer than normal.</p><br />
           <?php if($_SESSION['attendance-message'] != '') {
					echo "<div class='success'>".$_SESSION['attendance-message']."</div>"; 
			} else if($_SESSION['attendance-error'] != '') {
					echo "<div class='error'>".$_SESSION['attendance-error']."</div>"; 
			}
			?>
                <div class="box">
                    <strong>Pull Attendance List</strong>
                <?php
                  
                    $query = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 AND Type<>'Meeting' AND EndTime > '".date("Y-m-d H:i:s")."' ORDER BY CallTime ASC";
                    //echo $query;
                    $result = mysql_query($query);
                    while($row = mysql_fetch_array($result)){
                        ?>
                                 <div class="event"><?php echo $row['Name']; ?></div>
                                 <div class="toggle-container">
                                 		<a class="export float-right" href="export-event-list.php?ID=<?php echo $row['ID']; ?>">Export Usher List</a>
                                       	<form action="rae_hypotheticalAttendance.php" method="get">
                                        	<input type="text" name="number-pull" id="number-pull" class="pull" maxlength="2" style="width:30px; background-color:#FFF; border:1px solid #000;"  /> # of Ushers to add &nbsp;&nbsp;
                                            <input type="hidden" name="eventID" id="eventID" value="<?php echo $row['ID']; ?>"  />
                                            <input type="submit" id="pull-atten" style="color: #FFFFFF;" value="Get Attendance" style="background-color:#999; color:#000; display:inline;" />
                                        </form><br />
                                 		<strong>Usher Requests:</strong><br />
										<table width="100%">
										<tr>
										<td>Name</td><td>Email</td><td>Points</td></tr>
                                        <?php
                                        $query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Requested' ORDER BY U.LastName ASC";
                    					//echo $query;
										$counter = 0;
                    					$result2 = mysql_query($query2);
                    					while($row2 = mysql_fetch_array($result2)){
											$counter++;
											echo "<tr><td><strong>$counter.</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . calculatePointTotal($row2["ID"]) . "</td></tr>";
										}
										?>
										</table>
                                        <br /><strong>Confirmed Ushers:</strong><br />
										<table width="100%">
										<tr>
										<td>Name</td><td>Email</td><td>Points</td></tr>
                                        <?php
                                        $query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Ushering'  ORDER BY U.LastName ASC";
                    					//echo $query;
										$counter = 0;
                    					$result2 = mysql_query($query2);
                    					while($row2 = mysql_fetch_array($result2)){
											$counter++;
											echo "<tr><td><strong>$counter.</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . calculatePointTotal($row2["ID"]) . "</td></tr>";
										}
										?>
										</table>
                                        <br /><strong>Cut Ushers:</strong><br />
										<table width="100%">
										<tr>
										<td>Name</td><td>Email</td><td>Points</td></tr>
                                        <?php
                                        $query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Cut'  ORDER BY U.LastName ASC";
                    					//echo $query;
										$counter = 0;
                    					$result2 = mysql_query($query2);
                    					while($row2 = mysql_fetch_array($result2)){
											$counter++;
											echo "<tr><td><strong>$counter.</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . calculatePointTotal($row2["ID"]) . "</td></tr>";
										}
										?>
										</table>
                                        <br />
                                 </div>
                            <?php
                    }
               ?>   
                </div>
                
            </div>
            <?php include('assets/includes/sidebar.php'); ?>
            <br class="clear" />
        </div><!-- end content -->
        
        <div id="footer">
        	© 2008-2010 all rights reserved.
        </div><!-- end footer -->
	</div>
</body>
</html>
<?php $_SESSION['attendance-message'] = ''; $_SESSION['attendance-error'] = ''; ?>