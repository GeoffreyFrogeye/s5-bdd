<?php
require('header.inc.php');

$salle = $_GET['salle'];

?>
<h2>Salle <?php echo $salle; ?></h2>
<?php

// Récupérons la liste des palettes dans la salle
$sql = "SELECT * FROM VueSalle WHERE lieu = '".pg_escape_string($salle)."'";
$palettes = pg_exec($bdd, $sql);
if (!$palettes) {
    erreurBDD("Impossible de récupérer la liste des palettes");
}

while ($palette = pg_fetch_assoc($palettes)) {

?>
<h3>Palette <?php echo $palette['codepa']; ?></h3>
<?php
// Récupérons la liste des produits sur la palette

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
// Récupérons la liste des produits sur la palette
$sql2 = "SELECT * FROM VuePalette WHERE codepa = '".pg_escape_string($palette['codepa'])."'";
$produits = pg_exec($bdd, $sql2);
while ($produit = pg_fetch_assoc($produits)) {
?>
    <tr>
        <td><?php echo $produit['codepr']; ?></td>
        <td><?php echo $produit['libelle']; ?></td>
        <td><?php echo $produit['temperaturemin']; ?>°C</td>
        <td><?php echo $produit['temperaturemax']; ?>°C</td>
        <td><?php echo $produit['quantite']; ?> unité<?php if ($produit['quantite'] >= 2) { ?>s<?php } ?></td>
    </tr>
<?php
}
?>
</table>
<?php
}
include('footer.inc.php');
?>
