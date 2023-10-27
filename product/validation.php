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
    <title>Configuration ordinateur</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

<?php $product_data = get_product_data($con, '1'); ?>

<header style="background-color: #56c26a;">
        <div class="logo">
            <a href="/index.php"><img src="/images/logo.png" alt="Logo de Pessay"></a>  <?php #Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png ?>
        </div>

        <h1>Commande Validée !</h1>
    
        <nav>
            <ul style="list-style-type: none;"> <div class = "header_subsection_title">Contact:</div>
                <div class = 'contact'>
                <li>Adresse : Avenue Lepart 404a, Kernel</li>
                <li>Téléphone : 021 404 04 04</li>
                </ul>
                </div>
            <?php
                if ($_SESSION['user_is_connected'] == true)
                {
                    echo '<ul style="list-style-type: none;"> <div class = "header_subsection_title">Mon compte:</div>
                    <li> <a href="/account.php">Modifier mon compte</a> </li>
                    <li> <a href="/login/logout.php">Me déconnecter </a> </li>
                    </ul>';
                }
                else
                {
                    echo '<ul style="list-style-type: none;"> <div class = "header_subsection_title">Mon compte:</div>
                    <li> <a href="/login/login.php">Me connecter </a> </li>
                    <li> <a href="/login/signup.php">M\'inscrire </a> </li>
                    </ul>';
                }
            
                echo '<ul style="list-style-type: none;">';
                echo '<li> <a href="/index.php" style="text-decoration: underline;">Retour à l\'accueil </a> </li>';
                echo '</ul>';


                ?>
        </nav>
</header>

<h1>Félicitations !</h1>
<h2>Votre commande sera réalisée et expédiée dans les plus brefs délais !</h2>
<h2>Vous pouvez à présent retourner à l'acceuil<h2>


<form method="post">
    <input class = "button" type="submit"  name="retour_acceuil" value="Retourner à l'acceuil">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['retour_acceuil'])){
    header("Location: /index.php");
    die;
}
?>

</body>


</html>