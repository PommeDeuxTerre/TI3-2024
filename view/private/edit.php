<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php if (isset($_GET["edit_message"])): ?>
        <div class="alert alert-success text-center text-success" role="alert">
            <?=$_GET["edit_message"]?>
        </div>
    <?php endif; ?>
    <div class="card mt-4 container mt-5">
        <div class="card-header fw-bold fs-3">MODIFIER</div>
        <form class="card-body container-fluid" method="post">
            <div class="row mb-3">
                <?php if(isset($error) && $error): ?>
                <div class="col-12">
                    <p class="text-center text-danger fs-2"><?= $error ?></p>
                </div>
                <?php endif; ?>
                <div class="col-4 my-1">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($location))echo $location["nom"] ?>">
                </div>
                <div class="col-8 my-1">
                    <label for="street" class="form-label">Rue</label>
                    <input type="text" class="form-control" id="street" name="street" value="<?php if(isset($location))echo $location["rue"] ?>">
                </div>
                <div class="col-3 my-1">
                    <label for="postal" class="form-label">Code postal</label>
                    <input type="number" class="form-control" id="postal" name="postal" value="<?php if(isset($location))echo $location["codepostal"] ?>">
                </div>
                <div class="col-4 my-1">
                    <label for="telephone" class="form-label">Telephone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php if(isset($location))echo $location["telephone"] ?>">
                </div>
                <div class="col-5 my-1">
                    <label for="url" class="form-label">Url</label>
                    <input type="url" class="form-control" id="url" name="url" value="<?php if(isset($location))echo $location["url"] ?>">
                </div>
                <div class="col-6 my-1">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="number" step="0.000001" class="form-control" id="latitude" name="latitude" value="<?php if(isset($location))echo $location["latitude"] ?>">
                </div>
                <div class="col-6 my-1">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input type="number" step="0.000001" class="form-control" id="longitude" name="longitude" value="<?php if(isset($location))echo $location["longitude"] ?>">
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</body>
</html>