<?php
require('header.inc.php');

$salle = $_GET['salle'];


// Récupérons la liste des palettes dans la salle
$sql = "SELECT * FROM VueSalle WHERE numero = '".pg_escape_string($salle)."'";
$produits = pg_exec($bdd, $sql);
if (!$produits) {
    erreurBDD("Impossible de récupérer la liste des produits");
}

$dernierePalette = null;
while ($produit = pg_fetch_assoc($produits)) {

    // Si on est à la première ligne du tableau, on a pas encore
    // affiché la salle qu'on a pas pu afficher plus tôt étant
    // donné qu'on ne pouvait pas utiliser pg_fetch_* sans
    // perdre un enregistrement
    if ($dernierePalette === null) {
?>
    <h2>Salle <?php echo $produit['numero']; ?> (<?php echo $produit['temperature']; ?>°C)</h2>
<?php
    }

    // Étant donné que l'on renvoie une ligne même pour les salles
    // vides, il faut vérifier que la ligne qui est traitée contient
    // bien un produit afin de ne pas créer de tableau vide
    if ($produit['codepa']) {

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
<h3>Palette <?php echo $produit['codepa']; ?></h3>
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
}
if ($dernierePalette) {
?>
</table>
<?php
} else {
?>
<p>Cette salle est vide.</p>
<?php
}
include('footer.inc.php');
?>
