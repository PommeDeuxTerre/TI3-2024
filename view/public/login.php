<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="card mt-4 container mt-5">
        <div class="card-header fw-bold fs-3">CONNEXION</div>
        <form class="card-body container-fluid" method="post">
            <div class="row mb-3">
                <?php if(isset($error) && $error): ?>
                <div class="col-12">
                    <p class="text-center text-danger fs-2"><?= $error ?></p>
                </div>
                <?php endif; ?>
                <div class="col-12">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" autofocus>
                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>