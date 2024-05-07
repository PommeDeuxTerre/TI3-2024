<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>
<body>
    <h1>Carte interactive</h1>
    <h2>Liste des théâtres à Bruxelles</h2>
    <p id="login-link"><a href="./?p=login">Connexion à l'administration</a></p>
    <h4 id="nb-locations"></h4>
    <main id="public-home">
        <div id="map"></div>
        <!-- liste locations -->
        <ul id="locations-list">
        </ul>
    </main>
    <!-- leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- local script -->
    <script src="./js/main.js"></script>
</body>
</html>