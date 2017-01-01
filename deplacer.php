<?php
require('header.inc.php');

// On vérifie que les paramètres ont bien été envoyés

if (!isset($_GET['palette']) || !isset($_GET['salle'])) {
    erreur("Veuillez indiquer la palette à déplacer et la salle dans laquelle la déplacer.");
}

// On vérifie que la palette est bien déplaceable

// Récupérons la liste des palettes déplaceables
$sql = "SELECT * FROM VueDeplacement WHERE numero = '".pg_escape_string($_GET['salle'])."' AND codepa = '".pg_escape_string($_GET['palette'])."'";
$salles = pg_exec($bdd, $sql);
if (!$salles) {
    erreurBDD("Impossible de récupérer la liste des palettes déplaceables.");
}

$salle = pg_fetch_assoc($salles);
if (!$salle) {
    erreur("Il n'est pas possible de déplacer cette palette dans cette salle.");
}

// On déplace la palette pour de bon

$sql = "UPDATE palette SET lieu = '".pg_escape_string($_GET['salle'])."' WHERE codepa = '".pg_escape_string($_GET['palette'])."'";
$res = pg_exec($bdd, $sql);
if ($res) {
?>
    <div class="alert alert-success" role="alert">La palette <?php echo htmlspecialchars($_GET['palette']); ?> a été correctement déplacée dans la salle <?php echo htmlspecialchars($_GET['salle']); ?>.</div>
<?php
} else {
    erreurBDD("Impossible de déplacer la palette.");
}

require('footer.inc.php');

?>
