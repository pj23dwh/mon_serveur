<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "citeam23";
$dbname = "siteweb";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("failed to connect !");
}

?>