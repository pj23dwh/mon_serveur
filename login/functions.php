<?php

function check_login($con) # vérifie si l'utilisateur est connecté ou non (avec comme variable la connexion à la base de donnée).
{
    if(isset($_SESSION["user_id"]))
    {
        $id = $_SESSION["user_id"]; # simplification pour la suite du code de l'id user en "$id"
        $query = "select * from users where user_id = '$id' limit 1"; # création de la requêt mysql

        $result = mysqli_query($con, $query); # retour de la réponse de la base donnée sous "$result"
        if($result && mysqli_num_rows($result) > 0) # verification que la réponse de mysql est non nulle
        {
            $user_data = mysqli_fetch_assoc($result); # enregistrement des data utilisateurs récupérées de la base de donnée sous "$user_data"
            $_SESSION["user_is_connected"] = true; # activation de la variable bool $_SESSION
            return $user_data; # envoi des data fraichement récupérées vers la page utilisant la fonciton "check_login($con)"
        }
    }
    
    $_SESSION["user_is_connected"] = false;
    return;

}

function random_num($length) # commande générant un nombre aléatoire
{

    $text = "";
    if($length < 5)
    {
        $length = 5;
    }
    $len = rand(4, $length);

    for ($i=0; $i < $len; $i++) 
    { 
        
        $text .= rand(0, 9);
    }

    return $text; 
}



function get_product_data($con, $product_id) #récupère les data complètes d'un produit x (pour infos sur son fonctionnement, cf fonction "check_login($con)")
{
    $query = "SELECT * FROM Produits WHERE id = $product_id";
    $result = mysqli_query($con, $query);
    $product_data = mysqli_fetch_assoc($result);
    return $product_data;

}

function get_user_data($con, $user_name)
{
    if (!empty($user_name) && !is_numeric($user_name)) # vérification de la validité du username
    {
        
        $query = "select * from users where user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query); # obtentions des données de l'user correspondant au nom username


            if ($result && mysqli_num_rows($result) > 0) # vérification que les données récupérées sont non nulles 
            {
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
                
                
            } 
            
        
    }
    die;
}

?>