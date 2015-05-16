<div id="info" class="float-right">
            <?php 
			if($_SESSION['Login'] != '') { ?>
				<?php if($_SESSION["AccountType"] == "ADMIN") { ?>
						<strong>Welcome <acronym class="tooltip" title="You are logged in as an Administrator." style="color: #FF0000;"><?php echo $_SESSION['Name']; ?></acronym></strong><?php echo " (<acronym class='tooltip' title='Your total points.'>" . $_SESSION['Points']  . "</acronym>)";?> <br />
				<?php } elseif($_SESSION["AccountType"] == "UC") {?>
						<strong>Welcome <acronym class="tooltip" title="You are logged in as an Usher Coordinator." style="color: #0000FF;"><?php echo $_SESSION['Name']; ?></acronym></strong><?php echo " (<acronym class='tooltip' title='Your total points.'>" . $_SESSION['Points'] . "</acronym>)"; ?> <br />
				<?php } else { ?>
					<strong>Welcome <acronym class="tooltip" title="You are logged in as an usher."><?php echo $_SESSION['Name']; ?></acronym></strong><?php echo " (<acronym class='tooltip' title='Your total points.'>" . $_SESSION['Points'] . "</acronym>)"; ?> <br />
				<?php } ?>
				
                	<ul>
                    	<li><a href="my-account.php">My Account</a></li>
                        <li><a href="my-events.php">My Events</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
                <?php 
			} else { ?>
				 <a href="register.php" class="register">Register With CVN Now</a><br />
                 <?php
			}
		?>
            <p>Points will transfer from fall to spring, but they do not transfer over the summer.</p>
<br />
Please report features that you would like to see and site issues to <a href="mailto:cvn2@purdue.edu">cvn2@purdue.edu</a>.

            </div>