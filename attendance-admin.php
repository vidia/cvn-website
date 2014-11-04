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
	$PageTitle = "Manage Attendance";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Manage Attendance</li>
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

            <div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Events to Pull Attendance</h3>
				</div>
				<div class="panel-body">
					<div class="panel-group" id="accordion">
                	<?php
                		$i =0;
	                    $query = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 AND Type<>'Meeting' AND EndTime > '".date("Y-m-d H:i:s")."' ORDER BY CallTime ASC";
	                    $result = mysql_query($query);
	                    while($row = mysql_fetch_array($result)){
               		 ?>
						<div class="panel panel-default">
						    <div class="panel-heading">
						    	<h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
						        	<?php echo $row['Name']; ?>
						        </a>
						    	</h4>
						    </div>
						    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
							    <div class="panel-body">

							    	<a class="btn btn-default pull-right" href="export-event-list.php?ID=<?php echo $row['ID']; ?>"><i class="fa fa-download"></i> Download Usher List</a>
                                	<form class="form-inline" action="actions/doPullAttendanceFixed2.php" method="post">
                                		<div class="form-group">
										    <label class="sr-only" for="number-pull">Number of Ushers to Add</label>
										    <input placeholder=" #" type="text" name="number-pull" id="number-pull" style="width: 50px;" class="form-control" maxlength="3" />
										    <input type="hidden" name="eventID" id="eventID" value="<?php echo $row['ID']; ?>"  />
									    </div>
									  <button type="submit" class="btn btn-success">Request Ushers</button>
									</form>

									<br class="clearfix" />


  							        <!-- START TABLE -->
							        <table class="table table-striped table-bordered table-hover">
							        <tr>
							        	<th>Usher</th>
							        	<th>Email</th>
							        	<th>Points</th>
							        </tr>
							        <tr>
							        	<td colspan="4">Usher Requests</td>
							       </tr>
							       <!-- START USHER REQUESTS -->
							       		<?php
										$cutArray = array();
										$query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Requested'";
										$result2 = mysql_query($query2);
										$num_rows = mysql_num_rows($result2);
										if ($num_rows != 0) {
											while($row2 = mysql_fetch_array($result2)) {
												array_push($cutArray, array('ID'=>$row2['ID'], 'LastName'=>$row2['LastName'],
												'FirstName'=>$row2['FirstName'], 'Email'=>$row2['Email'],
												'PointTotal'=>getPoints($row2['ID'])));
											}
											$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
											for($counter = 0;$counter<$num_rows;$counter++)
											{
												$row2 = $cutArray[$counter];
												echo "<tr><td><strong>".($counter+1).".</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . $row2["PointTotal"] . "</td></tr>";
											}
										}
										?>
									<tr class="success">
										<td colspan="4">Confirmed Ushers</td>
									</tr>
									<!-- START CONFIRMED USHERS-->
										 <?php
										$cutArray = array();
										$query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Ushering'";
										$result2 = mysql_query($query2);
										$num_rows = mysql_num_rows($result2);
										if ($num_rows != 0) {
											echo "test<br />";
											while($row2 = mysql_fetch_array($result2)) {
												array_push($cutArray, array('ID'=>$row2['ID'], 'LastName'=>$row2['LastName'],
												'FirstName'=>$row2['FirstName'], 'Email'=>$row2['Email'],
												'PointTotal'=>getPoints($row2['ID'])));
											}
											$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
											for($counter = 0;$counter<$num_rows;$counter++)
											{
												$row2 = $cutArray[$counter];
												echo "<tr><td><strong>".($counter+1).".</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . $row2["PointTotal"] . "</td></tr>";
											}
										}

										?>
									<!-- START CUT USHERS-->
									<tr class="danger">
										<td colspan="4">Cut Ushers</td>
									</tr>
										<?php
										$cutArray = array();
										$query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
										$result2 = mysql_query($query2);
										$num_rows = mysql_num_rows($result2);
										if ($num_rows != 0) {
											while($row2 = mysql_fetch_array($result2)) {
												array_push($cutArray, array('ID'=>$row2['ID'], 'LastName'=>$row2['LastName'],
												'FirstName'=>$row2['FirstName'], 'Email'=>$row2['Email'],
												'PointTotal'=>getPoints($row2['ID'])));
											}
											$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
											for($counter = 0;$counter<$num_rows;$counter++)
											{
												$row2 = $cutArray[$counter];
												echo "<tr><td><strong>".($counter+1).".</strong> ".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . $row2["PointTotal"] . "</td></tr>";
											}
										}
										?>
							        </table>
							        <!-- END TABLE -->
							    </div>
						    </div>
						</div>
                    <?php
                    $i++;
                    }
               		?>
	                </div>
	            </div>
           </div><!-- /.panel -->
            <div class="panel panel-primary">
			    <div class="panel-heading">
			    	<h3 class="panel-title">Events to Confirm Attendance</h3>
			    </div>
			    <div class="panel-body">
                	<?php
                    $query = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 AND Type<>'Meeting' AND EndTime < '".date("Y-m-d H:i:s")."' ORDER BY CallTime ASC";
                    $i =0;
                    $result = mysql_query($query);
                    while($row = mysql_fetch_array($result)){
                    ?>
			    	<div class="panel panel-default">
						    <div class="panel-heading">
						    	<h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseB<?= $i ?>">
						        	<?php echo $row['Name']; ?>
						        </a>
						    	</h4>
						    </div>
						    <div id="collapseB<?= $i ?>" class="panel-collapse collapse <?//if($i==0) { echo "in"; }?>">
							    <div class="panel-body">
						    		<a class="btn btn-default pull-right" href="export-event-attendance.php?ID=<?php echo $row['ID']; ?>"><i class="fa fa-download"></i> Download Event Attendance</a>
                                	<a style="display:none;" class="btn btn-success pull-right" style="margin-right: 10px;" rel="<?php echo $row['ID']; ?>"><i class="fa fa-plus"></i> Add extra</a>
                                	<br class="clearfix" /><br class="clearfix" />


  							        <!-- START TABLE -->
							        <table class="table table-striped table-bordered table-hover">
							        <tr>
							        	<th>&nbsp;</th>
							        	<th>Usher</th>
							        	<th>Email</th>
							        	<th>Points</th>
							        </tr>
							        <tr>
							        	<td colspan="4">Confirmed Ushers</td>
							       </tr>
                                    <form class='form-horizontal' action="actions/doEventAttendance.php" method="post">
                                        <?php
                                        $query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND (A.RequestStatus='Ushering' OR A.RequestStatus='Present' OR A.RequestStatus='No-Show')  ORDER BY U.LastName ASC";
                    					//echo $query;
                    					$result2 = mysql_query($query2);

                    					while($row2 = mysql_fetch_array($result2)){
											if ($row2['RequestStatus'] == 'Present') {
												echo "<tr><td width='3%' style='text-align: center;'><input class='checkbox' type='checkbox' checked='checked' name='present[]' value='".$row2['ID']."' /></td> ";
											} else {
												echo "<tr><td width='3%' style='text-align: center;'><input class='checkbox' type='checkbox' name='present[]' value='".$row2['ID']."' /></td>";
											}
											// They want to see their points in 10s not 1s.
											if(empty($row2["LastName"]) || empty($row2["FirstName"])) {
												echo "<td><em>Unnamed</em></td><td>" . $row2["Email"] . "</td><td>" . getPoints($row2["ID"]) . "</td></tr>";
											}
											else {
												echo "<td>" . $row2['LastName'].", " . $row2['FirstName'] ."</td><td>" . $row2["Email"] . "</td><td>" . getPoints($row2["ID"]) . "</td></tr>";
											}
										}
										?>

										<tr>
											<td colspan="5">Cut Ushers</td>
										</tr>

										<?php
										$cutArray = array();
										$query2 = "SELECT * FROM Attendance A, User U WHERE A.EventID='".$row['ID']."' AND U.ID=A.UserID AND A.RequestStatus='Cut'";
										$result2 = mysql_query($query2);
										$num_rows = mysql_num_rows($result2);
										if ($num_rows != 0) {
											while($row2 = mysql_fetch_array($result2)) {
												array_push($cutArray, array('ID'=>$row2['ID'], 'LastName'=>$row2['LastName'],
												'FirstName'=>$row2['FirstName'], 'Email'=>$row2['Email'],
												'PointTotal'=>calculatePointTotal($row2['ID'])));
											}
											$cutArray = array_orderby($cutArray, 'PointTotal', SORT_DESC);
											for($counter = 0;$counter<$num_rows;$counter++)
											{
												$row2 = $cutArray[$counter];
												echo "<tr><td>&nbsp;</td><td>".$row2['LastName'].", ".$row2['FirstName']."</td><td>" . $row2["Email"] . "</td><td>" . $row2["PointTotal"] . "</td></tr>";
											}
										}
										?>

										</table>
										<input type="hidden" value="<?php echo $row['ID']; ?>" name="EventID" /><br />
                                    	<input class="btn btn-lg btn-success btn-block" type="submit" name="submit-event-attendance" value="Submit Attendance" />
										<div id="extra-ushers-<?php echo $row['ID']; ?>"></div>
										</form>
										</div>
                                     </div>
							    </div>
                            <?php
                    $i++;
                    }
               ?>
                </div>
			</div> <!-- /.panel -->

<?php
include_once("assets/includes/footer.php");
?>
