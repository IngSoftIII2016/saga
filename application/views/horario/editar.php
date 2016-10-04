<?php if (isset($error)): ?>
    <p class="bg-danger"> <?= $error ?></p>
<?php endif; ?>
<form class="form-inline" action="<?= $action_url ?>" method="post">
    <div class="form-group">
        <label for="dia">Día</label>
        <select class="form-control" name="dia" id="dia">
            <?php foreach ($dias as $i => $dia): ?>
                <option value="<?= $i ?>"
                    <?= $horario['dia'] == $i ? 'selected' : '' ?>>
                    <?= $dia ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="hora_inicio">Hora de comienzo</label>
        <input id="hora_inicio" name="hora_inicio" value="<?= $horario['hora_inicio'] ?>"
               class="timepicker text-center" jt-timepicker="" time="model.time"
               time-string="model.timeString"
               default-time="<?php substr($horario['hora_inicio'], 3); ?>"
               time-format="model.options.timeFormat"
               start-time="model.options.startTime" min-time="model.options.minTime"
               max-time="model.options.maxTime" interval="model.options.interval"
               dynamic="model.options.dynamic" scrollbar="model.options.scrollbar"
               dropdown="model.options.dropdown" />
    </div>
    <div class="form-group">
        <label for="duracion">Duración</label>
        <input id="duracion" name="duracion" value="<?= $horario['duracion'] ?>"
               class="timepicker text-center" jt-timepicker="" time="model.time"
               time-string="model.timeString"
               default-time="<?php substr($horario['duracion'], 3); ?>"
               time-format="model.options.timeFormat"
               start-time="model.options.startTime" min-time="model.options.minTime"
               max-time="model.options.maxTime" interval="model.options.interval"
               dynamic="model.options.dynamic" scrollbar="model.options.scrollbar"
               dropdown="model.options.dropdown"/>
    </div>
    <div class="form-group">
        <label for="Aula_id">Aula</label>
        <select name="Aula_id" id="Aula_id" class="form-control" >
            <?php foreach ($aulas as $aula): ?>
                <option value="<?= $aula->id ?>"
                    <?= $horario['Aula_id'] == $aula->id ? 'selected' : '' ?>>
                    <?= $aula->nombre . ' - ' . $aula->edificio; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Actualizar</button>
</form>

<script
        src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#hora_inicio');
    });
    $('#hora_inicio').timepicker({
        timeFormat: 'HH:mm:ss ',
        interval: 30,
        minTime: '08',
        maxTime: '21:00:00',
        startTime: '08:00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
    $('#duracion').timepicker({
        timeFormat: 'HH:mm:ss ',
        interval: 30,
        minTime: '00',
        maxTime: '09',
        startTime: '00:00:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

</script>