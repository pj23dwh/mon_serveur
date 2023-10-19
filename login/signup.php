<?php
session_start();
    include("/var/www/html/login/connexion.php");
    include("/var/www/html/login/functions.php");

    

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Page d'inscription</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="font-size: 20px;">
    <div class="login">
        <form method="post" style="text-align: center;">
            <div style="font-size: 24px; margin: 10px;">Inscription</div>
            <input type="text" name="username" placeholder="Nom d'utilisateur"><br><br>
            <input type="password" name="password" placeholder="Mot de passe"><br><br>

            <input class="button" type="submit" value="Inscription" style="margin: auto;"><br><br>

            <a href="login.php" style="font-size: 18px;">Se connecter</a><br><br>
            <?php

            if($_SERVER['REQUEST_METHOD'] == 'POST') #pour information sur fonctionnement, cf ../login/login.php
            {

                $user_name = $_POST["username"];
                $password = $_POST["password"];
        
                if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) 
                {
                    $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1"; 
                    $result = mysqli_query($con, $query);
            
                    if ($result && mysqli_num_rows($result) > 0) # verification de le username n'est pas déjà pris 
                    { 
                        echo '<p style="color: red; font-size: 17px;">Ce nom d\'utilisateur est déjà pris !</p>';
                    } else {
                        
                        #$user_id = random_num(20);
                        $query = "INSERT INTO users (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$password')";
                        mysqli_query($con, $query); # Sauvegarde des résultats dans la base de donnée
             
                        header("Location: login.php");
                        die;
                }
                }else
                {
                    echo '<p style ="color: red; font-size: 17px ;
                    ">Merci de remplir tous les champs et de fournir un nom d\'utilisateur comportant au moins une lettre.</p>';
                }
            }

            ?>


        </form>
    </div>
</body>


</html>