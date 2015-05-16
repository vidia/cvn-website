<?php
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");
include("assets/includes/constants.php");
?>

<script type="text/javascript">
function Verify_Delete()
{
	var r=confirm("Are you sure you would like to delete the event. It will also delete any attendances related to this event?");

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


<div class="container">

      <div class="row">
        <div class="col-lg-12">
<?php
	$PageTitle = "Event Administrator";
	include("assets/includes/randomHello.php"); ?>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
            <li class="active">Event Administrator</li>
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


        	<div class="clearfix" style="margin-bottom: 5px;">
        		<a style="margin: 5px;" class="btn btn-success pull-right" href="add-event.php"><i class="fa fa-plus"></i> Add Event</a>

				<button style="margin: 5px;" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal">
				  <i class="fa fa-refresh"></i> Change Season</a>
				</button>

<!--         		<a style="margin: 5px;" data-toggle="modal" data-target="#changeSeason" class="btn btn-default pull-right"><i class="fa fa-refresh"></i> Change Season</a>
 -->

 				</div>

			<table class="table table-hover table-striped table-bordered">
			<thead>
           	<tr>
           		<td style="width:30%;">Name</td>
           		<td style="width:3%;">Date</td>
           		<td style="width:25%;">UC</td>
           		<td style="width:5%;" colspan="2">Admin</td>
           	</tr>
           </thead>


			<?php


			//ONLY CURRENT SEASON (SEASON.CURRENT = 1)
			$SQL = "SELECT * FROM Event JOIN Season ON Event.SeasonID=Season.SeasonID WHERE Season.Current=1 ORDER BY Event.CallTime ASC";
			$result = mysql_query($SQL);
			if(mysql_num_rows($result) > 0) {
				while($row = mysql_fetch_array($result)) {
						echo "<tr><td style='vertical-align: middle;'>".$row['Name']."</td>";
						echo "<td style='vertical-align: middle;'>".date("m/d/y", strtotime($row['CallTime']))."</td>";
						echo "<td style='vertical-align: middle;'><a href='mailto:".$row['UC']."'>".$row['UC']."</a></td>";
						echo "<td style='text-align: center;vertical-align: middle;'><a rel='tooltip' class='btn btn-default' href='edit-event.php?ID=".$row['ID']."' title='Edit " . $row['Name'] ."' ><i class='fa fa-edit'></i></a></td>";
						echo "<td style='text-align: center;vertical-align: middle;'><a class='btn btn-default' onclick='return Verify_Delete()' href='doDeleteEvent.php?ID=".$row['ID']."' rel='tooltip' title='Delete " . $row['Name'] ."'><i class='fa fa-times'></i></a></td>";
						echo "</td></tr>";
				}
			}
			else {
				echo "<tr><td colspan='5'><div class='alert alert-info'>There are no events scheduled for this season. <a class='alert-link' href='add-event.php'>Create one</a>.</div></td></tr>";
			}

			// all shows
			$SQL2 = "SELECT * FROM Event WHERE Archive<>1 ORDER BY CallTime ASC";
			echo "<tr><td colspan='5'  style='background-color: #5bc0de; color: #fff'><h4 style='border-left: 5px solid #fff; padding-left: 10px;'>All Seasons</h4></td></tr>";
			$result2 = mysql_query($SQL2);
			if(mysql_num_rows($result2) > 0) {
				while($row2 = mysql_fetch_array($result2)) {
					echo "<tr><td style='vertical-align: middle;'>".$row2['Name']."</td>";
					echo "<td style='vertical-align: middle;'>".date("m/d/Y", strtotime($row2['CallTime']))."</td>";
					echo "<td style='vertical-align: middle;'><a href='mailto".$row2['UC']."'>".$row2['UC']."</a></td>";
					echo "<td style='text-align: center; vertical-align: middle;'><a rel='tooltip' class='btn btn-default' href='edit-event.php?ID=".$row2['ID']."' title='Edit " . $row2['Name'] ."' ><i class='fa fa-edit'></i></a></td>";
					echo "<td style='text-align: center; vertical-align: middle;'><a class='btn btn-default' onclick='return Verify_Delete()' href='doDeleteEvent.php?ID=".$row2['ID']."' rel='tooltip' title='Delete " . $row2['Name'] ."'><i class='fa fa-times'></i></a></td>";
					echo "</td></tr>";
				}
			}
			else {
				echo "<tr><td colspan='5'><div class='alert alert-info'>There are no events. <a class='alert-link' href='add-event.php'>Create one</a>.</div></td></tr>";
			}
			?>
            </table>




			<!-- Modal -->

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Change Season</h4>
			      </div>
			      <div class="modal-body">
			          <form class="form-horizontal" action="doChangeSeason.php" method="post">
						 	<div class="form-group">
								<label for="season" class="col-sm-2 control-label">Current Season</label>
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
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-success">Change Season</button>
			       </form>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->









<?php
include_once("assets/includes/footer.php");
?>
