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
        tr {
            border: #7a2926 solid 2px;
        }

    </style>
</head>
<body>
<div id="toolbar-dia"></div>
<div id="grilla" style="width: 100%; display: table; ">
    <div style="display: table-row">
        <?php
        $w = floor(100 / (count($aulas) + 1));
        $hei = 80;
        $px_min = 1;
        $interval = DateInterval::createFromDateString("15 minutes");
        $horas = new DatePeriod(new DateTime("08:00:00"), $interval, new DateTime("21:00:00"));
        ?>

        <div style="width:<?php echo $w; ?>%; display: table-cell;">
            <table>
                <tr>
                    <th>
                        Horarios
                    </th>
                </tr>
                <?php
                foreach ($horas as $h) {
                    ?>
                    <tr style="height: <?php echo 15 * $px_min ?>px">
                        <td>
                            <?php echo $h->format("H:i"); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
        <?php
        foreach ($aulas as $aula) {
            ?>
            <div style="width:<?php echo $w; ?>%; display: table-cell;">
                <table style="position: relative;">
                    <tr style="position: absolute">
                        <th>
                            <?php echo $aula->nombre; ?>
                        </th>
                    </tr>
                    <?php
                    foreach ($clases as $clase) {
                        if ($clase->aula_id == $aula->id) {
                            $min_offset = (strtotime($clase->hora_inicio) - strtotime("08:00:00")) / 60 ;
                            $min_duracion = (strtotime($clase->hora_fin) - strtotime($clase->hora_inicio)) / 60;
                            ?>
                            <tr style="position: absolute; height: <?php echo $min_duracion * $px_min + $hei; ?>px; top:<?php echo $min_offset * $px_min +$hei;?>px; background: #CCFFCC">
                                <td><?php echo $clase->materia; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
