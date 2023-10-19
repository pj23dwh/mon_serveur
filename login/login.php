<?php
session_start();
    include("/var/www/html/login/connexion.php");
    include("/var/www/html/login/functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') # si la méthode "post" est utilisée (ce qui signifie que les champ de connexion ont été remplis et envoyés) :
    {
        
        $user_name = $_POST["username"]; # mise sous variable des données entrées par l'utilisateur
        $password = $_POST["password"];


        if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) # vérification de la validité des données entrées par l'utilisateur
        {
            
            $user_data = get_user_data($con, $user_name);

            if ($user_data['password'] === $password) 
            {
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: ../index.php");
                die;
            }
        }


        echo '<p style="position: absolute; top: 70%;left: 50%; transform: translate(-50%, -50%); color: red; font-size: 13px;"> Mauvais nom d\'utilisateur ou mot de passe !</p>';

    }
?>


<html>
<head>
    <meta charset="utf-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="font-size: 20px;">
    <div class="login">
        <form method="post" style="text-align: center;">
            <div style="font-size: 24px; margin: 10px;">Connexion</div>
            <input type="text" name="username" placeholder="Nom d'utilisateur"><br><br>
            <input type="password" name="password" placeholder="Mot de passe"><br><br>

            <input class="button" type="submit" value="Connexion"><br><br>

            <a href="signup.php" style="font-size: 18px;">Créer un compte</a><br><br>
        </form>
    </div>
</body>


</html>