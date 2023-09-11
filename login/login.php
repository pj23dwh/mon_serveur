<?php
session_start();
    include("/var/www/html/login/connexion.php");
    include("/var/www/html/login/functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
        //something was posted
        $user_name = $_POST["username"];
        $password = $_POST["password"];


        if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) 
        {
            //read from database
            $query = "select * from users where user_name = '$user_name' limit 1";
            $result = mysqli_query($con, $query);

            if($result)
            {
                if ($result && mysqli_num_rows($result) > 0) 
                {
                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['password'] === $password) 
                    {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        header("Location: ../index.php");
                        die;
                    }
                }               
            
            } 
        }
        echo '<p style="position: absolute;
            top: 70%;left: 50%; 
            transform: translate(-50%, -50%); color: red; font-size: 13px;">
            Mauvais nom d\'utilisateur ou mot de passe !</p>';
    }
?>


<html>
<head>
    <meta charset="utf-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body style="font-size: 20px;">
    <div id="login">
        <form method="post" style="text-align: center;">
            <div style="font-size: 24px; margin: 10px;">Connexion</div>
            <input id="text" type="text" name="username" placeholder="Nom d'utilisateur"><br><br>
            <input id="text" type="password" name="password" placeholder="Mot de passe"><br><br>

            <input id="button" type="submit" value="Connexion" style="margin: auto;"><br><br>

            <a href="signup.php" style="font-size: 18px;">Créer un compte</a><br><br>
        </form>
    </div>
</body>


</html>