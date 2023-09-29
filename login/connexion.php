<?php

$dbhost = "hostname";
$dbuser = "username";
$dbpass = "password";
$dbname = "databasename";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("failed to connect !");
}

?>