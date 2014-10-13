<?php 
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php");
?>
<script src="assets/js/datetimepicker_css.js"></script>

<div class="container">
      
      <div class="row">
        <div class="col-lg-12">
          <?php 
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Create an Event <small><?= $helloArray[$randHello] . " " . $_SESSION["Name"] . " <a href='my-account.php#breakdown' rel='tooltip' title='Total points' class='label label-info'>" . $_SESSION["Points"] . "</a>"; ?></small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="event-admin.php">Manage Events</a></li>
            <li class="active">Create an Event</li>
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

			
			 <form class="form-horizontal" action="doAddEvent.php" method="post">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">General Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input placeholder="NEEDTOBREATHE Concert" class="form-control" type="text" name="Name" id="Name" />
							</div>
						</div>

						<div class="form-group">
							<label for="Type" class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								 <select class="form-control" name="Type" id="Type">
				                	<option value="Show">Show</option>
				                    <option value="Meeting">Meeting</option>	
				                </select>
							</div>
						</div>

						<div class="form-group">
							<label for="preshow" class="col-sm-2 control-label">Exception</label>
							<div class="col-sm-10">
								<select class="form-control" name="preshow" id="preshow">
				                	<option value="0">No Exception</option>
				                	<?php 
				                		// find the current season
				                		$SQL3 = "SELECT * FROM Season WHERE Current = 1";
										$result3 = mysql_query($SQL3);
										$row5 = mysql_fetch_array($result3);

										// show shows that are from that season
										$SQL2 = "SELECT * FROM Event WHERE SeasonID=" . $row5["SeasonID"] ;
										$result2 = mysql_query($SQL2);
										while($row2 = mysql_fetch_array($result2)) {
											echo "<option value='".$row2['ID']."'>".$row2['Name']."</option>";
										}
									?>
				                </select>
				                <div class="help-block">An exception will not allow a user to sign up for both this show and the show you select above.</div>
							</div>
						</div>

						<div class="form-group">
							<label for="Location" class="col-sm-2 control-label">Location</label>
							<div class="col-sm-10">
								  <input placeholder="Loeb Playhouse" class="form-control" type="text" name="Location" id="Location" />
							</div>
						</div>

						<div class="form-group">
							<label for="Description" class="col-sm-2 control-label">Event Description</label>
							<div class="col-sm-10">
								   <input placeholder="Some info about this event" class="form-control" type="text" rows="5" name="Description" id="Description"/>
							</div>
						</div>

						<div class="form-group">
							<label for="Point" class="col-sm-2 control-label">Point Value</label>
							<div class="col-sm-10">
								<input placeholder="10" class="form-control" type="text" name="Point" id="Point" />
							</div>
						</div>


					</div>
				</div>   

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Scheduling</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">Post Time</label>  
							<div class="col-sm-10">
								<div class="input-group">
								  <input placeholder="Use the calendar button to the right to select." class="form-control" type="text" name="UpTime" id="UpTime" maxlength="25" size="25" />
								  <span class="input-group-addon"><a style='color:#000; cursor: pointer;' onclick="javascript:NewCssCal ('UpTime','MMddyyyy','arrow',true,'12')"><i class="fa fa-calendar"></i></a></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">End Time</label>
							<div class="col-sm-10">
								<div class="input-group">
								  <input placeholder="Use the calendar button to the right to select." class="form-control" type="text" name="EndTime" id="EndTime" maxlength="25" size="25"  />
								  <span class="input-group-addon"><a style='color:#000; cursor: pointer;' onclick="javascript:NewCssCal ('EndTime','MMddyyyy','arrow',true,'12')"><i class="fa fa-calendar"></i></a></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">Call Time</label>
							<div class="col-sm-10">
								<div class="input-group">
								  <input placeholder="Use the calendar button to the right to select." class="form-control" type="text" name="CallTime" id="CallTime" maxlength="25" size="25" />
								  <span class="input-group-addon"><a style='color:#000; cursor: pointer;' onclick="javascript:NewCssCal ('CallTime','MMddyyyy','arrow',true,'12')"><i class="fa fa-calendar"></i></a></span>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Administration</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="UC" class="col-sm-2 control-label">Coordinator</label>
							<div class="col-sm-10">
								 <select class="form-control" name="UC" id="UC">
				                	<?php 
										$SQL2 = "SELECT * FROM User WHERE (AcctType='UC' OR AcctType='ADMIN')";
										$result2 = mysql_query($SQL2);
										while($row2 = mysql_fetch_array($result2)) { 
											if ($_SESSION['addUC'] == $row2['Email']) {
												echo "<option selected='selected' value='".$row2['Email']."'>".$row2['Email']."</option>";
											} else {
												echo "<option value='".$row2['Email']."'>".$row2['Email']."</option>";
											}
										}
									?>
				                </select>
							</div>
						</div>

						<div class="form-group">
							<label for="season" class="col-sm-2 control-label">Season</label>
							<div class="col-sm-10">
								 <select class="form-control" name="season" id="season">
				                	<?php 
										$SQL3 = "SELECT * FROM Season ORDER BY SeasonID ASC";
										$result3 = mysql_query($SQL3);
										while($row2 = mysql_fetch_array($result3)) {
											if($row2["Current"] == 1) {
												echo "<option value='".$row2['SeasonID']."' selected='selected'>".$row2['Season']." &nbsp; &nbsp; </option>";
											}
											else {
												echo "<option value='".$row2['SeasonID']."'>".$row2['Season']." &nbsp; &nbsp; </option>";
											}
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div> <!-- /.panel -->


				
				<div class="form-group">
					<div class="col-sm-12">
	                	<button class="btn btn-success btn-block" type="submit" name="submit-eventl" id="submit-event" /><i class="fa fa-plus"></i> Create Event</button>
					</div>
				</div>
            </form>

		</div>
	</div>
<?php 

include_once("assets/includes/footer.php");
