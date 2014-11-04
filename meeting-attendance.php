<?php session_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php"); 	

$sql = "SELECT * FROM Event WHERE ID=" . (int) $_GET["ID"];
$result = mysql_query($sql);
$event = mysql_fetch_array($result);
?>

<div class="container">
      <div class="row">
        <div class="col-lg-12">

          <h1 class="page-header">Manage Meeting Attendance <small><?= $event["Name"] ?> </small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
          	<li><a href="meeting-admin.php">Meeting Attendance</a></li>
            <li class="active">Manage Meeting Attendance for <?= $event["Name"] ?></li>
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



			<form action="actions/doMeetingAttendance.php" method="post">
            <table class="table table-hover table-striped table-bordered">
			<tr>
				<thead>
					<th style='width: 3%;'><input type="checkbox" name="checkall" id="checkall"  /></th><th>Name</th><th>Email</th></tr>
				</thead>
				<tbody>
            	<?php
				$SQL = "SELECT U.ID As UID, U.Email as Email, U.LastName As LastName, U.FirstName As FirstName, Atten.UserID As UserID, Atten.EventID As EventID FROM User U LEFT JOIN (SELECT * FROM Attendance A WHERE A.EventID='".$_GET['ID']."') as Atten ON U.ID=Atten.UserID ORDER BY U.LastName";
				$result = mysql_query($SQL);
				//echo $SQL;
				while($row = mysql_fetch_array($result)) {
					if ($row['UserID'] == $row['UID'] && $row['EventID'] == $_GET['ID']) {
						if(empty($row['LastName']) || empty($row['FirstName'])) {
							echo "<tr><td style='width:3%' text-align: center;'><input type='checkbox' checked='checked' name='user[]' value='".$row['UID']."' /></td><td><em>Unnamed</em></td><td>".$row['Email']."</td></tr>"; 
						}
						else {
							echo "<tr><td><input type='checkbox' checked='checked' name='user[]' value='".$row['UID']."' /></td><td>".$row['LastName'].", ".$row['FirstName']."</td><td>".$row['Email']."</td></tr>"; 
						}
					} else {
						if(empty($row['LastName']) || empty($row['FirstName'])) {
							echo "<tr><td style='width:3%' text-align: center;'><input type='checkbox' name='user[]' value='".$row['UID']."' /></td><td><em>Unnamed</em></td><td>".$row['Email']."</td></tr>";
						}
						else {
							echo "<tr><td><input type='checkbox' name='user[]' value='".$row['UID']."' /></td><td>".$row['LastName'].", ".$row['FirstName']."</td><td>".$row['Email']."</td></tr>";
						}
					}
					
				}
				
				?>
			</tbody>
            </table>
                <button class="btn btn-success btn-block" type="submit" id="submit-attendance" name="submit-attendance" />Submit Attendance</button>
            	<input type="hidden" name="eventID" id="eventID" value="<?php echo $_GET['ID']; ?>" />
            </form> 
            


<?php
include_once("assets/includes/footer.php"); 	
?>

<script>
  $("#checkall").click(function() {
		if($(this).is(':checked')) {
			$("input[type=checkbox]").attr("checked", "checked");
		} else {
			$("input[type=checkbox]").removeAttr("checked");
		}
	});
</script>
