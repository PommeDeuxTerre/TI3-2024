<?php

$number_locations = get_locations_number($db);

if (isset($_GET["p"])){
    switch ($_GET["p"]){
        case "logout":
            logout_admin();
            header("Location: ./");
        default:
            require_once("../view/private/home.php");
    }
}
elseif (isset($_GET["edit"])){
    if (is_numeric($_GET["edit"])){
        //if update
        if (isset($_POST["name"], $_POST["street"], $_POST["postal"], $_POST["telephone"], $_POST["url"], $_POST["latitude"], $_POST["longitude"])){
            $result = update_localisation_by_id($db, $_GET["edit"], $_POST["name"], $_POST["street"], $_POST["postal"], $_POST["telephone"], $_POST["url"], $_POST["latitude"], $_POST["longitude"]);
            if($result===true){
                header("Location: ./?edit=".$_GET["edit"]."&edit_message=position modifiée avec succès");
                die;
            }else {
                header("Location: ./?edit=".$_GET["edit"]."&error=".$result);
                die;
            }
        }
        $id = (int)$_GET["edit"];
        $result = get_localisation_by_id($db, $id);
        if (gettype($result) === "string"){
            $error = $result;
        }else {
            if (isset($_GET["error"]))$error = $_GET["error"];
            $location = $result;
        }
    }else {
        $error = "id not valid";
    }
    require("../view/private/edit.php");
}
elseif (isset($_GET["delete"])){
    $id = (int)$_GET["delete"];
    if (isset($_POST["confirm"])){
        $result = remove_location($db, $id);
        if ($result===true){
            header("Location: ./?delete_message=position supprimée avec succés");
            die;
        }else {
            $error = $result;
        }
    }
    $result = get_localisation_by_id($db, $id);
    if (gettype($result) === "string"){
        $error = $result;
    }else {
        $location = $result;
    }
    require("../view/private/delete.php");
}
elseif (isset($_GET["create"])){
    if (isset($_POST["name"], $_POST["street"], $_POST["postal"], $_POST["telephone"], $_POST["url"], $_POST["latitude"], $_POST["longitude"])){
        $result = insert_localisation($db, $_POST["name"], $_POST["street"], $_POST["postal"], $_POST["telephone"], $_POST["url"], (float)$_POST["latitude"], (float)$_POST["longitude"]);
        if ($result===true){
            header("Location: ./?create_message=position ajoutée avec succés");
            die;
        }else{
            $error = $result;
        }
    }
    require("../view/private/create.php");
}
else {
    $result = get_locations_number($db);
    if (gettype($result)==="integer"){
        $nb_page = ceil($result / ELEMENT_BY_PAGE);
    }
    require_once("../view/private/home.php");
}
