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
    <title>Pessay</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
        <div class="logo">
            <img src="images/logo.png" alt="Logo de Pessay">  <?php #Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png ?>
        </div>

        <?php
        if ($_SESSION["user_is_connected"] == true){
            echo '<h1>Bienvenue ' . $user_data["user_name"] . ' </h1>';
        }
        else{
            echo '<h1> Bienvenue sur Pessay </h1>';
        }
        ?>
    
        <nav>
            <ul style="list-style-type: none;"> <div class = "header_subsection_title">Contact:</div>
                <div class = 'contact'>
                <li>Adresse : Avenue Lepart 404a, Kernel</li>
                <li>Téléphone : 021 404 04 04</li>
                <li><br>Ceci est un site de démonstration,<br>aucune commande ne sera réellement<br>prise en compte.</li>
                </ul>
                </div>
            <?php
                if ($_SESSION['user_is_connected'] == true)
                {
                    echo '<ul style="list-style-type: none;"> <div class = "header_subsection_title">Mon compte:</div>
                    <div class = "header_account">
                    <li> <a href="/account.php">Modifier mon compte</a> </li>
                    <li> <a href="/login/logout.php">Me déconnecter </a> </li>
                    </ul>
                    </div>';
                }
                else
                {
                    echo '<ul style="list-style-type: none;"> <div class = "header_subsection_title">Mon compte:</div>
                    <div class = "header_account">
                    <li> <a href="/login/login.php">Me connecter </a> </li>
                    <li> <a href="/login/signup.php">M\'inscrire </a> </li>
                    </ul>
                    </div>';
                }

                ?>
        </nav>
</header>


<h1> Bienvenue sur Pessay, la boutique d'ordinateurs conçus pour vous. </h1>
<h3> Cliquez sur un produit et séléctionnez une de ces variantes ! </h3>
<h3> Nous nous chargeons de monter vos machines et de les livrer chez vous.</h3>


<?php

echo '<div class=product-grid>';
echo '<div class="product">';

######Produit 1 ######
$product1_data = get_product_data($con, "1"); #appelle les data du produit 1
if (!empty($product1_data)) #vérifie que les data sont non nulles
{
    $image_data = $product1_data["image"]; 
    $image_b64 = base64_encode($image_data); #Encode l'image en base 64
    echo '<a href = "/product/product1.php"> <img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">
    <h3>'. $product1_data['nom'].' </h3>
    <p>'.$product1_data['description'].' </p> </a>'; # affiche l'image et sa description !
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
    echo '<a href = "/product/product2.php"> <img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">
    <h3>'. $product2_data['nom'].' </h3>
    <p>'.$product2_data['description'].' </p> </a>';
}
else{
    echo "Error: Données produit non disponible";
}
######Produit 2 ######

echo '</div>';
echo '<div class="product">';


###### Test Produit 3 ######
#$product3_data = get_product_data($con, "3");
#if (!empty($product3_data))
#{
#    $image_data = $product3_data["image"]; 
#    $image_b64 = base64_encode($image_data);
#    echo '<a href = "/product/product3.php"> <img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="200" height="200*(16/9)">
#    <h3>'. $product3_data['nom'].' </h3>
#    <p>'.$product3_data['description'].' </p> </a>';
#}
#else{
#    echo "Error: Données produit non disponible";
#}
######Produit 3 ######
echo '</div>';
echo '</div>';


?>

   
</body>


</html>