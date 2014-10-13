<?php
ob_start();
include_once("assets/includes/verify.php");
include_once("assets/includes/verify-admin.php");
include_once("assets/includes/header.php");


$_SESSION["terms"] = htmlspecialchars(mysql_real_escape_string($_POST["terms"]));

$individualTerms = explode(" ", $_SESSION["terms"]);
$individualTerms = array_map("trim", $individualTerms);
$numTerms = count($individualTerms);



$sqlExact = "SELECT ID FROM User WHERE FirstName='" . $individualTerms[0] . "' AND LastName='" . $individualTerms[1] . "'";
$resultsExact = mysql_query($sqlExact);
$exactMatch = mysql_fetch_array($resultsExact);
$exactMatchNum = mysql_num_rows($resultsExact);

if($exactMatchNum == 1) {
	// send them to profile page because they hit an exact match
	//http_redirect("edit-user.php?ID=" . $exactMatch["ID"]);
	header("Location: edit-user.php?ID=" . $exactMatch["ID"]);
}
else {
?>

<style>
.twitter-typeahead .tt-hint {
    display: block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    border: 1px solid transparent;
    border-radius:4px;
}
.twitter-typeahead .hint-small {
    height: 30px;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 3px;
    line-height: 1.5;
}
.twitter-typeahead .hint-large {
    height: 45px;
    padding: 10px 16px;
    font-size: 18px;
    border-radius: 6px;
    line-height: 1.33;
}

.twitter-typeahead .tt-dropdown-menu {
	background-color: #fff;
	cursor: pointer;
	border: 1px solid #dedede;
	padding: 5px;
	width: 100%;
}

.twitter-typeahead .tt-dropdown-menu li:hover {
	background-color: #fff;
	cursor: pointer;
	border: 1px solid #dedede;
	padding: 5px;
	width: 100%;
	color: red;
}

.twitter-typeahead .tt-dropdown-suggestions {
	background-color: #ffff00;
	color: red;

}

</style>



<div class="container">
      <div class="row">
        <div class="col-lg-12">
          <?php 
          // a random hello
          $helloArray = array("Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey,", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
          $randHello = array_rand($helloArray);
          ?>
          <h1 class="page-header">Search Results <small><?= $helloArray[$randHello] . " " . $_SESSION["Name"] . " <a href='my-account.php#breakdown' rel='tooltip' title='Total points' class='label label-info'>" . $_SESSION["Points"] . "</a>"; ?></small></h1>
          <ol class="breadcrumb">
          	<li><a href="dashboard.php">Dashboard</a></li>
          	<li><a href="user-admin.php">Manage Users</a></li>
            <li class="active">Search Results</li>
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

		$searchResultsName = array();
		$searchResultsID = array();
		$i = 0;
		while($i <= $numTerms-1){
			$sqlLike = "SELECT * FROM User WHERE FirstName LIKE '%" . $individualTerms[$i] . "%' OR LastName LIKE '%" . $individualTerms[$i] . "%'";
			$resultLike = mysql_query($sqlLike) or die(mysql_error());
			while($users = mysql_fetch_array($resultLike)) {
				if(!in_array($users["ID"], $searchResultsID)) {
					$searchResultsID[] = $users["ID"];
					$searchResultsName[] = $users["FirstName"] . " " . $users["LastName"];
				}
				//echo "<br />" . $users["FirstName"] . " " . $users["LastName"];
			}
			$i++;
		}
		?>

		<div class="pull-right" style="width: 210px; margin-right: 10px;">
        	<form action="doSearchUser.php" method="post" role="form" >
			  <div class="form-group">
			    <label class="sr-only" for="search">Search Users</label>
			    <div class="input-group">
			    	<input type="text" rel="typeahead" class="form-control" id="search" name="terms" placeholder="Search Users">
			    	<span class="input-group-btn">
			    		<button type="submit" class="btn btn-default" type="button"><i class="fa fa-search"></i> <span class="sr-only">Search</span></button>
			    	</span>
			    </div><!-- /input-group -->
			  </div>
			</form>
        </div> 


		 <table class="table table-bordered table-hover table-striped">
           		<thead><tr><th style="width:3%;"></th><th>Name</th><th>Email</th><th colspan="2" style='text-align: center;'>Admin</th></tr></thead>
		<?php
		
		$j=0;
		while($j < count($searchResultsName)) {
			$counter = 0;
			$SQL = "SELECT * FROM User WHERE ID=" . $searchResultsID[$j] . " ORDER BY LastName ASC";
			$result = mysql_query($SQL);
			$row = mysql_fetch_array($result);
				if(!empty($row["LastName"]) AND !empty($row["FirstName"])) {
					$counter++;
					($row['AcctType'] == "ADMIN") ? $star = "<i rel='tooltip' title='Administrator' class='fa fa-star'></i>" : $star ="";
					($row['AcctType'] == "UC") ? $starUC = "<i rel='tooltip' title='Usher Coordinator' class='fa fa-star-o'></i>" : $starUC ="";

					if($_SESSION['AccountType'] == 'ADMIN') {
						echo "<tr><td>" . $star . $starUC . "</td><td><a href='edit-user.php?ID=".$row['ID']."'> ".$row['LastName'].", ".$row['FirstName']."</a></td><td><a href='mailto:".$row['Email']."'>".$row['Email']."</a></td><td style='text-align:center;'><a rel='tooltip' href='edit-user.php?ID=".$row['ID']."' title='Edit " . $row['FirstName'] . " " . $row['LastName']. "'  class='btn btn-default'><i class='fa fa-edit'></i></a></td><td style='text-align:center;'><a onclick='return Verify_Delete(".$row['ID'].")' style='cursor: pointer;' rel='tooltip' title='Delete " . $row['FirstName'] . " " . $row['LastName']. "' class='btn btn-danger'><i class='fa fa-trash-o'></i></a></td></tr>";
					} else {
						echo "<tr><td>" . $star . $starUC . "</td><td><a href='edit-user.php?ID=".$row['ID']."'> ".$row['LastName'].", ".$row['FirstName']."</a></td><td><a href='mailto:".$row['Email']."'>".$row['Email']."</a></td><td style='text-align:center;'><a rel='tooltip' href='edit-user.php?ID=".$row['ID']."' title='Edit " . $row['FirstName'] . " " . $row['LastName']. "'  class='btn btn-default'><i class='fa fa-edit'></i></a></td></tr>";
					}
				}

			$j++;
		}

	}
 ?>
 		</table>
		</div>
	</div>
</div>



<?php
include_once("assets/includes/footer.php");
?>

<script src="js/typeahead.jquery.min.js"></script> 

<script>
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });

    cb(matches);
  };
};

var users = [
<?php
$SQL = "SELECT * FROM User ORDER BY LastName ASC";
$result = mysql_query($SQL);
while($row = mysql_fetch_array($result)) {
	if(!empty($row["LastName"]) AND !empty($row["FirstName"])) { 
		echo "'" . $row["FirstName"] . " " . $row["LastName"] . "',";
	}
}
?>
];

$('[rel=typeahead]').typeahead({
  hint: true,
  highlight: true,
  minLength: 3
},
{
  name: 'users',
  displayKey: 'value',
  source: substringMatcher(users),
});
</script>

<style>
.twitter-typeahead .tt-hint
{
    display: block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    border: 1px solid transparent;
    border-radius:4px;
}

.twitter-typeahead .hint-small
{
    height: 30px;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 3px;
    line-height: 1.5;
}

.twitter-typeahead .hint-large
{
    height: 45px;
    padding: 10px 16px;
    font-size: 18px;
    border-radius: 6px;
    line-height: 1.33;
}
</style>
<?php
ob_end_flush();
?>
