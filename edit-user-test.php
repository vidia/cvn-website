<?php session_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include_once("assets/includes/constants.php");

		$SQL = "SELECT * FROM User WHERE ID='".$_GET['ID']."'";
		$result = mysql_query($SQL);
		while($row = mysql_fetch_array($result)) {
?>

<script type="text/javascript">
function Verify_Delete()
{
	var r=confirm("Are you sure you want to delete this?\nThis cannot be undone. Your actions are recorded.");

	if (r==true)
  	{
  		return true;
  	}
	else
  	{
  		return false;
  	}
}
</script>
<script type="text/JavaScript">
<!--
function showthetable(theTable)
{
      if (document.getElementById(theTable).style.display == 'none')
      {
            document.getElementById(theTable).style.display = 'block';
      }
}
//-->
</script>

<div class="container">
      <div class="row">
        <div class="col-lg-12">
          <?php
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Edit User <small><?= $row["FirstName"] . " " . $row["LastName"] ?> </small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
          	<li><a href="user-admin.php">Manage Users</a></li>
            <li class="active">Edit User</li>
          </ol>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-6">
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

            <?php if($_SESSION['AccountType'] == 'ADMIN') { ?>

            <form class="form-horizontal" action="doEditUser.php" method="post">
            	<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">General Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="username" id="username" disabled="disabled" value="<?php echo $row['Username']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Points</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="points" id="points" disabled="disabled" value="<?php echo getPoints($_GET['ID']); ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">First Name</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $row['FirstName']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Last Name</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $row['LastName']; ?>" />
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Account Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="email" id="email" value="<?php echo $row['Email']; ?>" />
							</div>
						</div>

						<div id="passNotice" style="display: none;">
							<div class="alert alert-info">A password is not required to modify the user's profile. If you do not want their password changed, you may leave these fields blank.</div>
			 			</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input class="form-control" onFocus="showthetable('passNotice')" type="password" name="password" id="password" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Confirm Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="confirm-password" id="confirm-password" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Account Type</label>
							<div class="col-sm-10">
								 <select class="form-control" name="AcctType" id="AcctType">
					                <?php
										$accountArray = array("USHER",  "UC", "ADMIN");
										foreach($accountArray as $value) {
											if ($row['AcctType'] == $value) {
												echo "<option selected='selected' value='".$value."'> " .$value. "&nbsp;</option>";
											} else {
												echo "<option value='".$value."'> ".$value." </option>";
											}
										}

										?>
					            </select>

							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Account Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-10">
								 <select class="form-control" name="year" id="year">
					                <?php
										$yearArray = array("Freshman",  "Sophomore", "Junior", "Senior", "Graduate Student", "Staff");
										foreach($yearArray as $value) {
											if ($row['Class'] == $value) {
												echo "<option selected='selected' value='".$value."'>".$value."&nbsp;</option>";
											} else {
												echo "<option value='".$value."'>".$value."
												&nbsp;</option>";
											}
										}
									?>
				                </select>
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Graduation Year</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="grad" id="grad" maxlength="4" value="<?php echo $row['GraduationDate']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">College</label>
							<div class="col-sm-10">
								 <select class="form-control" name="college" id="college">
					                <?php
										$collegeArray = array("College of Agriculture", "College of Consumer and Family Sciences", "College of Education", "College of Engineering", "College of Liberal Arts", "Krannert School of Management", "College of Pharmacy, Nursing, and Health Sciences", "College of Science", "College of Technology", "School of Veterinary Medicine", "Other");
										foreach($collegeArray as $value) {
											if ($row['College'] == $value) {
												echo "<option selected='selected' value='".$value."'>".$value."</option>";
											} else {
												echo "<option value='".$value."'>".$value."</option>";
											}
										}
									?>
				                </select>
							</div>
						</div>
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Marketing</label>
							<div class="col-sm-10">
									<input type="checkbox" name="marketing" id="marketing" <?php if($row['Marketing'] == chr(0x01)) { echo "checked='checked'"; } ?> /> User is interested in being contacted to help with marketing events in exchange for show tickets
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="form-group">
							<div class="col-sm-12">
								 <input class="btn btn-success btn-block" type="submit" value="Edit User" name="edit-user" id="edit-user" />
								 <input onclick='return Verify_Delete('.$row['ID'].')' style='cursor: pointer;' rel='tooltip' title='Delete " . $row['FirstName'] . " " . $row['LastName']. "' class='btn btn-danger'><i class='fa fa-trash-o'></i></input>
                				 <input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']; ?>" />
							</div>
						</div>


            </form>
			<?php } //end if

			else {

				echo "<div class='alert alert-warning'>Usher Coordinators cannot edit the personal account information of users. Please contact an administrator to make changes to <b>" .  $row['FirstName'] . " " . $row['LastName'] . "'s </b>account.</div>";

			}
			?>
		</div>
		<div class="col-lg-6">

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Point Breakdown</h3>
					</div>
					<div class="panel-body">
				       <?php

					    $sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $_GET['ID'] . "';";
						$result2 = mysql_query($sqlYears);
						$row2 = mysql_fetch_array($result2);
						$years = $row2["YearsInvolved"];
					    $points = calculateActivity($_GET['ID']);

						// returns current points
					    $CurrentPoints = getPoints($_GET['ID']);

					    // calculate last semester's points (season)
					    // get previous season ID
					    // use calculatePreviousPoints() from constants.php
					    $sql = "SELECT SeasonID FROM Season WHERE Current=1";
						$result = mysql_query($sql);
						$currentSeasonID = mysql_fetch_array($result);
						$previousSeasonID = $currentSeasonID["SeasonID"]-1;

						// Select and calculate the points from the PREVIOUS season
						$previousPoints = array_sum(calculatePreviousPoints($_GET['ID'], $previousSeasonID));
						// Starting August 2014, previous semester's points will be divided by 10
						// and rounded up and added to previous years
						$previousPoints = round($previousPoints/10);


					   ?>

					   <div class="list-group">
							<?php
							($CurrentPoints < 0) ? $CurrentPointsFormatted = "<span style='color: #990000;'>" . $CurrentPoints . "</span>" :  $CurrentPointsFormatted = "<span style='color: #009900;'>" . $CurrentPoints . "</span>";
							?>

							<li class="list-group-item">
							    <h4 class="list-group-item-heading">Total Points: <?= $CurrentPointsFormatted ?></h4>

							</li>

							<li class="list-group-item">
							    <h4 class="list-group-item-heading">Point Breakdown</h4>
							    <p class="list-group-item-text">
							    	<strong><?php echo $CurrentPoints; ?></strong> =
									1(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Points for Shows Ushered"><?php echo $points['Present']*1; ?></acronym></strong>)
									+ 15(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Shows Cut"><?php echo ($points['Cut']+$points['Late-Add-Cancel'])*1;  ?></acronym></strong>)
									- 45(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Shows Signed Up & Skipped"><?php echo $points['No-Show']*1;  ?></acronym></strong>)
									- 15(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Shows Cancelled Within 48 Hours of Call Time"><?php echo $points['Cancelled']*1;  ?></acronym></strong>)
									- 15(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Arrived More Than 15 Minutes Late"><?php echo $points['Late']*1;  ?></acronym></strong>)
									+ 5(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Arrived Less Than 15 Minutes Late"><?php echo $points['Tardy']*1;  ?></acronym></strong>)
									+ 5(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Dress Code Violation"><?php echo $points['Dress-Violation']*1;  ?></acronym></strong>)
									+ 3(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Social Events/Meetings"><?php echo $points['Meeting']*1;  ?></acronym></strong>)
									+ <strong><acronym rel="tooltip" style="cursor: pointer;" title="Years Involved"><?php echo $years*1;  ?></acronym></strong>
									+ <strong><acronym rel="tooltip" style="cursor: pointer;" title="Previous Semester Rollover"><?php echo $previousPoints; ?></acronym></strong>
							    </p>
							</li>
						</div>
					</div>
				</div><!-- /.panel-->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?= $row['FirstName'] . " " . $row['LastName']?>'s Attendance Administration</h3>
					</div>
					<div class="panel-body">

            <?php
			} ?>
			<a class="btn btn-success pull-right" href="add-attendance.php?ID=<?php echo $_GET["ID"]; ?>">Add Attendance</a><br class="clear" /><br class="clear" />
			<table class="table table-bordered table-striped table-hover">
			<tr class="head"><td>Event Name</td><td>Status</td><td colspan="2">Modify</td>

			<?php
			$sqlAttendance = "SELECT A.ID,A.EventID,E.CallTime,A.RequestStatus FROM Attendance A, Event E WHERE UserID='".$_GET['ID']."' AND A.EventID = E.ID ORDER BY E.CallTime ASC";
			$resultAttendance = mysql_query($sqlAttendance);

			while($attendance = mysql_fetch_array($resultAttendance)) {
				$sqlEvent = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE ID=" . $attendance["EventID"] . " AND Season.Current=1 AND Event.Archive <> 1 ORDER BY Event.CallTime ASC";
				$resultEvent = mysql_query($sqlEvent);

					while($event = mysql_fetch_array($resultEvent)) {
						?>
						<form class="form-horizontal" action="doEditAttendance.php" method="post">
							<tr><td><?= $event["Name"]; ?></td>
							<td valign="top">
							<select class="form-control" name="RequestStatus" id="RequestStatus">
							<?php
								//$attendanceArray = array("Requested", "Present", "Cancelled", "Cut", "No-Show", "Dress-Violation", "Late");
								foreach($attendanceArray as $value) {
									if ($attendance["RequestStatus"] == $value) {
										echo "<option selected='selected' value='".$value."'> ".$value." &nbsp;</option>";
									} else {
										echo "<option value='".$value."'> ".$value." &nbsp;</option>";
									}
								}
								?>
							</td>
							<td width="15%" valign="middle">
								<input type="submit" value="Update" class="btn btn-default" />
							</td>
							<td width="15%">
								<a class="btn btn-danger" onclick='return Verify_Delete()' href="doEditAttendance.php?action=delete&user=<?php echo $_GET["ID"]; ?>&ID=<?php echo $attendance["ID"]; ?>">Delete</a>
							</td>
							</tr>
							<input type="hidden" name="action" value="edit" />
							<input type="hidden" name="user" value="<?php echo $_GET["ID"]; ?>" />
							<input type="hidden" name="attendanceID" value="<?php echo $attendance["ID"]; ?>" />
						</form>
						<?php }	// end event while ?>

			<?php } // end attendance while ?>
			</table>
		</div>
	</div> <!-- /.panel-->




			<?php
			//Check to see if the profile is a UC, otherwise, no reason to add defaults
				$SQL = "SELECT AcctType FROM User WHERE ID='".$_GET['ID']."'";
				$result = mysql_query($SQL);
				$row = mysql_fetch_array($result);
				if($row["AcctType"] == "UC")
				{
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Usher Defaults</h3>
						</div>
						<div class="panel-body">
			<?php
			// check to see if the person logged in is an admin, or else they can't add defaults.
			if($_SESSION["AccountType"] == "ADMIN")
			{
			?>
			<!-- Modal -->
			<div class="modal fade" id="ucDefault" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Add Default</h4>
			      </div>
			      <div class="modal-body">
			        	<form class="form-horizontal" action="doAddDefault.php" method="post">
			        		<div class="form-group">
								<label for="Name" class="col-sm-2 control-label">Reason</label>
								<div class="col-sm-10">
									<select class="form-control" name="reason">
										<option name="Not Selected">Select a Reason</option>
										<option name="Unexcused Absence">Unexcused Absence</option>
										<option name="Tardiness">Tardiness</option>
										<option name="Failure to Attend Enough Shows">Failure to Attend Enough Shows</option>
										<option name="Failure to Work Assigned Position">Failure to Work Assigned Position</option>
										<option name="Failure to Work Concession">Failure to Work Concession</option>
										<option name="Failure to Perform Tasks Effectively">Failure to Perform Tasks Effectively</option>
										<option name="Failure to Perform Duties per the Constitution">Failure to Perform Duties per the Constitution</option>
									</select>
								</div>
							</div>
							<input type="hidden" name="user" value="<?php echo $_GET["ID"]; ?>" />
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-success">Add Default</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<button class="btn btn-success pull-right" data-toggle="modal" data-target="#ucDefault">Add Default</button>
			<br class="clearfix" /><br class="clearfix" />

			<?php
				$sqlSeason = "Select SeasonID FROM Season Where Current=1;";
				$resultSeason = mysql_query($sqlSeason);
				$rowSeason = mysql_fetch_array($resultSeason);

				$sqlDefaults = "SELECT * FROM Defaults WHERE UserID='".$_GET['ID']."' AND Archived=0 AND Defaults.SeasonID=" . $rowSeason["SeasonID"];
				$resultDefaults = mysql_query($sqlDefaults);
				$numberResults = mysql_num_rows($resultDefaults);

				if($numberResults > 0)
					{
						echo "<table class='table table-bordered table-striped table-hover'>";
						echo "<thead><tr><th>Reason</th><th>Date</th><th>Remove</th></thead>";


					while($defaults = mysql_fetch_array($resultDefaults))
					{
						echo "<tr>";
						echo "<td>" . $defaults["Reason"] . "</td>";
						echo "<td>" . $defaults["DateReported"] . "</td>";
	 				?>

						<td width="20%">
							<a class="btn btn-danger" onclick='return Verify_Delete()' href="doEditDefault.php?action=delete&user=<?php echo $_GET["ID"]; ?>&ID=<?php echo $defaults["DefaultID"]; ?>">Remove</a>
						</td>
					</tr>
					<?php
					} //end while

					echo "</table>";

				}//end if
				else
				{
					echo "<table class='table table-bordered'><tr><td>There are no defaults recorded for this season. Yay!</td></tr></table>";

				}
				?>

			</fieldset>

			<?php
			} // end if session accttype is ADMIN
			else {
				echo "<div class='alert alert-warning'>Usher Coordinators cannot edit the defaults of other Usher Coordinators.</div>";
			}
			?>
				</div>
			</div>
			<?php
			} //end if accttype is UC
			?>



		</div>
	</div>
</div>
<?php
include_once("assets/includes/footer.php");
?>