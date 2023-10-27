<?php
# données de connexion au serveur:
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "your_password";
$dbname = "siteweb";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
    die("failed to connect !");
}

?>
