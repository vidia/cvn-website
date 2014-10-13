<?php session_start();
include("assets/includes/db.php");
include("assets/includes/verify.php");
include("assets/includes/verify-admin.php");
?>
IT'S GRABBING THIS PAGE.
<!-- 		   
		   <form action="doChangeSeason.php" method="post">
		   <fieldset>
		   <legend>Current Season</legend>
				<label for="season">Current Season</label>
				<select name="season" id="season">
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
		   </fieldset>
		   <fieldset>
		   <legend>Change Season</legend>
		   <input type="submit" value="Change Current Season" />
		   </fieldset>
		   
		   </form>
 -->
<?php $_SESSION['delete-message'] = '';  $_SESSION['add-message'] = ''; ?>