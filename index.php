<?php
session_start();
include("/var/www/html/login/connexion.php");
include("/var/www/html/login/functions.php");

$user_data = check_login($con);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mon Site Web !</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
    if ($_SESSION["user_is_connected"] == true){
        echo "<a href='login/logout.php'>Me Déconnecter   /</a>";
        echo '<a href="account.php">/ Modifier mon Compte</a>';
    }
    if ($_SESSION["user_is_connected"] == false){
        echo "<a href='login/login.php'>Me Connecter</a>";
    } 
?>


<h1>
    <?php
    if ($_SESSION["user_is_connected"] == true) {
        echo "Bonjour " . $user_data['user_name'] . ".<br> Bienvenue sur Pessay, la boutique d'ordinateurs pensés pour vos vous.";
    } else {
        echo "Bienvenue sur Pessay, la boutique d'ordinateurs pensés pour vous.";
    }
    ?>
</h1>

</body>


</html>