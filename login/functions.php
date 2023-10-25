<?php

function check_login($con) # vérifie si l'utilisateur est connecté ou non (avec comme variable la connexion à la base de donnée).
{
    if(isset($_SESSION["user_id"]))
    {
        $id = $_SESSION["user_id"]; # simplification pour la suite du code de l'id user en "$id"
        $query = "select * from users where id = '$id' limit 1"; # création de la requêt mysql

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



###!CRUD!###

function db_read($con, $table, $colonne, $data)
{
    $query = "SELECT * from $table where $colonne = '$data' limit 1";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Erreur lors de la lecture de la base de donnée : " . mysqli_error($con);
    }
    return $result;
}

function db_update($con, $table, $colonne, $db_id, $data, $id)
{
    $query = "UPDATE $table set $colonne = '$data' WHERE $db_id = '$id'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Erreur lors de la mise à jour de la base de donnée : " . mysqli_error($con);
    }
}

function db_delete($con, $table, $colonne, $data )
{
    $query = "DELETE from $table WHERE $colonne = '$data'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Erreur lors de la suppression des données : " . mysqli_error($con);
    }
}

function db_create($con, $table, $colonne , $data)
{
    $query = "INSERT into $table ($colonne) VALUES ('$data')";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Erreur lors de l'insertion des données : " . mysqli_error($con);
    }
}

###!CRUD!###


###Fonctions dérivée du CRUD###

function get_user_data($con, $user_name)
{
    $result = db_read($con, "users", "user_name", $user_name);

    if ($result && mysqli_num_rows($result) > 0) # vérification que les données récupérées soient non nulles 
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data; 
        } 
            
    die;
}


function get_product_data($con, $product_id) #récupère les data complètes d'un produit x (pour infos sur son fonctionnement, cf fonction "check_login($con)")
{
    #$query = "SELECT * FROM Produits WHERE id = $product_id";
    #$result = mysqli_query($con, $query);

    $result = db_read($con, "Produits", "id", $product_id);
    $product_data = mysqli_fetch_assoc($result);
    return $product_data;

}


###Fonctions dérivée du CRUD###

?>