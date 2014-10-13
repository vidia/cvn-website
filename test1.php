<?php

update_option('siteurl','http://cvn.thatisa.link');
update_option('home','http://cvn.thatisa.link');


$db = @mysql_connect('localhost', 'cvn_wrdp1', 'P9fc45uYUMjC');
if (!$db) echo "connection failed";
else echo "connection succeeded";

?>
