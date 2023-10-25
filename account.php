
<?php
session_start();
include("/var/www/html/login/connexion.php");
include("/var/www/html/login/functions.php");


$user_data = check_login($con);

if ($user_data['id'] == "")
{
    header("Location: /index.php");
    die;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['delete_account'])) 
{
    $new_username = $_POST["new_username"];
    $new_password = $_POST["new_password"];

    
    $user_id = $user_data['id'];
    db_update($con, "users", "user_name", "id", $new_username, $user_id);
    db_update($con, "users", "password", "id", $new_password, $user_id);
    
    header("Location: index.php");
    die;
}

if (isset($_POST['delete_account']))
{
    db_delete($con , "users", "id" , $user_data['id']);
    session_destroy();
    header("Location: login/logout.php");
    die;
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Modifier mon compte</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class = "account">
<h2>Modifier mon compte</h2>
<p style = "font-size: 1.5em;">Bienvenue <?php echo $user_data['user_name']; ?> !</p>

<form method="post">
    <label for="new_username">Nouveau nom d'utilisateur:</label> <br>
    <input style="width: 100%; font-size: 1em;" type="text" name="new_username" value="<?php echo $user_data['user_name']; ?>" required><br><br>

    <label for="new_password">Nouveau mot de passe: </label><br>
    <input style="width: 100%; font-size: 1em;" type="password" name="new_password" required><br><br>

    <input class = "button" type="submit" value="Enregistrer les modifications"><br><br>
</form>


<form method="post">
    <input class = "button" type="submit"  name="delete_account" value="Supprimer mon compte">
</form>
</div>

<a style = "display: flex; justify-content: center; line-height: 1.5em; text-align: center;" href = "/index.php">Retour à l'acceuil</a>



</body>
</html>
