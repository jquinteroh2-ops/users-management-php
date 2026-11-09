<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Editar emisora</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="POST" action="?route=emisoras.update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($emisora->getId(), ENT_QUOTES, 'UTF-8') ?>">
    <?php
    // Si hubo errores se muestran los datos que el usuario escribió; si no, los guardados.
    $values = !empty($old) ? $old : $emisora->toArray();
    require __DIR__ . '/_form.php';
    ?>
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a class="btn" href="?route=emisoras.index">Cancelar</a>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
