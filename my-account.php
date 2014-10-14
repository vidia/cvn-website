<?php
include_once("assets/includes/verify.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php");
?>

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
	$PageTitle = "My Account";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">My Account</li>
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
           <?php
		    $query = "SELECT * FROM User WHERE Username='".$_SESSION['Login']."'";
			$result = mysql_query($query);

			while($row = mysql_fetch_array($result)){
				$prevPointTotal = $row['PrevPointTotal'];
				$returningUsher = $row['ReturningUsher']; ?>


                <form class="form-horizontal" role="form" action="doEditAccount.php" method="post" />
				<!-- Start Personal Information Panel -->
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Personal Information</h3>
				  </div>
				  <div class="panel-body">
					<div class="form-group">
						<label for="username" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="username" id="username" disabled="disabled" value="<?php echo $row['Username']; ?>" />
						</div>
					</div>

					<div class="form-group">
						<label for="firstname" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $row['FirstName']; ?>" />
						</div>
					</div>

					<div class="form-group">
						<label for="lastname" class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $row['LastName']; ?>" />
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="email" id="email" value="<?php echo $row['Email']; ?>" />
						</div>
					</div>
				  </div>
				</div> <!-- End Personal Information Panel -->

				<!-- Start College Information Panel -->
				<div class="panel panel-default">
					<div class="panel-heading">
				    	<h3 class="panel-title">College Information</h3>
					</div>
					<div class="panel-body">
					  	<div class="form-group">
							<label for="year" class="col-sm-2 control-label">Class</label>
							<div class="col-sm-10">
								<select class="form-control" name="year" id="year">
									<?php
										$yearArray = array("Freshman",  "Sophomore", "Junior", "Senior", "Graduate Student", "Staff");
										foreach($yearArray as $value) {
											if ($row['Class'] == $value) {
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
							<label for="grad" class="col-sm-2 control-label">Graduation Date</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="grad" id="grad" maxlength="4" value="<?php echo $row['GraduationDate']; ?>" />
								<div class="help-block">Example: 2016</div>
							</div>
						</div>

						<div class="form-group">
							<label for="college" class="col-sm-2 control-label">College</label>
							<div class="col-sm-10">
								<select class="form-control" name="college" id="college">
									<?php
										$collegeArray = array("Not Selected", "College of Agriculture", "College of Education", "College of Engineering", "College of Health and Human Sciences", "College of Liberal Arts", "Krannert School of Management", "College of Pharmacy", "College of Science", "College of Technology", "College of Veterinary Medicine", "Graduate School");
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
					</div>
				</div> <!-- End College Information Panel -->





				<div class="panel panel-default">
					<div class="panel-heading">
				    	<h3 class="panel-title">Change Account Password</h3>
					</div>
					<div class="panel-body">
						<!-- Let them know about changing their password -->
						<div id="passNotice" style="display: none;">
							<div class="alert alert-info">Your password is not required to modify your profile. If you do not want your password changed, you may leave these fields blank.</div>
				   		</div>

				   		<div class="form-group">
							<label for="password" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input class="form-control" onFocus="showthetable('passNotice')"  type="password" name="password" id="password" />
							</div>
						</div>

						<div class="form-group">
							<label for="confirm-password" class="col-sm-2 control-label">Confirm Password</label>
							<div class="col-sm-10">
								<input class="form-control" type="password" name="confirm-password" id="confirm-password" />
							</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
				    	<h3 class="panel-title">Account Bio</h3>
					</div>
					<div class="panel-body">

				   		<div class="form-group">
							<label for="bdmonth" class="col-sm-2 control-label">Birthday</label>
							<div class="col-sm-10">
								<div class="row">
								<div class="col-sm-6">
									<select class="form-control" id="bdmonth" name="bdmonth">
										<?php
											$bdmonth = array("Month", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
											foreach($bdmonth as $value) {
												if ($row['bdmonth'] == $value) {
													echo "<option selected='selected' value='".$value."'>".$value."</option>";
												} else {
													echo "<option value='".$value."'>".$value."</option>";

												}
											}
										?>
									<select>
								</div>
								<div class="col-sm-3">
									<select class="form-control" name="bdday">
										<?php
											$bdday = array("Day", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
											foreach($bdday as $value) {
												if ($row['bdday'] == $value) {
													echo "<option selected='selected' value='".$value."'>".$value."</option>";
												} else {
													echo "<option value='".$value."'>".$value."</option>";

												}
											}
										?>
									</select>
								</div>
								<div class="col-sm-3">
									<input class="form-control" placeholder="Year" type="text" name="bdyear" value="<?php echo $row["bdyear"]; ?>" maxlength="4" size="4"/>
								</div>
								</div> <!-- /.row -->
							</div>
						</div>

						<div class="form-group">
							<label for="residence" class="col-sm-2 control-label">Residence</label>
							<div class="col-sm-10">
								<select class="form-control" id="residence" name="residence">
							    	<?php
										$residence = array("Select One", "Non-Residence Hall", "Cary Quadrangle", "Earhart Hall", "First Street Towers", "Harrison Hall", "Hawkins Hall", "Hillenbrand Hall", "Hilltop Apartments", "McCutcheon Hall", "Meredith Hall", "Owen Hall", "Purdue Village", "Shreve Hall", "Tarkington Hall", "Wiley Hall", "Windsor Hall");
										foreach($residence as $value) {
											if ($row['residence'] == $value) {
												echo "<option selected='selected' value='".$value."'>".$value."</option>";
											} else {
												echo "<option value='".$value."'>".$value."</option>";

											}
										}
									?>
							    </select>
							</div>
						</div>

						<legend>Favorites</legend>

						<div class="form-group">
							<label for="artist" class="col-sm-2 control-label">Artist</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="artist" name="artist" value="<?php echo $row['artist']; ?>"/>
							</div>
						</div>

						<div class="form-group">
							<label for="song" class="col-sm-2 control-label">Song</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="song" name="song" value="<?php echo $row['song']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="movie" class="col-sm-2 control-label">Movie</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="movie" name="movie" value="<?php echo $row['movie']; ?>"/>
							</div>
						</div>

						<div class="form-group">
							<label for="book" class="col-sm-2 control-label">Book</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="book" name="book" value="<?php echo $row['book']; ?>"/>
							</div>
						</div>

						<div class="form-group">
							<label for="show" class="col-sm-2 control-label">Show</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="show" name="show" value="<?php echo $row['usershow']; ?>" />
							</div>
						</div>

						<legend>Marketing Questions</legend>
						<div class="form-group">
							<label for="referred" class="col-sm-2 control-label">How did you hear about us?</label>
							<div class="col-sm-10">
								<select class="form-control" id="referred" name="referred">
									<?php
										$referred = array("Not Selected", "Callout", "Flyering", "Chalking", "Friend/Relative", "BGR", "Other");
										foreach($referred as $value) {
											if ($row['referred'] == $value) {
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
							<label for="confirm-password" class="col-sm-2 control-label">Options</label>
							<div class="col-sm-10">
								<div class="checkbox">
								    <label>
								      <input type="checkbox" name="marketing" id="marketing" <?php if($row['Marketing'] == chr(0x01)) { echo "checked='checked'"; } ?> /> Yes, I am interested in being contacted to help with marketing events in exchange for show tickets
								    </label>
						    	</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-12">
						<input type="hidden" name="ID" id="ID" value="<?php echo $_SESSION['UID']; ?>" />
						<button class="btn btn-success btn-block" type="submit" name="edit-user" id="edit-user">
							<i class='fa fa-save'></i> Update My Account
						</button>
					</div>
				</div>
            </form>
           <?php } //end while (why did Chris make this a while??) ?>
       </div>
       <div class="col-lg-6">

			<a name="breakdown"></a>

            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">My Point Total and Show History</h3>
				</div>
				<div class="panel-body">

			           <?php

					    $sqlYears = "SELECT YearsInvolved FROM User WHERE ID='" . $_SESSION['UID'] . "';";
						$result2 = mysql_query($sqlYears) or die("DEADEDED");
						$row2 = mysql_fetch_array($result2);
						$years = $row2["YearsInvolved"];

						// get points by status
					    $points = calculateActivity($_SESSION['UID']);

					    // returns current points and updates DB with current point calculation
					    $CurrentPoints = calculatePointTotalDB($_SESSION['UID']);

					    // calculate last semester's points (season)
					    // get previous season ID
					    // use calculatePreviousPoints() from constants.php
					    $sql = "SELECT SeasonID FROM Season WHERE Current=1";
						$result = mysql_query($sql);
						$currentSeasonID = mysql_fetch_array($result);
						$previousSeasonID = $currentSeasonID["SeasonID"]-1;

						// Select and calculate the points from the PREVIOUS season
						$previousPoints = array_sum(calculatePreviousPoints($_SESSION['UID'], $previousSeasonID));
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
								- 5(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Arrived Less Than 15 Minutes Late"><?php echo $points['Tardy']*1;  ?></acronym></strong>)
								- 5(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Dress Code Violation"><?php echo $points['Dress-Violation']*1;  ?></acronym></strong>)
								+ 7(<strong><acronym rel="tooltip" style="cursor: pointer;" title="Social Events/Meetings"><?php echo $points['Meeting']*1;  ?></acronym></strong>)
								+ <strong><acronym rel="tooltip" style="cursor: pointer;" title="Years Involved"><?php echo $years*1;  ?></acronym></strong>
								+ <strong><acronym rel="tooltip" style="cursor: pointer;" title="Previous Semester Rollover"><?php echo $previousPoints; ?></acronym></strong>

						    </p>
						</li>
					</div>

	                <?php
	                $query = "SELECT * FROM Attendance A, Event E JOIN Season S ON E.SeasonID=S.SeasonID WHERE A.UserID='".$_SESSION['UID']."' AND E.ID=A.EventID AND E.Archive<>1 AND S.Current = 1 ORDER BY E.CallTime ASC";
					//echo $query;
					$result = mysql_query($query);
					$resultCount = mysql_num_rows($result);
					if($resultCount > 0) {
						echo "<div class='list-group'>";
						while($row = mysql_fetch_array($result)){

							echo "<li class='list-group-item'>";
						    echo "<h4 class='list-group-item-heading'>"  . $row['Name'] ."</h4>";
						    echo "<p class='list-group-item-text'>";
								if ($row['RequestStatus'] == 'Present') {
									echo "<i style='color: #009900;' class='fa fa-plus'></i> You were present and received " . $row['Point'] . " points.";
								} // end if
								else if ($row['RequestStatus'] == 'Cut') {
									echo "<i style='color: #009900;' class='fa fa-plus'></i> You were cut and received 15 points.";
								} // end if
								else if ($row['RequestStatus'] == 'No-Show') {
									echo "<i style='color: #990000;' class='fa fa-minus'></i> You never showed up and lost 45 points.";
								} // end if
								else if ($row['RequestStatus'] == 'Dress-Violation') {
									echo "<i style='color: #009900;' class='fa fa-plus'></i> You violated the dress code and gained 5 points instead of " . $row["Point"] . " points.";
								} // end if
								else if ($row['RequestStatus'] == 'Late') {
									echo "<i style='color: #990000;' class='fa fa-minus'></i> You were late and lost 15 points.";
								} // end if
								else if ($row['RequestStatus'] == 'Tardy') {
									echo "<i style='color: #009900;' class='fa fa-plus'></i> You were tardy and gained 5 points intead of " . $row["Point"] . " points.";
								} // end if
								else if ($row['RequestStatus'] == 'Late-Add-Cancel') {
									echo "<i style='color: #009900;' class='fa fa-plus'></i> You gained 15 points.";
								} // end if
								else if ($row['RequestStatus'] == 'Cancelled') {
									echo "<i style='color: #990000;' class='fa fa-minus'></i> You canceled late and lost 15 points.";
								} // end if
								else if($row['RequestStatus'] == "Ushering") {
									echo "Attendance has not been completed for this show. Please check back later.";
								}
								else if($row["RequestStatus"] == "Requested"){
									echo "Your request is pending. You'll be notified if you are selected to usher.";
								}
								else {
									echo "There was an error. Please contact the webmaster to report.";
								}

							echo "</p>";
							echo "</li>";
		                	} // end while
		                	echo "</div>";
		            } // end if
		            else {
		            	echo "<div class='alert alert-info'><i class='fa fa-info-circle'></i> You have no point history this season.</div>";

		            }
					?>
					</div> <!-- /.panel-content -->
			</div> <!-- /.panel -->


						<?php
						if($_SESSION["AccountType"] == "UC" || $_SESSION["AccountType"] == "ADMIN")
						{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">My Defaults</h3>
							</div>
							<div class="panel-body">
								<?php
									$sqlSeason = "Select SeasonID FROM Season Where Current=1;";
									$resultSeason = mysql_query($sqlSeason);
									$rowSeason = mysql_fetch_array($resultSeason);

									$sqlDefaults = "SELECT * FROM Defaults WHERE UserID='".$_SESSION["UID"]."' AND Archived=0 AND Defaults.SeasonID=" . $rowSeason["SeasonID"];
									$result = mysql_query($sqlDefaults);
									$resultCount = mysql_num_rows($result);

									if($resultCount > 0) {
										echo "<div class='list-group'>";
										while($row = mysql_fetch_array($result)){
											echo "<li class='list-group-item'>";
											echo "<h4 class='list-group-item-heading'>"  . $row['Reason'] ."</h4>";
									    	echo "<p class='list-group-item-text'>";
											echo "Reported on " . date("M d, Y", strtotime($row['DateReported'])) . ".";
											echo "</p></li>";
			                			}
			                			echo "</div>";
			                		}
			                		else {
			                			echo "<li class='list-group-item'>";
										echo "<h4 class='list-group-item-heading'>Your Record Is Clean</h4>";
								    	echo "<p class='list-group-item-text'>";
										echo "You have no defaults reported against you.";
										echo "</p></li>";
			                		}
								?>
							</div>
						</div> <!-- /.panel -->
					<?php } // end if account type is UC ?>
    	</div>
	</div>
</div>


<?php
include_once("assets/includes/footer.php");
?>
