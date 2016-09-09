<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administración de Aulas</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
            name="viewport">
    <style type="text/css">
        .materia {
            border: #7a2926 solid 2px;
            background: #CCFFCC;
        }
        .celdas {
            border: #000000 solid 1px;
        }
        div {
            font-size: 0.7rem;
        }

    </style>
</head>
<body>
<div id="toolbar-dia"></div>
<div id="grilla" style="width: 100%; display: table; ">
    <div style="display: table-row">
        <?php
        $w = floor(100 / (count($aulas) + 1));
        $hei = 40;
        $px_min = 1;
        $interval = DateInterval::createFromDateString("15 minutes");
        $horas = new DatePeriod(new DateTime("08:00:00"), $interval, new DateTime("21:00:00"));
        ?>

        <div style="width:auto; display: table-cell;">
            <div style="position: relative;">
                <div style="position: absolute; height: <?php echo $hei?>px">
                    Horarios
                </div>
                <?php
                $offset = 0;
                foreach ($horas as $h) {
                    ?>
                    <div style="position: absolute; height: <?php echo 15 * $px_min?>px; top: <?php echo $offset * $px_min + $hei?>px">
                        <?php echo $h->format("H:i"); ?>
                    </div>
                <?php $offset += 15;} ?>
            </div>

        </div>
        <?php
        foreach ($aulas as $aula) {
            ?>
            <div style="width:<?php echo $w; ?>%; display: table-cell;">
                <div style="position: relative;">
                    <div style="position: absolute; height: 40px">
                        <?php echo $aula->nombre; ?>
                    </div>
                    <?php
                    foreach ($clases as $clase) {
                        if ($clase->aula_id == $aula->id) {
                            $min_offset = (strtotime($clase->hora_inicio) - strtotime("08:00:00")) / 60;
                            $min_duracion = (strtotime($clase->hora_fin) - strtotime($clase->hora_inicio)) / 60;
                            ?>

                            <div class="materia" style="position: absolute; height: <?php echo $min_duracion * $px_min; ?>px; top:<?php echo $min_offset * $px_min + 40; ?>px">
                                <?php echo $clase->materia; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
