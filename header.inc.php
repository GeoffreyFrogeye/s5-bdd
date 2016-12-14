<?php
// Ce fichier, qui sera inclus dans toutes les autres pages, sert à plusieurs fonctions
// La première est d'écrire les en-têtes HTML qui sont les mêmes sur toutes les pages,
// ainsi que le titre principal et le menu
// Elle définit certains paramètres qui seront utiles pour toutes les pages
// Elle fait de même avec certaines fonctions
// Enfin, elle crée la variable $bdd qui est une ressource d'accès à la base de données
// qui sera accessible par toutes les pages
?>
<!doctype html>
<html>
<head>
    <title>S5 BDD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width;minimum-scale=0.5,maximum-scale=1.0; user-scalable=1;" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<article class="container">
<?php

// Paramètres utiles
ini_set('display_errors', 'on');
error_reporting(E_ALL);

// Liste des fonctions utiles
function erreurBDD($message) {
?>
    <div class="alert alert-danger" role="alert"><?php echo $mesage; ?> (<?php echo pg_last_error($db); ?>)</div>
<?php
    include('footer.php');
    die();
}

// On se connecte
include('config.php');
$bdd = pg_connect("host=$machine user=$user password=$pwd dbname=$db");
if (!$db) {
    erreurBDD("Impossible de se connecter à la base de données");
}

?>
<h1>S5 - Projet de Base De Données</h1>
<ul class="nav nav-pills">
    <li role="presentation"><a href="index.php">Accueil</a></li>
    <li role="presentation"><a href="entrepot.php">Entrepot</a></li>
    <li role="presentation"><a href="deplacement.php">Palettes non-allouées</a></li>
</ul>
