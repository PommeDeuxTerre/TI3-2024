<?php

class Localisation {
	public $id;
	public $name;
	public $street;
	public $postal_code;
	public $phone_number;
	public $url;
	public $lat;
	public $long;
	function __construct(int|null $id, string $name, string $street, string $postal_code, string $phone_number, string $url, float $lat, float $long) {
		$this->id = $id;
		$this->name = $name;
		$this->street = $street;
		$this->postal_code = $postal_code;
		$this->phone_number = $phone_number;
		$this->url = $url;
		$this->lat = $lat;
		$this->long = $long;
	}
	function check_fields():true|string{
	    $this->name = htmlspecialchars(strip_tags(trim($this->name)),ENT_QUOTES);
	    if ($name==="")return "le champ `Nom` ne peut pas être vide";
	    $this->street = htmlspecialchars(strip_tags(trim($this->street)),ENT_QUOTES);
	    if ($street==="")return "le champ `Rue` ne peut pas être vide";
	    $this->postal_code = htmlspecialchars(strip_tags(trim($this->postal_code)),ENT_QUOTES);
	    if ($postal_code==="")return "le champ `Code postal` ne peut pas être vide";
	    $this->phone_number = htmlspecialchars(strip_tags(trim($this->phone_number)),ENT_QUOTES);
	    if ($phone_number==="")return "le champ `Telephone` ne peut pas être vide";
	    $this->url = htmlspecialchars(strip_tags(trim($this->url)),ENT_QUOTES);
	    if ($url==="")return "le champ `Url` ne peut pas être vide";
	    return true;
	}
}

function get_all_localisations(PDO $db):array|string{
    try {
        $sql = "SELECT *, CONCAT_WS(' ', `rue`, `codepostal`, 'Bruxelles') AS adresse FROM `localisations` ORDER BY `id` DESC";
        $query = $db->query($sql);
        $locations = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        if (count($locations)===0){
            return "pas encore de lieux";
        }
	for ($i=0;$i<count($locations);$i++){
		$locations[$i]["actions"] = "<a href='./?edit=".$locations[$i]["id"]."'><i class='fa fa-pencil text-primary eye-icon'></i></a><a href='./?delete=".$locations[$i]["id"]."'><i class='fa fa-trash text-primary eye-icon'></i></a>";
		$locations[$i]["nom2"] = "<p class='name-location' onclick='markers_hashmap[".$locations[$i]["id"]."].openPopup();map.setView(markers_hashmap[".$locations[$i]["id"]."].getLatLng(), 17)'>".$locations[$i]["nom"]."</p>";
	}
        return $locations;
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function get_localisation_by_id(PDO $db, int $id):array|string{
    try {
        $sql = "SELECT * FROM `localisations` WHERE `id`=?";
        $prepare = $db->prepare($sql);
        $prepare->execute([$id]);
        $locations = $prepare->fetch(PDO::FETCH_ASSOC);
        $prepare->closeCursor();
        if ($locations)return $locations;
        return "Localisation non trouvée";
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function get_localisation_by_page(PDO $db, int $nb_by_page, int $page):array|string{
    try {
        $offset = $nb_by_page * ($page - 1);
        $limit = $nb_by_page;
        $sql = "SELECT * FROM `localisations` ORDER BY `id` DESC LIMIT $offset,$limit";
        $prepare = $db->prepare($sql);
        $prepare->execute();
        $locations = $prepare->fetchAll(PDO::FETCH_ASSOC);
        $prepare->closeCursor();
        if ($locations)return $locations;
        return "Localisations non trouvées";
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function update_localisation_by_id(PDO $db, int $id, string $name, string $street, string $postal_code, string $phone_number, string $url, float $lat, float $long):true|string{
    $localisation = new Localisation($id, $name, $street ,$postal_code, $phone_number, $url, $lat, $long);
    $check = $localisation->check_fields();
    if ($check!==true)return $check;

    try {
        $sql = "UPDATE `localisations`
            SET
                `nom`=?,
                `rue`=?,
                `codepostal`=?,
                `telephone`=?,
                `url`=?,
                `latitude`=?,
                `longitude`=?
            WHERE
                `id`=?
        ;";
        $prepare = $db->prepare($sql);
        $prepare->execute([$localisation->name, $localisation->street, $localisation->postal_code, $localisation->phone_number, $localisation->url, $localisation->lat, $localisation->long, $localisation->id]);
        $prepare->closeCursor();
        return true;
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function insert_localisation(PDO $db, string $name, string $street, string $postal_code, string $phone_number, string $url, float $lat, float $long):true|string{
    $localisation = new Localisation(null, $name, $street ,$postal_code, $phone_number, $url, $lat, $long);
    $check = $localisation->check_fields();
    if ($check!==true)return $check;

    try {
        $sql = "INSERT INTO `localisations`
                ( `nom`, `rue`, `codepostal`, `telephone`, `url`, `latitude`, `longitude`)
                VALUES
                (?,?,?,?,?,?,?)
        ;";
        $prepare = $db->prepare($sql);
        $prepare->execute([$localisation->name, $localisation->street, $localisation->postal_code, $localisation->phone_number, $localisation->url, $localisation->lat, $localisation->long]);
        $prepare->closeCursor();
        return true;
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function remove_location(PDO $db, int $id):true|string{
    try {
        $sql = "DELETE FROM `localisations` WHERE `id`=?";
        $prepare = $db->prepare($sql);
        $prepare->execute([$id]);
        $prepare->closeCursor();
        return true;
    }catch (Exception $e){
        return $e->getMessage();
    }
}

function get_locations_number(PDO $db):int|string{
    try {
        $sql = "SELECT COUNT(*) AS nb FROM `localisations`";
        $query = $db->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $result["nb"];
    }catch (Exception $e){
        return $e->getMessage();
    }
}
