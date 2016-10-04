<style>
    .form-group{
        margin: 12px;
    }
    .tabla-horarios {
        margin-top: 8px;
    }
    #cabecera {
        background-color: #dedede
    }
</style>
    <form class="form-inline" action="<?= $action_url ?>" method="post">
        <div class="form-group">
            <label for="Periodo_id" class="control-label">Periodo:</label>
            <select class="form-control select2" name="Periodo_id" id="Periodo_id">
                <option value="">Todos</option>
                <?php foreach ($periodos as $periodo): ?>
                    <option value="<?= $periodo->id; ?>"
                        <?= isset($filtros['Periodo_id']) && $periodo->id == $filtros['Periodo_id'] ? "selected=\"selected\" " : " "; ?>>
                        <?= $periodo->descripcion; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Carrera_id" class="control-label">Carrera:</label>
            <select class="form-control select2" name="Carrera_id" id="Carrera_id">
                <option value="">Todas</option>
                <?php foreach ($carreras as $carrera): ?>
                    <option value="<?= $carrera->id; ?>"
                        <?= isset($filtros['Carrera_id']) && $carrera->id == $filtros['Carrera_id'] ? "selected=\"selected\" " : " "; ?>>
                        <?= $carrera->nombre; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Asignatura_id" class="control-label">Asignatura:</label>
            <select class="form-control select2" name="Asignatura_id" id="Asignatura_id">
                <option value="">Todas</option>
                <?php foreach ($asignaturas as $asignatura): ?>
                    <option value="<?= $asignatura->id; ?>" <?= isset($filtros['Asignatura_id']) && $asignatura->id == $filtros['Asignatura_id'] ? "selected=\"selected\" " : " " ?>>
                        <?= $asignatura->nombre ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Docente_id" class="control-label">Docente:</label>
            <select class="form-control select2" name="Docente_id" id="Docente_id">
                <option value="">Todos</option>
                <?php foreach ($docentes as $docente): ?>
                    <option value="<?= $docente->id; ?>" <?= isset($filtros['Docente_id']) && $docente->id == $filtros['Docente_id'] ? "selected=\"selected\" " : " "; ?>>
                        <?= $docente->apellido . ', ' . $docente->nombre ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Aula_id" class="control-label">Aula:</label>
            <select class="form-control select2" name="Aula_id" id="Aula_id">
                <option value="">Todas</option>
                <?php foreach ($aulas as $aula): ?>
                    <option value="<?= $aula->id; ?>" <?= isset($filtros['Aula_id']) && $aula->id == $filtros['Aula_id'] ? "selected=\"selected\" " : " "; ?>>
                        <?= $aula->nombre . " - " . $aula->edificio; ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="form-group">
            <label for="dia" class="control-label">Día:</label>
            <select class="form-control select2" name="dia" id="dia">
                <option value="">Todos</option>
                <?php foreach ($dias as $index => $nombre): ?>
                    <option value="<?= $index; ?>" <?= isset($filtros['dia']) && $filtros['dia'] != "" && $index == $filtros['dia'] ? "selected=\"selected\" " : " "; ?>>
                        <?= $nombre; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pull-right">
            <button type="submit" class="btn btn-default">Aplicar Filtros</button>
        </div>
    </form>
<a style="color: black;" href="<?=base_url('horario/nuevo')?>">Nuevo Horario</a>
    <table class="table table-bordered tabla-horarios">
        <tr id="cabecera">
            <th>carrera</th>
            <th>asignatura</th>
            <th>comisión</th>
            <th>descripción</th>
            <th>día</th>
            <th>hora</th>
            <th>duración</th>
            <th>edificio</th>
            <th>aula</th>
            <th>editar</th>
        </tr>
        <?php foreach ($horarios as $horario): ?>
            <tr>
                <td><?= $horario['carrera'] ?></td>
                <td><?= $horario['asignatura'] ?></td>
                <td><?= $horario['comision'] ?></td>
                <td><?= $horario['descripcion'] ?></td>
                <td><?= $dias[$horario['dia']] ?></td>
                <td><?= $horario['hora_inicio'] ?></td>
                <td><?= $horario['duracion'] ?></td>
                <td><?= $horario['edificio'] ?></td>
                <td><?= $horario['aula'] ?></td>
                <td><a style="color:black;" href="<?= base_url("horario/editar/{$horario['id']}") ?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
