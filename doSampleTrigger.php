<?php

require_once("assets/includes/atrigger.php");

//Tags: Tags are required to identify tasks.
//read more at: http://atrigger.com/docs/wiki/9/rest-api-v10-parameter-tag_
$tags = array();
$tags['type']='test';

//Create
ATrigger::doCreate("1minute", "http://cvn.thatisa.link/doAtrigger.php?testParam", $tags, "", 5);


echo "Success?"
?>