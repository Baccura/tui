<?php ob_start(); ?>
<h1>Erreur</h1>

<p class="text-danger text-bold"><?= $errorMessage ?></p>
<?php $content = ob_get_clean(); ?>

<?php require 'templates/layout.php'; ?>