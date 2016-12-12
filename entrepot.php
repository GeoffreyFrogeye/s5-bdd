<?php
require('header.inc.php');
?>
<h2>Liste des salles</h2>
<?php

$sql = "SELECT * FROM VueEntrepot";

$salles = pg_exec($bdd, $sql);

if (!$salles) {
    erreurBDD("Impossible de récupérer la liste des salles");
}
?>
<table class="table table-striped">
    <tr>
        <th>Numéro</th>
        <th>Température</th>
        <th>Capacité</th>
    </tr>
<?php
while ($row = pg_fetch_assoc($salles)) {
?>
    <tr>
        <td><a href="salle.php?salle=<?php echo $row['numero']; ?>"><?php echo $row['numero']; ?></a></td>
        <td><?php echo $row['temperature']; ?>°C</td>
        <td><?php echo $row['capacite']; ?> palette<?php if ($row['capacite'] >= 2) { ?>s<?php } ?></td>
    </tr>
<?php
}
?>
</table>
<?php
include('footer.inc.php');
?>
