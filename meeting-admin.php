<?php session_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php"); 	
?>


<script src="assets/js/datetimepicker_css.js"></script>
<div class="container">
      <div class="row">
        <div class="col-lg-12">
<?php
	$PageTitle = "Meeting Attendance";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Meeting Attendance</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-12">
        <?php 
           if($_SESSION['success'] != '') {
					echo "<div class='alert alert-success'>".$_SESSION['success']."</div>"; 
					$_SESSION['success'] = '';
			}
			
			if($_SESSION['error'] != '') {
					echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>"; 
					$_SESSION['error'] = '';
			}
		?>


           <h2>Meeting Attendance</h2>
			<table class="table table-bordered table-hover table-striped">
				<thead>
	           	<tr class="head">
	           		<th>Meeting</th>
	           		<th>Meeting Date</th>
	           		<th>Attendance Link</th>
	           	</tr>
	           </thead>
			<?php
			
			$SQL = "SELECT * FROM Event WHERE Type='Meeting' AND Archive<>1 ORDER BY CallTime DESC";
			$result = mysql_query($SQL);
			while($row = mysql_fetch_array($result)) {
				echo "<tr><td>".$row['Name']."</td><td>".date("m/d/Y", strtotime($row['CallTime']))."</td><td><a href='meeting-attendance.php?ID=".$row['ID']."' />Meeting Attendance</a></td></tr>";
			}
			?>
            </table>

<?php 
include_once("assets/includes/footer.php"); 	
?>


