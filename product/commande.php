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

<header>
        <div class="logo">
            <a href="/index.php"><img src="/images/logo.png" alt="Logo de Pessay"></a>  <?php #Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png ?>
        </div>

        <h1>Validez Votre Commande:</h1>

        <?php
        $result = db_read($con, "Variantes", "id", $_SESSION["config"]);
        $variante_data = mysqli_fetch_assoc($result);
        ?>
    
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


<?php

if ($_SESSION['config'] < 3){
    $product_data = get_product_data($con, '1');
}

else{
    $product_data = get_product_data($con, '2');
}

?> <?php
if (!empty($product_data)){
    $image_data = $product_data["image"]; 
    $image_b64 = base64_encode($image_data);
    echo '<div class = product2><img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="400" height="400*(16/9)">
    <h3>Ordinateur Séléctionné: <br>'. $product_data['nom'].' - '. $variante_data['nom'] .' </h3>
    <p>'.$product_data['description'].' </p> </div>
    <h1 class= "price" style="left:1em;">'. $variante_data['Prix'] .'.- CHF</h1>';
}
else{
    echo "Error: Données produit non disponible";
}

?>

<?php

if ($_SESSION["user_is_connected"] == false){
    echo '<h2 style="color:red;">Afin de finaliser votre commande, merci de vous connecter.</h2>';
}

else{
    echo '<div class = "fill_commande">';
    echo '<form method="post">';


    echo '  <label for="nom">Nom*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="nom" required><br><br>';

    echo '  <label for="prenom">Prénom*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="prenom" required><br><br>';

    echo '  <label for="country">Pays de livraison*:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="country" required><br><br>';

    echo '  <label for="adresse_facturation">Adresse de facturation*:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="adresse_facturation" required><br><br>';

    echo '  <label for="code_postal">Code postal*:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="code_postal" required><br><br>';

    echo '  <label for="adresse_livraison">Adresse de livraison*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="adresse_livraison" required><br><br>';

    echo '  <label for="telephone_number">Téléphone*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="telephone_number" required><br><br>';

    echo '  <label for="email">Adresse Email: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="email"><br><br>';

    echo '  <label for="card_number">Numéro de Carte*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="card_number" required><br><br>';

    echo '  <label for="expiration_date">Date d\'expiration*: </label><br>';
    echo '  <input style="width: 30%; font-size: 1em;" type="text" name="expiration_date" value="xx/xx" required><br><br>';

    echo '  <label for="cryptogramme">Cryptogramme*: </label><br>';
    echo '  <input style="width: 30%; font-size: 1em;" type="text" name="cryptogramme" required><br><br>';


    echo '  <input class = "button" type="submit" value="Valider"><br><br>';
    echo '<p style="padding:2px;">*Champs Requis</p>';
    echo '</form>';
    echo '</div>';
}

?>

</body>


</html>