
<?php
session_start();
include("/var/www/html/login/connexion.php");
include("/var/www/html/login/functions.php");


$user_data = check_login($con);



if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_account'])) 
{
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];

    
    $user_id = $user_data['user_id'];
    $query = "update users set user_name = '$new_username', password = '$new_password' WHERE user_id = '$user_id'";
    mysqli_query($con, $query);

    
    header("Location: index.php");
    die;
}

if (isset($_POST['delete_account']))
{
    $user_id = $user_data['user_id'];
    $query = "DELETE FROM users WHERE user_id = '$user_id'";
    mysqli_query($con, $query);
    session_destroy();
    header("Location: login/logout.php");
    die;}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modifier mon compte</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<a href="index.php">Retour à l'accueil</a>

<h1>Modifier le compte</h1>
<p>Bienvenue <?php echo $user_data['user_name']; ?> !</p>

<form method="post">
    <label for="new_username">Nouveau nom d'utilisateur:</label>
    <input type="text" id="new_username" name="new_username" value="<?php echo $user_data['user_name']; ?>" required><br><br>

    <label for="new_password">Nouveau mot de passe: </label>
    <input type="password" id="new_password" name="new_password" required><br><br>

    <input type="submit" value="Enregistrer les modifications"><br><br>
</form>




<form method="post">
    <input type="submit"  name="delete_account" value="Supprimer mon compte">
</form>

</body>
</html>
