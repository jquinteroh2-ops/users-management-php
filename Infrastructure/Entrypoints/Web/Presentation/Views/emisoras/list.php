<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de emisoras</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<p><a class="btn btn-primary" href="?route=emisoras.create">Registrar emisora</a></p>

<?php if (empty($emisoras)): ?>
    <p>No hay emisoras registradas todavía.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Canal</th>
                <th>Bandas</th>
                <th>Género</th>
                <th>Horario</th>
                <th>País</th>
                <th>Locutores</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emisoras as $emisora): ?>
                <tr>
                    <td><?= htmlspecialchars($emisora->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($emisora->getCanal(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($emisora->bandasTexto(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($emisora->getGenero(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($emisora->getHorario(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($emisora->getPais(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $emisora->getNumLocutores() ?></td>
                    <td class="col-actions">
                        <a class="btn btn-sm" href="?route=emisoras.show&amp;id=<?= urlencode($emisora->getId()) ?>">Ver</a>
                        <a class="btn btn-warning btn-sm" href="?route=emisoras.edit&amp;id=<?= urlencode($emisora->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=emisoras.delete" style="display:inline;"
                            onsubmit="return confirmDelete(this);"
                            data-name="<?= htmlspecialchars($emisora->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($emisora->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
