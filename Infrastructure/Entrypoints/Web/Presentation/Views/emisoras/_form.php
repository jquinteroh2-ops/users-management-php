<?php
/**
 * Campos del formulario de emisora, compartidos por "registrar" y "editar".
 *
 * Variables esperadas: $values (array con los valores actuales), $errors, $generoOptions.
 */
$field = static function (string $name) use ($values): string {
    return htmlspecialchars((string) ($values[$name] ?? ''), ENT_QUOTES, 'UTF-8');
};
$error = static function (string $name) use ($errors): string {
    if (empty($errors[$name])) {
        return '';
    }
    return '<div class="field-error">' . htmlspecialchars($errors[$name], ENT_QUOTES, 'UTF-8') . '</div>';
};
?>
<div class="form-group">
    <label for="nombre">Nombre *</label><br>
    <input type="text" id="nombre" name="nombre" maxlength="100" value="<?= $field('nombre') ?>">
    <?= $error('nombre') ?>
</div>

<div class="form-group">
    <label for="canal">Canal / indicativo *</label><br>
    <input type="text" id="canal" name="canal" maxlength="50" value="<?= $field('canal') ?>" placeholder="HJKC">
    <?= $error('canal') ?>
</div>

<div class="form-group">
    <label for="bandaFm">Banda FM (MHz)</label><br>
    <input type="number" id="bandaFm" name="bandaFm" step="0.1" min="87.5" max="108" value="<?= $field('bandaFm') ?>" placeholder="95.5">
    <?= $error('bandaFm') ?>
</div>

<div class="form-group">
    <label for="bandaAm">Banda AM (kHz)</label><br>
    <input type="number" id="bandaAm" name="bandaAm" step="1" min="530" max="1710" value="<?= $field('bandaAm') ?>" placeholder="1170">
    <?= $error('bandaAm') ?>
    <small>Debe llenar al menos una de las dos bandas.</small>
</div>

<div class="form-group">
    <label for="numLocutores">Número de locutores *</label><br>
    <input type="number" id="numLocutores" name="numLocutores" min="1" value="<?= $field('numLocutores') ?>">
    <?= $error('numLocutores') ?>
</div>

<div class="form-group">
    <label for="genero">Género *</label><br>
    <select id="genero" name="genero">
        <option value="">-- Seleccione --</option>
        <?php foreach ($generoOptions as $opt): ?>
            <option value="<?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>" <?= (($values['genero'] ?? '') === $opt) ? 'selected' : '' ?>>
                <?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?= $error('genero') ?>
</div>

<div class="form-group">
    <label for="horario">Horario *</label><br>
    <input type="text" id="horario" name="horario" maxlength="100" value="<?= $field('horario') ?>" placeholder="24 horas">
    <?= $error('horario') ?>
</div>

<div class="form-group">
    <label for="patrocinador">Patrocinador</label><br>
    <input type="text" id="patrocinador" name="patrocinador" maxlength="150" value="<?= $field('patrocinador') ?>">
    <?= $error('patrocinador') ?>
</div>

<div class="form-group">
    <label for="pais">País *</label><br>
    <input type="text" id="pais" name="pais" maxlength="80" value="<?= $field('pais') ?>" placeholder="Colombia">
    <?= $error('pais') ?>
</div>

<div class="form-group">
    <label for="descripcion">Descripción</label><br>
    <textarea id="descripcion" name="descripcion" rows="3" maxlength="500"><?= $field('descripcion') ?></textarea>
    <?= $error('descripcion') ?>
</div>

<div class="form-group">
    <label for="numProgramas">Número de programas *</label><br>
    <input type="number" id="numProgramas" name="numProgramas" min="0" value="<?= $field('numProgramas') ?>">
    <?= $error('numProgramas') ?>
</div>

<div class="form-group">
    <label for="numCiudades">Número de ciudades con cobertura *</label><br>
    <input type="number" id="numCiudades" name="numCiudades" min="1" value="<?= $field('numCiudades') ?>">
    <?= $error('numCiudades') ?>
</div>
