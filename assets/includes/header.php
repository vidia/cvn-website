<?php
session_start();
include_once("assets/includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Convocations Voice Network (CVN) was officially established in 1985 to support and promote the performing-arts events brought to campus by Purdue Convocations. Today, CVN has a membership of more than 300 students from various majors and backgrounds who participate in every performance of the season by ushering and selling merchandise and concessions for all Convocations events. All members ushering for a given show are invited to stay and see that show for free! CVN members may usher for as many or as few shows as they like.">
    <meta name="author" content="kenny@digital-inflection.com">

    <title>CVN Ushering Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
          <?php if(!empty($_SESSION["UID"])) { ?>
            <a class="navbar-brand" href="dashboard.php"><img src="http://www.purduecvn.com/wp-content/uploads/2014/03/logo_main.png" /></a>
          <?php } else {  ?>
            <a class="navbar-brand" href="/"><img src="http://www.purduecvn.com/wp-content/uploads/2014/03/logo_main.png" /></a>
          <?php } ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right"  style="margin-top: 10px;">
            <?php if(!empty($_SESSION["UID"])) { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bookmark"></i> Resources <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="resources">Ushering Resources</a></li>
                <li><a href="dress-code">Dress Code</a></li>
              </ul>
            </li>
          <?php } else { ?>
            <li><a href="/"><i class="fa fa-arrow-left"></i> Back to Public Site</a></li>
            <li><a href="register.php"><i class="fa fa-plus"></i> Register</a></li>
            <li><a href="login.php"><i class="fa fa-sign-in"></i> Log In</a></li>
          <?php } ?>

            <?php if($_SESSION["AccountType"] == "ADMIN" || $_SESSION["AccountType"] == "UC") { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-lock"></i> Control Panel <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="event-admin.php"><i class="fa fa-calendar-o"></i> Events</a></li>
                <li><a href="attendance-admin.php"><i class="fa fa-check-square-o"></i> Attendances</a></li>
                <li><a href="meeting-admin.php"><i class="fa fa-check-square-o"></i> Meeting Attendances</a></li>
                <?php if($_SESSION["AccountType"] == "ADMIN") :?>
                  <li><a href="season-admin.php"><i class="fa fa-exchange"></i> Manage Seasons</a></li>
                <?php endif; ?>
                <li><a href="edit-email.php"><i class="fa fa-envelope"></i> Emails</a></li>
                <li><a href="user-admin.php"><i class="fa fa-users"></i> Users</a></li>
                <li><a href="export-data.php"><i class="fa fa-bar-chart-o"></i> Data</a></li>
                <?php if($_SESSION["AccountType"] == "ADMIN") :?>
                  <li><a href="site-admin.php"><i class="fa fa-cog"></i> Site Settings</a></li>
                <?php endif; ?>
              </ul>
            </li>
            <?php }

            if(!empty($_SESSION["UID"])) { ?>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= $_SESSION["Name"]?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="my-account.php"><i class="fa fa-user"></i> Update Profile</a></li>
                <li><a href="my-account.php"><i class="fa fa-list"></i> Point Total</a></li>
                <li><a href="my-account.php"><i class="fa fa-clock-o"></i> Show History</a></li>
                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>




    <br /><br />
    <?php
      $sql = "SELECT * FROM Settings WHERE intSettingsID=1";
      $result = mysql_query($sql);
      $settings = mysql_fetch_array($result);
      if($settings["isMaintenance"]) :
    ?>
        <div class="container">
          <div class="row">
            <div class="alert alert-warning"><i class="fa fa-warning"></i> <strong>MAINTENANCE MODE</strong> - This site is currently undergoing maintenance. Ushers and Usher Coordinators cannot log in at this time.</div>
          </div>
        </div>
    <?php endif; ?>