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
<script
	src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>">
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript"
	src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script
	src="<?php echo base_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js'); ?>">
</script>
<script
	src="<?php echo base_url('assets/js/jquery.sticky.js'); ?>">
</script>

<script
	src="<?php echo base_url('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.js'); ?>"
	charset="UTF-8"></script>
<link rel="stylesheet"
	href="<?php echo base_url('assets/css/planilla.css') ?>">
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('assets/plugins/bootstrap-datepicker/css/datepicker.css'); ?>" />

<script type="text/javascript" >
	var base_url = "<?= base_url(); ?>"; // URL base, usada en buscador-and-modal.js
</script>
</head>
<body>
<section class="content" id="contect">
		<div class="col-md-12 tabla">				
				<input type="hidden" value="<?php echo $fecha->format('d-m-Y')?>" id="fecha"></input>				
				<div class="row">				
					<div class="col-md-2 col-md-offset-1">
						<div class='input-group date'>
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
									<input name="calendario" id="calendario"
											type='text' 
											class="form-control validate"
											value="<?php if (isset($calendario)) echo $calendario; ?>">
											</input>
						</div>
					</div>
					<button type="reset" class="btn col-md-1 btn-primary btn-ant">Ant</button>
					<h3 class="text-center text-primary col-md-3 "><?=$fecha_formateada?></h3>
					<a href="<?php echo base_url("planilla")?>"  data-toggle="tooltip" data-placement="bottom" title="Hoy" class="hoy">
						<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>
					</a>
					<button type="reset" class="btn col-md-1 btn-primary btn-sig">Sig</button>
					<div class="input-group col-md-2 buscar buscador">
						<i class="fa fa-search fa-2x icon-buscar" id="input" 
							data-toggle="tooltip" title="Buscar" 
							data-placement="bottom" aria-hidden="true" 
							style=" float: right;">
						</i>
						<input id="buscador" type="hidden" class="col-md-9">						
					</div>
				</div>				
				<div id="grilla" class="row col-md-12 grilla">
					<div class="contenedor">
						<?php
						$w = 100 / (count($aulas) + 1);
						$hei = 80;
						$px_min = 1;
						$interval = DateInterval::createFromDateString("30 minutes");
						$horas = new DatePeriod(new DateTime("08:00:00"), $interval, new DateTime("21:30:00"));
						?>						
						<div class="contenedor-horario">
							<div class="horario">
								<div class="color" style="height: <?php echo $hei?>px">
									Horarios
								</div>
								<?php
								$offset = 0;
								foreach ($horas as $h) {
									?>
									<div  class="color hora" 
										style="height: <?php echo 30 * $px_min?>px; top: <?php echo $offset * $px_min + $hei?>px">
										<?php echo $h->format("H:i"); ?>
									</div>
								<?php $offset += 30;} ?>
							</div>
						</div>
						<?php						
						foreach ($aulas as $aula) {
							?>
							<div style="width:<?php echo $w; ?>%; display: table-cell;" >
								<div style="position: relative;">
									<div class="color clickable-row" id="<?php echo $aula->id?>"
									data-toggle="modal" data-target="#exampleModalAula"
											data-whatever="<?php echo $aula->nombre; ?>"
											data-capacidad="<?php echo $aula->capacidad; ?>"
											data-edificio="<?php echo $aula->edificio; ?>"
									style="position:absolute; height: <?php echo $hei;?>px">
										<a><?php echo $aula->nombre; ?></a>
									</div>
									<?php
									foreach ($clases as $clase) {
										if ($clase->aula_id == $aula->id) {
											$min_offset = (strtotime($clase->hora_inicio) - strtotime("08:00:00")) / 60;
											$min_duracion = (strtotime($clase->hora_fin) - strtotime($clase->hora_inicio)) / 60;
											
											?>
											<div class="materia buscar" id="style-3"
												style="position: absolute; height: <?php echo $min_duracion * $px_min; ?>px; top:<?php echo $min_offset * $px_min + $hei; ?>px">
												<a class="clickable-row materia-a buscara"  
													data-toggle="modal" data-target="#exampleModal"
													data-whatever="<?php echo $clase->materia ?>"
													data-horario= "<?php echo 'Horario de ' . substr($clase->hora_inicio, 0,5) . ' a ' . substr($clase->hora_fin, 0,5) ?>" 
													title="Ver Detalle"><?php echo $clase->materia . ' De ' . substr($clase->hora_inicio, 0,5) . ' a ' . substr($clase->hora_fin, 0,5) . ' Profesor: ' . $clase->docente  ?>
												</a>
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
				<div class="modal fade" id="exampleModal" tabindex="-1"
						role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h3 class="modal-title" id="exampleModalLabel"></h3>
								</div>
								<div class="modal-body">
								<p class="modal-text text-modal" id="exampleModalLabel" >
								</p>
								</div>
							</div>
						</div>
					</div>
					<div class="modal fade" id="exampleModalAula" tabindex="-1"
						role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h3 class="modal-title-aula" id="exampleModalLabel"></h3>
								</div>
								<div class="modal-body">
								<p class="modal-text-aula text-modal"  id="exampleModalLabel">
								</p>
								<p class="modal-text2-aula text-modal" id="exampleModalLabel">
								</p>
								</div>
							</div>
						</div>
					</div>
				<script src="<?php echo base_url('assets/js/buscador-and-modal.js') ?>"></script>
</section>
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var materia = button.data('whatever');
var horario = button.data('horario');
var modal = $(this);
modal.find('.modal-title').text( materia );
modal.find('.modal-text').text( horario );
});
$('#exampleModalAula').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var aula = button.data('whatever');
var capacidad = button.data('capacidad');
var edificio = button.data('edificio');
var modal = $(this);
modal.find('.modal-title-aula').text( aula );
modal.find('.modal-text-aula').text( 'Capacidad: ' + capacidad );  
modal.find('.modal-text2-aula').text( 'Edificio: ' + edificio );
});
$(document).ready(function(){
 $(".btn.col-md-1.btn-primary.btn-sig").click(function(e){
	var url =  base_url + 'planilla/horario';
   var form = $('<form action="' + url + '" method="post">' +
  '<input type="hidden" name="fecha" value="' + $('#fecha').val() + '" />' +
  '<input type="hidden" name="operacion" value="+" />' +
  '</form>');
	$('body').append(form);
	form.submit();   
  });
   $(".btn.col-md-1.btn-primary.btn-ant").click(function(e){
	var url = base_url + 'planilla/horario';
   var form = $('<form action="' + url + '" method="post">' +
  '<input type="hidden" name="fecha" value="' + $('#fecha').val() + '" />' +
  '<input type="hidden" name="operacion" value="-" />' +
  '</form>');
	$('body').append(form);
	form.submit();   
  });
  for (i = 1; i < 25; i++) { 
    $("#" + i ).sticky({topSpacing:0});
  }
  
});
	$('#calendario').datepicker({
			language : "es",
			orientation : "bottom auto"
		});
	$('#calendario').datepicker().on('changeDate', function() {
		var url = base_url + 'planilla/calendario';
		var calendario=$('#calendario').val();
		valor = calendario.replace("/", "-");
		valor = valor.replace("/", "-");
		var form = $('<form action="' + url + '" method="post">' +
		'<input type="hidden" name="fecha" value="' + valor + '" />' +
		'<input type="hidden" name="fecha_calendario" value="' + calendario + '" />' +
		'</form>');
	$('body').append(form);
	form.submit();
	});
   
</script>
</body>
</html>
