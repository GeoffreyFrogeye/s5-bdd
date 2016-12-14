<?php
require('header.inc.php');

// Récupérons la liste des palettes dans la salle
$sql = "SELECT * FROM VueDeplacement";
$palettes = pg_exec($bdd, $sql);
if (!$palettes) {
    erreurBDD("Impossible de récupérer la liste des palettes déplaceables");
}

?>

<h2>Palettes non-allouées</h2>

<?php

$dernierePalette = null;
while ($palette = pg_fetch_assoc($palettes)) {

    // On exploite le fait que les vues soient triées
    // par palette afin de pouvoir détecter le changement
    // de palette et ainsi fermer la liste précédente et
    // en ouvrir une nouvelle tout en ayant une seule palette
    if ($palette['codepa'] != $dernierePalette) {

        // Si on est pas au tout début, cela veut dire que
        // ce n'est pas le premier tableau et donc qu'il faut
        // fermer la liste précédente
        if ($dernierePalette !== null) {
?>
</ul>
<?php

        }

?>
<h3>Palette <?php echo $palette['codepa']; ?></h3>
<?php

?>
<ul class="nav nav-pills nav-stacked">
<?php
    }
?>
    <li>
        <a href="deplacer.php?palette=<?php echo urlencode($palette['codepa']); ?>&salle=<?php echo urlencode($palette['numero']); ?>">
            Entreposer dans la salle <?php echo $palette['numero']; ?>
        </a>
    </li>
<?php
    $dernierePalette = $palette['codepa'];
}
?>
</ul>
<?php
include('footer.inc.php');
?>
