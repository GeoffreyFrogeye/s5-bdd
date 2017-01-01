<?php
require('header.inc.php');

$sql = file_get_contents('fixture.sql');
$res = pg_query($bdd, $sql);
if ($res) {
?>
    <div class="alert alert-success" role="alert">La base de donnée a été réinitialisée avec les valeurs par défaut.</div>
<?php
} else {
    erreurBDD("Impossible de réinitialiser la base de donnée.");
}

require('footer.inc.php');

?>
