<?php
require('header.inc.php');

$salle = $_GET['salle'];


// Récupérons la liste des palettes dans la salle
$sql = "SELECT * FROM VueSalle WHERE lieu = '".pg_escape_string($salle)."'";
$produits = pg_exec($bdd, $sql);
if (!$produits) {
    erreurBDD("Impossible de récupérer la liste des produits");
}

$dernierePalette = null;
while ($produit = pg_fetch_assoc($produits)) {

    // Si on est à la première lgine du tableau, on a pas encore
    // affiché la salle qu'on a pas pu afficher plus tôt étant
    // donné qu'on ne pouvait pas utiliser pg_fetch_* sans
    // perdre un enregistrement
    if ($dernierePalette === null) {
?>
    <h2>Salle <?php echo $produit['lieu']; ?> (<?php echo $produit['temperature']; ?>°C)</h2>
<?php
    }

    // On exploite le fait que les vues soient triées
    // par palette afin de pouvoir détecter le changement
    // de palette et ainsi fermer le tableau précédent et
    // en ouvrir un nouveau tout en ayant une seule palette
    if ($produit['codepa'] != $dernierePalette) {

        // Si on est pas au tout début, cela veut dire que
        // ce n'est pas le premier tableau et donc qu'il faut
        // fermer le tableau précédent
        if ($dernierePalette !== null) {
?>
</table>
<?php

        }

?>
<h3>produit <?php echo $produit['codepa']; ?></h3>
<?php
// Récupérons la liste des produits sur la produit

?>
<table class="table table-striped">
    <tr>
        <th>Code produit</th>
        <th>Libellé</th>
        <th>Température minimum</th>
        <th>Température maximum</th>
        <th>Quantité</th>
    </tr>
<?php
    }
// Récupérons la liste des produits sur la produit
?>
    <tr<?php if ($produit['horsborne'] == 't') { echo ' class="danger"'; }?>>
        <td><?php echo $produit['codepr']; ?></td>
        <td><?php echo $produit['libelle']; ?></td>
        <td><?php echo $produit['temperaturemin']; ?>°C</td>
        <td><?php echo $produit['temperaturemax']; ?>°C</td>
        <td><?php echo $produit['quantite']; ?> unité<?php if ($produit['quantite'] >= 2) { ?>s<?php } ?></td>
    </tr>
<?php
    $dernierePalette = $produit['codepa'];
}
?>
</table>
<?php
include('footer.inc.php');
?>
