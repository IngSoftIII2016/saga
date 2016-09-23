<?php $this->load->view ( 'header' );?>
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
											readonly
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
										if ($clase->aula_id == $aula->ubicacion) {
											$min_offset = (strtotime($clase->hora_inicio) - strtotime("08:00:00")) / 60;
											$min_duracion = (strtotime($clase->hora_fin) - strtotime($clase->hora_inicio)) / 60;
											
											?>
											<div class="materia buscar style-3" 
												style="position: absolute; height: <?php echo $min_duracion * $px_min; ?>px; top:<?php echo $min_offset * $px_min + $hei; ?>px">
												<a class="clickable-row materia-a buscara"  
													data-toggle="modal" data-target="#exampleModal"
													data-whatever="<?php echo $clase->materia ?>"
													data-horario= "<?php echo 'de ' . substr($clase->hora_inicio, 0,5) . ' a ' . substr($clase->hora_fin, 0,5) . ' hs' ?>" 
													data-profesor= "<?php echo $clase->docente?>" 
													data-aula="<?php echo $clase->aula?>" 
													title="Ver Detalle"><?php echo $clase->materia . ' Horario de ' . substr($clase->hora_inicio, 0,5) . ' a ' . substr($clase->hora_fin, 0,5) . ' Profesor: ' . $clase->docente  ?>
												</a>
											</div>
											<?php
										}
									}
									foreach ($eventos as $evento){
										if($evento->aula_id == $aula->ubicacion){
											$min_offset = (strtotime($evento->hora_inicio) - strtotime("08:00:00")) / 60;
											$min_duracion = (strtotime($evento->hora_fin) - strtotime($evento->hora_inicio)) / 60;
												
											?>
											<div class="evento buscar style-3" 
												style="position: absolute; height: <?php echo $min_duracion * $px_min; ?>px; top:<?php echo $min_offset * $px_min + $hei; ?>px">
												<a class="clickable-row materia-a buscara"  
													data-toggle="modal" data-target="#exampleModalEvento"
													data-horario= "<?php echo 'de ' . substr($evento->hora_inicio, 0,5) . ' a ' . substr($evento->hora_fin, 0,5) . ' hs' ?>" 
													data-motivo= "<?php echo $evento->motivo?>" 
													title="Ver Detalle"><?php echo 'Motivo: ' . $evento->motivo. ' Horario de ' . substr($evento->hora_inicio, 0,5) . ' a ' . substr($evento->hora_fin, 0,5) ?>
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
								<p class="modal-text3 text-modal" id="exampleModalLabel">
								</p>
								<p class="modal-text text-modal" id="exampleModalLabel" >
								</p>
								<p class="modal-text2 text-modal" id="exampleModalLabel">
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
					<div class="modal fade" id="exampleModalEvento" tabindex="-1"
						role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h3 class="modal-title-evento" id="exampleModalLabel"></h3>
								</div>
								<div class="modal-body">
								<p class="modal-text-evento text-modal"  id="exampleModalLabel">
								</p>
								<p class="modal-text2-evento text-modal" id="exampleModalLabel">
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
var profesor = button.data('profesor');
var aula = button.data('aula');
var modal = $(this);
modal.find('.modal-title').text( materia );
$( ".modal-text3" ).empty();
$( ".modal-text" ).empty();
$( ".modal-text2" ).empty();
$( ".strong" ).remove();
$( ".modal-text3" ).append( "<strong class='strong'>Aula: </strong>" + aula );
$( ".modal-text" ).append( "<strong class='strong'>Horario: </strong>" + horario);
$( ".modal-text2" ).append( "<strong class='strong'>Profesor: </strong>" + profesor );
});
$('#exampleModalEvento').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var motivo = button.data('motivo');
	var horario = button.data('horario');
	var modal = $(this);
	modal.find('.modal-title-evento').text( 'Evento' );
	$( ".modal-text-evento" ).empty();
	$( ".modal-text2-evento" ).empty();
	$( ".strong" ).remove();
	$( ".modal-text-evento" ).append( "<strong class='strong'>Motivo: </strong>" + motivo);
	$( ".modal-text2-evento" ).append( "<strong class='strong'>Horario: </strong>" + horario );
	});
$('#exampleModalAula').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var aula = button.data('whatever');
var capacidad = button.data('capacidad');
var edificio = button.data('edificio');
var modal = $(this);
modal.find('.modal-title-aula').text( aula );
$( ".modal-text-aula" ).empty();
$( ".modal-text2-aula" ).empty();
$( ".strong" ).remove();
$( ".modal-text-aula" ).append( "<strong class='strong'>Capacidad: </strong>"  + capacidad);

$( ".modal-text2-aula" ).append( "<strong class='strong'>Edificio: </strong>" + edificio );

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
