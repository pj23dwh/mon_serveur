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

<header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo de Pessay">  < ! -- Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png -- >
        </div>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Produits</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>



<?php
    if ($_SESSION["user_is_connected"] == true){
        echo "<a href='login/logout.php'>Me Déconnecter   /</a>";
        echo '<a href="account.php">/ Modifier mon Compte</a>';
    }
    if ($_SESSION["user_is_connected"] == false){
        echo "<a href='login/login.php'>Me Connecter   /</a>";
        echo '<a href="login/signup.php">/ Créer un compte</a>';
    } 
?>


<h1>
    <?php
    if ($_SESSION["user_is_connected"] == true) {
        echo "Bonjour " . $user_data["user_name"] . ".<br> Bienvenue sur Pessay, la boutique d'ordinateurs pensés pour vos vous.";
    } else {
        echo "Bienvenue sur Pessay, la boutique d'ordinateurs pensés pour vous.";
    }
    ?>
</h1>


<?php

echo '<div class=product-grid>';
echo '<div class="product">';

######Produit 1 ######
$product1_data = get_product_data($con, "1"); #appelle les data du produit 1
if (!empty($product1_data)) #vérifie que les data sont non nulles
{
    $image_data = $product1_data["image"]; 
    $image_b64 = base64_encode($image_data); #Encode l'image en base 64
    echo '<img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">'; #Affiche l'image !
    echo '<h3>'. $product1_data['nom'].' </h3>';
    echo '<p>'.$product1_data['description'].' </p>';
}
else{
    echo "Error: Data produit non disponible"; #Message d'erreur en cas d'image nulle.
}
######Produit 1 ######

echo '</div>';


echo '<div class="product">';

######Produit 2 ######
$product2_data = get_product_data($con, "2");
if (!empty($product2_data))
{
    $image_data = $product2_data["image"]; 
    $image_b64 = base64_encode($image_data);
    echo '<img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">';
    echo '<h3>'. $product2_data['nom'].' </h3>';
    echo '<p>'.$product2_data['description'].' </p>';
}
else{
    echo "Error: Données produit non disponible";
}
######Produit 2 ######

echo '</div>';
echo '<div class="product">';


###### Test Produit 3 ######
#$product2_data = get_product_data($con, "2");
if (!empty($product2_data))
{
    $image_data = $product2_data["image"]; 
    $image_b64 = base64_encode($image_data);
    echo '<img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">';
    echo '<h3>'. $product2_data['nom'].' </h3>';
    echo '<p>'.$product2_data['description'].' </p>';
}
else{
    echo "Error: Données produit non disponible";
}
######Produit 3 ######
echo '</div>';
echo '</div>';


?>

   
</body>


</html>