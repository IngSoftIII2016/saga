<div class="container">
    <?php if (isset($error)): ?>
        <p class="bg-danger"> <?= $error ?></p>
    <?php endif; ?>
    <h3>Nuevo horario</h3>
    <form action="<?= $action_url ?>" method="post">
        <div class="form-group">
            <label for="Comision_id">Comision</label>
            <select class="form-control" name="Comision_id" id="Comision_id">
                <?php foreach ($comisiones as $comision): ?>
                    <option value="<?= $comision->id ?>">
                        <?= $comision->asignatura . ' ' . $comision->nombre ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="frecuencia_semanas">Cada # semanas</label>
            <input class="form-control" type="number" name="frecuencia_semanas" value="1"/>
        </div>
        <div class="form-group">
            <label for="dia">Día</label>
            <select class="form-control" name="dia" id="dia">
                <?php foreach ($dias as $i => $dia): ?>
                    <option value="<?= $i ?>">
                        <?= $dia ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="hora_inicio">Hora de comienzo</label>
            <div class="input-group date" id="hora_inicio">
                <input type="text" class="form-control" name="hora_inicio"
                       readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="duracion">Duración</label>
            <div class="input-group date" id="duracion">
                <input type="text" class="form-control" name="duracion" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="Aula_id">Aula</label>
            <select name="Aula_id" id="Aula_id" class="form-control">
                <?php foreach ($aulas as $aula): ?>
                    <option value="<?= $aula->id ?>">
                        <?= $aula->nombre . ' - ' . $aula->edificio; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_desde">Crear a partir de</label>
            <div class="input-group date" id="fecha-desde">
                <input type="text" class="form-control" name="fecha_desde"/>
                <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <button type="submit" class="btn btn-default">Guardar</button>
    </form>

    <script type="text/javascript">
        $('#hora_inicio').datetimepicker({
            format: 'HH:mm:ss',
            ignoreReadonly: true
        });
        $('#duracion').datetimepicker({
            format: 'HH:mm:ss',
            ignoreReadonly: true
        });
        $('#fecha-desde').datetimepicker({
            locale: 'es',
            format:'DD/MM/YYYY',
            ignoreReadonly: true
        });

    </script>
</div>