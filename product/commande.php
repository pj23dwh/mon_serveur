<?php
session_start();
include("/var/www/html/login/connexion.php");
include("/var/www/html/login/functions.php");

$user_data = check_login($con);

$result = db_read($con, "Variantes", "id", $_SESSION["config"]);
$variante_data = mysqli_fetch_assoc($result);
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commande'])) 
{
    if(!is_numeric($_POST['cryptogramme'])  || !is_numeric($_POST['card_number'])){
        echo '<p style="color:red;">Veuillez insérer des valeurs valides.</p>';
        echo '<a href="/index.php">Retour à l\'acceuil</a>';
        echo "" . $_POST['cryptogramme'] . "" . $_POST['card_number'] . "";
        die;
    }

    $id_utilisateur = $user_data['id'];
    $montant_total = $variante_data['Prix'];
    $nom_config = $variante_data['nom'];

    $nom_client = $_POST["nom"];
    $prenom_client = $_POST["prenom"];
    $country = $_POST["country"];

    $adresse_facturation = $_POST["adresse_facturation"];
    $code_postal = $_POST["code_postal"];
    $adresse_livraison = $_POST["adresse_livraison"];

    $telephone_number = $_POST["telephone_number"];
    $email = $_POST["email"];
    $card_number = $_POST["card_number"];

    $expiration_date = $_POST["expiration_date"];
    $cryptogramme = $_POST["cryptogramme"];


    #utilisation de requêtes SQL séparées

    $query = "INSERT INTO `Commandes`(`id_utilisateur`, `montant_total`, `nom_config`, `nom_client`, `prenom_client`, `country`, `adresse_facturation`, `code_postal`, `adresse_livraison`, `telephone_number`, `email`, `card_number`, `expiration_date`, `cryptogramme`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    #préparation de la requête
    $stmt = mysqli_prepare($con, $query);

    if ($stmt){
        #liaison des valeurs aux espaces réservés
        mysqli_stmt_bind_param($stmt, "iissssssssssss", $id_utilisateur, $montant_total, $nom_config, $nom_client, $prenom_client, $country, $adresse_facturation, $code_postal, $adresse_livraison, $telephone_number, $email, $card_number, $expiration_date, $cryptogramme);

        #exécution de la requête préparée
        if (mysqli_stmt_execute($stmt)){ #cette ligne vérifie que l'éxecution de la requête renvoie true
            header("Location: /product/validation.php");
            #die;
            echo "wtf";
        }
        else {
            echo "<h1 style='color:red; max-width: 200em; font-size: 3em; position: absolute; left: 35%; text-align:center; padding: 3em; padding-left: 5em;'>Erreur lors de la commande : " . mysqli_stmt_error($stmt) . "</h1>";
        }

        #fermeture de la requête préparée
        mysqli_stmt_close($stmt);
    }
    else {
    echo "<h1 style='color:red; max-width: 200em; font-size: 3em; position: absolute; left: 35%; text-align:center; padding: 3em; padding-left: 5em;'>Erreur lors de la préparation de la commande : " . mysqli_error($con) . "</h1>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Configuration ordinateur</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>

<header>
        <div class="logo">
            <a href="/index.php"><img src="/images/logo.png" alt="Logo de Pessay"></a>  <?php #Image générée par la demo de stablediffusion, rendue transparente avec https://onlinepngtools.com/create-transparent-png ?>
        </div>

        <h1>Validez Votre Commande:</h1>
    
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
    echo '<div class = product2><img src="data:image/jpeg;base64,' . $image_b64 . '" alt="Image du produit" width="400em" height="400em*(16/9)">
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
    echo '<h2 style="color:red; max-width: 200em; font-size: 3em; position: absolute; left: 35%; text-align:center; padding: 3em; padding-left: 5em;" >Afin de finaliser votre commande, merci de vous connecter.</h2>';
}

else{
    echo '<div class = "fill_commande">';
    echo '<form method="post">';


    echo '  <label for="nom">Nom: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="nom" required><br><br>';

    echo '  <label for="prenom">Prénom: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="prenom" required><br><br>';

    echo '  <label for="country">Pays de livraison:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="country" required><br><br>';

    echo '  <label for="adresse_facturation">Adresse de facturation:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="adresse_facturation" required><br><br>';

    echo '  <label for="code_postal">Code postal:</label> <br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="code_postal" required><br><br>';

    echo '  <label for="adresse_livraison">Adresse de livraison*: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="adresse_livraison" required><br><br>';

    echo '  <label for="telephone_number">Téléphone: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="number" name="telephone_number" required><br><br>';

    echo '  <label for="email">Adresse Email: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="text" name="email"><br><br>';

    echo '  <label for="card_number">Numéro de Carte: </label><br>';
    echo '  <input style="width: 100%; font-size: 1em;" type="number" name="card_number" required><br><br>';

    echo '  <label for="expiration_date">Date d\'expiration: </label><br>';
    echo '  <input style="width: 30%; font-size: 1em;" type="text" name="expiration_date" value="xx/xx" required><br><br>';

    echo '  <label for="cryptogramme">Cryptogramme: </label><br>';
    echo '  <input style="width: 30%; font-size: 1em;" type="number" name="cryptogramme" maxlength="3" required><br><br>';


    echo '  <input class = "button" type="submit" name="commande" value="Valider"><br><br>';
    echo '</form>';
    echo '</div>';
}

?>



</body>


</html>