<div class="container">
    <?php if (isset($error)): ?>
        <p class="bg-danger"> <?= $error ?></p>
    <?php endif; ?>

    <h3><?= $comision->asignatura . ' ' . $comision->nombre ?></h3>

    <form action="<?= $action_url ?>" method="post">
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
            <div class="input-group date" id="hora_inicio">
                <input type="text" class="form-control" name="hora_inicio"
                       value="<?= $horario['hora_inicio'] ?>" readonly />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <div class="input-group date" id="duracion">
                <input type="text" class="form-control" name="duracion"
                       value="<?= $horario['duracion'] ?>" readonly />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="Aula_id">Aula</label>
            <select name="Aula_id" id="Aula_id" class="form-control">
                <?php foreach ($aulas as $aula): ?>
                    <option value="<?= $aula->id ?>"
                        <?= $horario['Aula_id'] == $aula->id ? 'selected' : '' ?>>
                        <?= $aula->nombre . ' - ' . $aula->edificio; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_desde">Aplicar cambios a partir de</label>
            <div class="input-group date" id="fecha_desde">
                <input type="text" class="form-control" name="fecha_desde"
                       value="<?= $fecha_desde ?>" readonly="readonly" />
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Actualizar</button>
    </form>

    <script type="text/javascript">
        $(function () {
            $('#hora_inicio').datetimepicker({
                format: 'HH:mm:ss',
                ignoreReadonly: true
            });
            $('#duracion').datetimepicker({
                format: 'HH:mm:ss',
                ignoreReadonly: true
            });
            $('#fecha_desde').datetimepicker({
                locale: 'es',
                format:'DD/MM/YYYY',
                ignoreReadonly: true
            });
        });
    </script>
</div>