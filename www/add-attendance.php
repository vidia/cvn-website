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
	$PageTitle = "Add Attendance";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="attendance-admin.php">Manage Attendance</a></li>
            <li class="active">Add Attendance</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-8">
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


	 		<form class="form-horizontal" action="doEditAttendance.php" method="post">			
	 			<div class="alert alert-info">Use this page only when <b>adding</b> attendance. If the user already has attendance marked for the event,
	 			 please modify it through the <a class="alert-link" href="user-admin.php">user's profile page</a>.</div>		


	 			<?php
	 			$user = $_GET["ID"];		
	 			$SQL = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 ORDER BY Event.CallTime DESC";	
 			 	$result = mysql_query($SQL);						
 			 	if(mysql_num_rows($result) > 0) {
	 			 ?>

	 			 	<div class="form-group">
						<label for="Name" class="col-sm-2 control-label">Event</label>
						<div class="col-sm-10">
							<select class="form-control" name='addEvent'>
				 			 	<?php				
					 			 	while($event = mysql_fetch_array($result)) {							
					 			 		echo "<option value='" . $event["ID"] . "'> " . $event["Name"] . " &nbsp;</option>";					
					 			 	}		
					 			?>	
					 		</select>
							
						</div>
					</div>

					<div class="form-group">
						<label for="Name" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<select class="form-control" name='addRequest'>
				 			 	<?php										
				 			 		$attendanceArray = array("Requested", "Present", "Cancelled", "Cut", "No-Show");					
				 			 		foreach($attendanceArray as $value) {						
				 			 			echo "<option value='".$value."'> ".$value." &nbsp;</option>";									
				 			 		}			
				 			 	?>
			 			 	</select>
							
						</div>
					</div>
		 			<input type='hidden' name='addUser' value='<?= $user ?>' />			
		 			<input type='hidden' name='addDate' value='<?=  date("Y-m-d H:i:s")?>' />				
		 			<input type='hidden' name='action' value='add' />

		 			<div class="form-group">
		 				<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
						 	<input class="btn btn-success btn-block" type='submit' value='Add Attendance' />									
						</div>
					</div>							

	 			 	
	 			 	<?php	
	 			 	}			
	 			 	else {			
	 			 		// none			
	 			 	}		
	 			 	?>					
	 			 	</form>      
	 		</div>
	 		</div>
	 		</div>
<?php
include_once("assets/includes/footer.php");
?>


