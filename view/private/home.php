<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- bootstrap table -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
</head>
<body>
    <?php if (isset($_GET["delete_message"])): ?>
        <div class="alert alert-danger text-center text-danger" role="alert">
            <?=$_GET["delete_message"]?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["create_message"])): ?>
        <div class="alert alert-success text-center text-success" role="alert">
            <?=$_GET["create_message"]?>
        </div>
    <?php endif; ?>
    <h3></h3>
    <h1>Carte interactive</h1>
    <h2>Liste théatres à Bruxelles</h2>
    <p id="logout-link"><a href="./?p=logout">Se déconnecter</a></p><p id="create-link"><a href="./?create">Insérer un nouvel élement</a></p>
    <?php if (isset($number_locations) && $number_locations): ?>
        <h4 id="nb-locations">Il y a <?=$number_locations?> lieux dans la base de données test</h4>
    <?php elseif (isset($number_locations)): ?>
        <h4 id="nb-locations">Pas encore de lieux</h4>
    <?php endif; ?>
    <main>
        <div id="map"></div>
        <!-- table -->
        <div class="container-lg">
            <div class="table-responsive">
                <table class="table table-striped" data-click-to-select="true" data-toggle="table" data-show-columns="true" data-pagination="true" id="locations-table">
                    <thead>
                        <tr>
                            <th data-sortable="true">Nom</th>
                            <th>Adresse</th>
                            <th>Telephone</th>
                            <th>Url</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- pagination -->
            <?php if (isset($nb_page)): ?>
                <nav>
                    <ul class="pagination d-flex justify-content-center">
                        <li class="page-item">
                            <?php if (isset($_GET["page"]) && $_GET["page"]!=="2"): ?>
                                <a class="page-link" href="./?page=<?=(int)$_GET["page"]-1?>">Previous</a>
                            <?php elseif (isset($_GET["page"])): ?>
                                <a class="page-link" href="./">Previous</a>
                            <?php else: ?>
                                <a class="page-link disabled" href="./">Previous</a>
                            <?php endif; ?>
                        </li>
                        <li class="page-item">
                            <?php if (isset($_GET["page"])): ?>
                                <a class="page-link" href="./">1</a>
                            <?php else: ?>
                                <a class="page-link disabled" href="./">1</a>
                            <?php endif; ?>
                        </li>
                        <?php for($i=2;$i<=$nb_page;$i++): ?>
                            <li class="page-item">
                                <?php if (isset($_GET["page"]) && $_GET["page"]==="$i"): ?>
                                    <a class="page-link disabled" href="?page=<?=$i?>"><?=$i?></a>
                                <?php else: ?>
                                    <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
                                <?php endif; ?>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item">
                            <?php if (isset($_GET["page"]) && (int)$_GET["page"]==$nb_page): ?>
                                <a class="page-link disabled" href="./">Next</a>
                            <?php elseif (isset($_GET["page"])): ?>
                                <a class="page-link" href="./?page=<?=(int)$_GET["page"]+1?>">Next</a>
                            <?php else: ?>
                                <a class="page-link" href="./?page=2">Next</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </main>
    <!-- leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- local script -->
    <script src="./js/main.js"></script>
</body>
</html>
