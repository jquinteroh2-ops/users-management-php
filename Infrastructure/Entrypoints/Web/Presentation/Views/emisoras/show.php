<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Detalle de emisora</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php
$filas = array(
    'ID' => $emisora->getId(),
    'Nombre' => $emisora->getNombre(),
    'Canal' => $emisora->getCanal(),
    'Banda FM' => $emisora->getBandaFm() === null ? 'No transmite' : number_format($emisora->getBandaFm(), 1, '.', '') . ' MHz',
    'Banda AM' => $emisora->getBandaAm() === null ? 'No transmite' : $emisora->getBandaAm() . ' kHz',
    'Locutores' => (string) $emisora->getNumLocutores(),
    'Género' => $emisora->getGenero(),
    'Horario' => $emisora->getHorario(),
    'Patrocinador' => $emisora->getPatrocinador() === '' ? '—' : $emisora->getPatrocinador(),
    'País' => $emisora->getPais(),
    'Descripción' => $emisora->getDescripcion() === '' ? '—' : $emisora->getDescripcion(),
    'Programas' => (string) $emisora->getNumProgramas(),
    'Ciudades' => (string) $emisora->getNumCiudades(),
);
?>
<table class="detail-table">
    <?php foreach ($filas as $etiqueta => $valor): ?>
        <tr>
            <th><?= htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8') ?></th>
            <td><?= htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=emisoras.edit&amp;id=<?= urlencode($emisora->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=emisoras.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
