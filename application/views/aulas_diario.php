<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Administración | Aulas</title>
<!-- Tell the browser to be responsive to screen width -->
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
<!-- Font Awesome -->
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet"
	href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/AdminLTE.min.css') ?>">
<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/skins/_all-skins.min.css') ?>">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/iCheck/all.css') ?>">

<!-- jvectormap -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>">

<!-- DataTables -->
<link rel="stylesheet"
	href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css') ?>">
<link rel="stylesheet"
	href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css" />

<!-- Sweet Alert Styles -->
<link
	href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css') ?>"
	rel="stylesheet">
<!-- end: CSS -->

<!-- start: Favicon -->
<link rel="shortcut icon"
	href="<?php echo base_url('assets/img/icon.png') ?>">
<!-- end: Favicon -->

<!-- jQuery 2.1.4 -->
<script
	src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script
	src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>">
</script>

<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/planilla.css') ?>">
<script type="text/javascript" >
	var base_url = "<?= base_url(); ?>"; // URL base, usada en buscador-and-modal.js
</script>
</head>
<body>
<section class="content" id="contect">
		<div class="col-md-12 tabla">				
				<input type="hidden" value="<?php echo $fecha->format('d-m-Y')?>" id="fecha"></input>
				<div class="row">
					<button type="reset" class="btn col-md-1 col-md-offset-3 btn-primary btn-ant">Ant</button>
					<h3 class="text-center text-primary col-md-3"><?=$fecha_formateada?></h3>
					<a href="<?php echo base_url("AulasController")?>"  data-toggle="tooltip" data-placement="bottom" title="Hoy"class="hoy">
					<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i></a>
					<button type="reset" class="btn col-md-1 btn-primary btn-sig">Sig</button>
					<div class="input-group col-md-2 buscar buscador">
					<i class="fa fa-search fa-2x" id="input" data-toggle="tooltip" title="Buscar" data-placement="bottom" aria-hidden="true" style=" float: right;"></i>
					<input id="buscador" type="hidden" class="col-md-10">						
					</div>
				</div>
				<div id="grilla" class="row col-md-12" style=" display: table;" >
					<div style="display: table-row">
						<?php
						$w = floor(100 / (count($aulas) + 1));
						$hei = 80;
						$px_min = 1;
						$interval = DateInterval::createFromDateString("30 minutes");
						$horas = new DatePeriod(new DateTime("08:00:00"), $interval, new DateTime("21:00:00"));
						?>

						<div style="width:auto; display: table-cell;">
							<div style="position: relative;">
								<div class="color" style="position: absolute; height: <?php echo $hei?>px">
									Horarios
								</div>
								<?php
								$offset = 0;
								foreach ($horas as $h) {
									?>
									<div  class="color" style="position: absolute; height: <?php echo 30 * $px_min?>px; top: <?php echo $offset * $px_min + $hei?>px">
										<?php echo $h->format("H:i"); ?>
									</div>
								<?php $offset += 30;} ?>
							</div>

						</div>
						<?php
						foreach ($aulas as $aula) {
							?>
							<div style="width:<?php echo $w; ?>%; display: table-cell;">
								<div style="position: relative;">
									<div class="color" style="position: absolute; height: <?php echo $hei;?>px">
										<?php echo $aula->nombre; ?>
									</div>
									<?php
									foreach ($clases as $clase) {
										if ($clase->aula_id == $aula->id) {
											$min_offset = (strtotime($clase->hora_inicio) - strtotime("08:00:00")) / 60;
											$min_duracion = (strtotime($clase->hora_fin) - strtotime($clase->hora_inicio)) / 60;
											?>

											<div class="materia buscar" style="position: absolute; height: <?php echo $min_duracion * $px_min; ?>px; top:<?php echo $min_offset * $px_min + $hei; ?>px">
												<?php echo $clase->materia . ' De ' . substr($clase->hora_inicio, 0,5) . ' a ' . substr($clase->hora_fin, 0,5)  ?>
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
				<script src="<?php echo base_url('assets/js/buscador-and-modal.js') ?>"></script>	
</section>
<script>

$(document).ready(function(){
 $(".btn.col-md-1.btn-primary.btn-sig").click(function(e){
	var url =  base_url + 'AulasController/horario';
   var form = $('<form action="' + url + '" method="post">' +
  '<input type="hidden" name="fecha" value="' + $('#fecha').val() + '" />' +
  '<input type="hidden" name="operacion" value="+" />' +
  '</form>');
	$('body').append(form);
	form.submit();   
  });
   $(".btn.col-md-1.col-md-offset-3.btn-primary.btn-ant").click(function(e){
	var url = base_url + 'AulasController/horario';
   var form = $('<form action="' + url + '" method="post">' +
  '<input type="hidden" name="fecha" value="' + $('#fecha').val() + '" />' +
  '<input type="hidden" name="operacion" value="-" />' +
  '</form>');
	$('body').append(form);
	form.submit();   
  });
  

});
</script>
</body>
</html>
