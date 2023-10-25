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

<?php $product_data = get_product_data($con, '3'); ?>

<header>
        <div class="logo">
            <a href="/index.php"><img src="/images/logo.png" alt="Logo de Pessay"></a>  <?php #Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png ?>
        </div>

        <?php
            if (!isset($_POST['choix-multiple'])){
                echo '<h1> Configurez votre PC ' . $product_data["categorie"] . ' </h1>';
            }
            else{
                $choix = $_POST['choix-multiple'];
                $result = db_read($con, "Variantes", "id", $choix);
                $variante_data = mysqli_fetch_assoc($result);
                echo '<h1> Config '. $variante_data['categorie'] .' - ' . $variante_data['nom'] .'</h1>';
                
            }
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

if (!empty($product_data)){
    $image_data = $product_data["image"]; 
    $image_b64 = base64_encode($image_data);
    echo '<div class = product2><img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="400" height="400*(16/9)">
    <h3>'. $product_data['nom'].' </h3>
    <p>'.$product_data['description'].' </p> </div>';
}
else{
    echo "Error: Données produit non disponible";
}
?>

<div class = 'product_description'>

<form method="post" >
<label for="choix-multiple">Sélectionnez la version de votre ordinateur :</label>
<?php
if ($_POST['choix-multiple'] == 2){
    echo '<select class="choix-multiple" name="choix-multiple">';
    echo '  <option value="1">Ultra</option>';
    echo '  <option value="2" selected>Performance</option>';
    echo '</select>';
}
else{
    echo '<select class="choix-multiple" name="choix-multiple">';
    echo '  <option value="1" selected>Ultra</option>';
    echo '  <option value="2">Performance</option>';
    echo '</select>';
}
?>
<input class = "choix-multiple" type="submit" value="Confirmer">
</form>




<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #valeur choix-multiple
    $choix = $_POST['choix-multiple'];
    $result = db_read($con, "Variantes", "id", $choix);
    $variante_data = mysqli_fetch_assoc($result);
    $_SESSION['config'] = $variante_data['id'];

    echo '<div class = "product_description_categorie">';

    echo '<p>Prix:</p>';
    echo '<div class = "grid_item"><p>'. $variante_data["Prix"] . '</p></div>';

    echo '<p>Processeur:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["CPU"] . '</p></div>';

    echo '<p>Carte graphique:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["GPU"] . '</p></div>';

    echo '<p>Mémoire vive:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["RAM"] . '</p></div>';

    echo '<p>Disque dur:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["HDD"] . '</p></div>';

    echo '<p>Stockage SSD:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["SDD"] . '</p></div>';

    echo '<p>CPU Cooler:</p>';
    echo '<div class = "grid_item"><p>' . $variante_data["CPU Cooler"] . '</p></div>';

    echo '</div>';

    echo '<h1 class= "price">'. $variante_data['Prix'] .'.- CHF</h1>';
    
    echo '<form method="post" action="/product/commande.php">';
    echo '  <input class="paybutton" type="submit" name="acheter" value="Acheter">';
    echo '</form>';


}



?>

</div>

</body>


</html>