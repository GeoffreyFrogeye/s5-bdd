<?php
require('header.inc.php');

// Récupérons la liste des palettes dans la salle
$sql = "SELECT * FROM VueDeplacement";
$salles = pg_exec($bdd, $sql);
if (!$salles) {
    erreurBDD("Impossible de récupérer la liste des palettes déplaceables");
}

?>

<h2>Palettes non-allouées</h2>

<?php

$dernierePalette = null;
while ($salle = pg_fetch_assoc($salles)) {

    // On exploite le fait que les vues soient triées
    // par palette afin de pouvoir détecter le changement
    // de palette et ainsi fermer la liste précédente et
    // en ouvrir une nouvelle tout en ayant une seule palette
    if ($salle['codepa'] != $dernierePalette) {

        // Si on est pas au tout début, cela veut dire que
        // ce n'est pas le premier tableau et donc qu'il faut
        // fermer la liste précédente
        if ($dernierePalette !== null) {
?>
</ul>
<?php

        }

?>
<h3>Palette <?php echo $salle['codepa']; ?></h3>
<ul class="nav nav-pills nav-stacked">
<?php
    }
?>
    <li>
        <a href="deplacer.php?palette=<?php echo urlencode($salle['codepa']); ?>&salle=<?php echo urlencode($salle['numero']); ?>">
            Entreposer dans la salle <?php echo $salle['numero']; ?>
        </a>
    </li>
<?php
    $dernierePalette = $salle['codepa'];
}
if ($dernierePalette) {
?>
</ul>
<?php
} else {
?>
<p>Toutes les palettes sont allouées à une salle.</p>
<div class="alert alert-info" role="alert"><strong>Astuce :</strong> Vous pouvez réinitialiser la BDD avec des valeurs par défaut depuis l'Accueil pour pouvoir tester l'affectation des salles à nouveau.</div>
<?php
}
include('footer.inc.php');
?>
