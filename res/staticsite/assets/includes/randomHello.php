<?php
// a random hello
$helloArray = array("Halo", "Moien",  "ni hao", "Hola", "Gude", "Guten Tag", "Hello", "Bonjour", "Salut", "Servas", "Aloha", "Ciao", "Howdy", "Hey", "A Gutn Tog", "Shalom", "Namaste", "<span rel='tooltip' style='cursor:pointer;' title='Good luck, have fun'>glhf,</span>");
$randHello = array_rand($helloArray);

?>

<h1 class="page-header"><?= isset($PageTitle) ? $PageTitle : "Welcome"?> <small><?= $helloArray[$randHello] . " " . $_SESSION["Name"] . " <a href='my-account.php#breakdown' rel='tooltip' title='Total points' class='label label-info'>" . $_SESSION["Points"] . "</a>"; ?></small></h1>
