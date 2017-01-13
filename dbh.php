<?php

$conn = mysqli_connect("localhost", "root", "", "boardy");

if(!$conn){
	die("Connectin failed: ".mysqli_connect_error());
	
}

