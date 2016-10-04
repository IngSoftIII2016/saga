<?php if(isset($error)): ?>
<p class="bg-danger"> <?=$error?></p>
<?php endif;?>
<form class="form-inline" action="<?= $action_url ?>">
    <div class="form-group">
        <label for="dia">Día</label>
        <select class="form-control" id="dia">
            <?php foreach ($dias as $i => $dia): ?>
                <option value="<?= $i ?>" <?=$horario['dia'] == $i ? 'selected' : '' ?> >
                    <?= $dia ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="hora_inicio">Hora de comienzo</label>
        <input data-format="hh:mm:ss" type="datetime" id="hora_inicio" value="<?=$horario['hora_inicio']?>"/>
    </div>
    <div class="form-group">
        <label for="duracion">Duración</label>
        <input data-format="hh:mm:ss" type="datetime" id="duracion" value="<?=$horario['duracion']?>"/>
    </div>
    <div class="form-group">
        <label for="Aula_id">Aula</label>
        <select class="form-control" id="Aula_id">
            <?php foreach ($aulas as $aula): ?>
                <option value="<?= $aula->id ?>" <?=$horario['Aula_id'] == $aula->id ? 'selected' : ''?> >
                    <?= $aula->nombre . ' - ' . $aula->edificio; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Actualizar</button>
</form>
<script type="text/javascript">
    $(function () {
        $('#hora_inicio');
    });
</script>