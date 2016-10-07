<div class="col-md-12 tabla" id="contenido">
			
			<input type="hidden" value="<?php echo $fecha->format('d-m-Y')?>" id="fecha"></input>				
				<div class="row">				
					<div class="col-md-3">
					<button type="reset" class="btn col-md-4 btn-primary btn-ant" data-toggle="modal" data-target="#modalInsertarEvento">Evento <i class="fa fa-plus-square" aria-hidden="true"></i></button>			
						<div class="input-group date" style="    padding-left: 20%;">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
									<input name="calendario" id="calendario"
											type='text' 
											readonly
											class="form-control validate"
											value="<?php if (isset($calendario)) echo $calendario ?>">
									</input>
						</div>
					</div>
					<button type="reset" id="reload-ant" class="btn col-md-1 btn-primary btn-ant" style="margin-left: 5%;">Ant</button>
					<h3 class="text-center text-primary col-md-3 "><?=$fecha_formateada?></h3>
					<a data-toggle="tooltip" data-placement="bottom" title="Hoy" class="hoy" id="reload-hoy">
						<i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>
					</a>
					<button type="reset" id="reload-sig" class="btn col-md-1 btn-primary btn-sig">Sig</button>
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
						$hei = 90;
						$px_min = 1;
						$interval = DateInterval::createFromDateString("30 minutes");
						$horas = new DatePeriod(new DateTime("08:00:00"), $interval, new DateTime("21:30:00"));
						?>						
						<div class="contenedor-horario">
							<div class="horario" style="position: relative;">
								<div class="color" id="horario" style="height: <?php echo $hei?>px">
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
													data-idclase="<?php echo $clase->clase_id ?>" 
													data-comentario="<?php echo $clase->comentario ?>"
													title="Ver Detalle"><?php echo $clase->materia . ' Profesor: ' . $clase->docente  ?>
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
													data-id="<?php echo $evento->id?>"
													title="Ver Detalle"><?php echo 'Motivo: ' . $evento->motivo ?>
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
								<p class="modal-text4 text-modal" id="exampleModalLabel">
								</p>
								<div class="row boton-comentario"></div>
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
								<a class="btn btn-danger btn-delete-evento col-md-offset-11"><i class="fa fa-trash-o"></i>
											</a>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="modal fade" id="modalInsertarEvento" tabindex="-1"
						role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<h3 class="modal-title-insert-evento" id="exampleModalLabel">Agregar Evento</h3>
								</div>
								<div class="modal-body">
								<form role="form" id="form-evento"
								action="<?php echo base_url('evento/agregar_evento'); ?>" method="POST">
								<div class="row">									
										<div class='form-group col-md-10'>
									      <select class="form-control" required id="aulaevento" name="aulaevento">
									      	<option value="" disabled selected>Seleccione Aula</option>
										  <?php
											foreach ($aulas as $aula) {
												echo "<option value=".$aula->id.">".$aula->nombre."</option>" ;
											} ?>
										  </select>	
									  	</div>
									<div class="form-group col-md-3">
										<label class="control-label">Hora Inicio</label> <input type="time"
												class="form-control" id="horainicioevento" name="horainicioevento" required max="20:00:00"
												min="08:00:00" readonly/>
									</div>
									<div class="form-group col-md-3">
										<label class="control-label">Hora Fin</label> <input type="time"
												class="form-control" id="horafinevento" name="horafinevento" required max="21:00:00"
												min="09:00:00" readonly/>
									</div>				
									<div class='form-group col-md-3'>
												<label class="control-label">Fecha</label>
													<input name="calendarioevento" id="calendarioevento"
															type='text' 
															readonly
															class="form-control validate"
															value="<?php if (isset($calendario)) echo $calendario ?>">
													</input>
									</div>									
									  <div class='form-group col-md-6'>
									      <label class="control-label">Motivo</label>
													<textarea class="form-control" required name="motivoevento" id="motivoevento"></textarea>
									  </div>
									  <div class="row">
									  	<div class="col-md-2 col-md-offset-9">
											<button id="btn-agregar" class="btn btn-success btn-lg pull-right addevento"
											type="submit">Agregar</button>
										</div>
										</div>
										</form>
								</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Sweet Alert Script -->
					<script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>
					<script src="<?php echo base_url('assets/js/buscador-and-modal.js') ?>"></script>
