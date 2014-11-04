<?php 
include_once("assets/includes/verify.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php"); 
$SQL = "SELECT * FROM Event WHERE ID='".$_GET['ID']."'";
$result = mysql_query($SQL);
$row = mysql_fetch_array($result);
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
          <h1 class="page-header">Edit Event <small><?= $helloArray[$randHello] . " " . $_SESSION["Name"] . " <a href='my-account.php#breakdown' rel='tooltip' title='Total points' class='label label-info'>" . $_SESSION["Points"] . "</a>"; ?></small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="event-admin.php">Manage Events</a></li>
            <li class="active">Edit <?= $row["Name"] ?></li>
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

            <form class="form-horizontal" role="form" action="actions/doEditEvent.php" method="post">
            	<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">General Information</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="Name" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="Name" id="Name" value="<?php echo $row['Name']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Type" class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								 <select class="form-control" name="Type" id="Type">
				                	<option value="Show">Show</option>
				                    <option value="Meeting"<?php if($row['Type'] == 'Meeting') { echo " selected='selected'"; } ?>>Meeting</option>	
				                </select>
							</div>
						</div>

						<div class="form-group">
							<label for="Location" class="col-sm-2 control-label">Event Location</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="Location" id="Location" value="<?php echo $row['Location']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="MeetingLoc" class="col-sm-2 control-label">Meeting Location</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="MeetingLoc" id="MeetingLoc" value="<?php echo $row['MeetingLoc']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Point" class="col-sm-2 control-label">Point Value</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" name="Point" id="Point" value="<?php echo $row['Point']; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label for="Description" class="col-sm-2 control-label">Event Description</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="5" name="Description" id="Description"><?php echo $row['Description']; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="SpecialInstr" class="col-sm-2 control-label">Special Instructions</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="SpecialInstr" id="SpecialInstr"><?php echo $row['SpecialInstr']; ?></textarea>
							</div>
						</div>



					</div>
				</div> <!-- /.panel -->

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Scheduling</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">Post Time</label>  
							<div class="col-sm-10">
								<div class="input-group">
								  <input class="form-control" type="text" name="UpTime" id="UpTime" maxlength="25" size="25"  value="<?php echo date("m-d-Y h:iA", strtotime($row['UpTime'])); ?> "/>
								  <span class="input-group-addon"><a style='color:#000; cursor: pointer;' onclick="javascript:NewCssCal ('UpTime','MMddyyyy','arrow',true,'12')"><i class="fa fa-calendar"></i></a></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">End Time</label>
							<div class="col-sm-10">
								<div class="input-group">
								  <input class="form-control" type="text" name="EndTime" id="EndTime" maxlength="25" size="25" value="<?php echo date("m-d-Y h:iA", strtotime($row['EndTime']));?>" />
								  <span class="input-group-addon"><a style='color:#000; cursor: pointer;' onclick="javascript:NewCssCal ('EndTime','MMddyyyy','arrow',true,'12')"><i class="fa fa-calendar"></i></a></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="UpTime" class="col-sm-2 control-label">Call Time</label>
							<div class="col-sm-10">
								<div class="input-group">
								  <input class="form-control" type="text" name="CallTime" id="CallTime" maxlength="25" size="25" value="<?php echo date("m-d-Y h:iA", strtotime($row['CallTime']));?>" />
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
											if ($row['UC'] == $row2['Email']) {
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
							<label for="season" class="col-sm-2 control-label">Coordinator</label>
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
                			<input type="hidden" name="ID" id="ID" value="<?php echo $_GET['ID']; ?>" />
		                	<input type="hidden" name="preshow" id="preshow" value="0" />
							<button class="btn btn-block btn-success" type="submit">
								<i class='fa fa-save'></i> Update Event
							</button>	
					</div>
				</div>

            </form>

            <?php
            /*
            ################################
				This is code from the old site that is moved over due to a feature being worked on.
            ################################
            	<input type="hidden" name="preshow" id="preshow" value="0" />
                <!--<label>Show Exception</label><br />
                <select name="preshow" id="preshow">
					<option value="0">No Exception</option>
						// find the current season
                		$SQL3 = "SELECT * FROM Season WHERE Current = 1";
						$result3 = mysql_query($SQL3);
						$row5 = mysql_fetch_array($result3);

						// show shows that are from that season
						$SQL2 = "SELECT * FROM Event WHERE SeasonID=" . $row5["SeasonID"] ;
						$result2 = mysql_query($SQL2);
						while($row2 = mysql_fetch_array($result2)) {
							// select the show that is currently registered as exception 
							if($row["NoRegister"] == $row2["ID"])
							{
								echo "<option value='".$row2['ID']."' selected='selected'>".$row2['Name'] ."</option>";
							}
							else 
							{
								echo "<option value='".$row2['ID']."'>".$row2['Name'] ."</option>";
							}
						}
                </select>-->
                	<!-- CHANGED 7/10/2012 HELP FOR NEW CHANGE -->
                	<!--	<img src="assets/images/help.png" class="tooltip" title="By selecting another event, you're specifying that a user cannot register for both the event you are currently creating and the event you have selected. Select 'No Exception' if this does not apply to this event." /> -->
                	<!-- END HELP -->
                <!--<br />-->
                */
            ?>

        </div>
        <div class="col-lg-4">
        	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Event Overview</h3>
				</div>
				
				<div class="panel-body">
					<strong><?= $row["Name"]?></strong> <br />
					<div style="margin-left: 15px;">
						
						<i rel='tooltip' title="Post Time" class="fa fa-clock-o"></i>  <?= date("M d, Y", strtotime($row['UpTime'])) ?> at <?= date("h:i A", strtotime($row['UpTime'])) ?><br />
						<i rel='tooltip' title="Call Time" class="fa fa-sign-in"></i>   <?= date("M d, Y", strtotime($row['CallTime'])) ?> at  <?= date("h:i A", strtotime($row['CallTime'])) ?> <br />
						<i rel='tooltip' title="End of Show" class="fa fa-sign-out"></i> <?=  date("M d, Y", strtotime($row['EndTime'])) ?> at <?=  date("h:i A", strtotime($row['EndTime'])) ?><br />
						<i rel='tooltip' title="User Coordinator" class="fa fa-user"></i> <a href="mailto:<?= $row["UC"] ?>"><?= $row["UC"] ?></a>

					</div>
				</div>
	        </div>

	    	<img class="img-thumbnail hidden-md hidden-sm hidden-xs" src="assets/images/convos.jpg" alt="Convocations.org" />
    	</div>

    </div>
 

<?php
include_once("assets/includes/footer.php");
?>

        
    