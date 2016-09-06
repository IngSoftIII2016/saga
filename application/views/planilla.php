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
	href="<?php echo base_url('assets/img/favicon.png') ?>">
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
<style type="text/css">
.color {
	background-color: <?php printf("#%06X\n", mt_rand(0, 0x222222)); ?>;
	border-style: hidden;
}

tr {
	border: 1px solid black;
	max-height: 5px !important;
	height: 5px !important;
	padding: 0px;
	margin: 0px;
}

td {
	height: 5px;
	border-color: black;
	border-style: solid;
	border-width: 1px;
	font-size: x-small;
	padding: 0px;
	margin: 0px;
}

.materia {
	background-color: coral;
	border-color: black;
	border-bottom-width: 2px;
	border-right-width: 2px;
	border-left-width: 2px;
	border-top-width: 2px;
}

p {
	margin: 0px;
}

.grilla {
	height: 25px;
	margin: 5px;
	padding: 5px;
	z-index: -30;
	display: table-caption;
}

h3 {
	margin-top: 6px;
}

.tabla {
	padding-right: 0px;
}

.color {
	background-color: lemonchiffon;
}

.content {
	background-color: #ecf0f5;
	height: 1000px;
}

.tabla th.clickable-row:hover {
	cursor: pointer;
}

#mycanvas {
	border: 1px solid red;
	background-color: red;
}


</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
	<section class="content" id="contect">
		<div class="col-md-12 tabla">

			<div class="row col-md-12 tabla">				
				<div class="row">
					<button type="reset" class="btn col-md-1 col-md-offset-4 btn-primary"
						onClick="window.location.assign('#')">Ant</button>
					<h3 class="text-center text-primary col-md-3"><?php
					$dias = array (
							"Domingo",
							"Lunes",
							"Martes",
							"Mi&eacute;rcoles",
							"Jueves",
							"Viernes",
							"S&aacute;bado" 
					);
					date_default_timezone_set ( "America/Argentina/Buenos_Aires" );
					echo $dias [date ( "w" )] . ' ' . date ( 'd/m/Y' );
					?></h3>
					<button type="reset" class="btn col-md-1 btn-primary"
						onClick="window.location.assign('#')">Sig</button>
						<div class="input-group col-md-2 buscar " style="float: right; ">
					<span class="input-group-addon " style="background-color: gren;">Buscar</span> <input id="filtrar"
						type="text" class="form-control">
				</div>
				</div>
				<div class="box">
					<table class="table table-bordered " id="worked">
						<thead>
							<tr>
								<th class="color" style="border: 1px solid black;">Horarios</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 1" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 1</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 2" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 2</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 3" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 3</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 4" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 4</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 5" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 5</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 6" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 6</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 7" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 7</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 8" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 8</th>
								<th data-toggle="modal" data-id="Aula 9" data-toggle="modal"
									data-target="#exampleModal" data-whatever="Aula 9"
									class="clickable-row color" title="Ver Detalle"
									style="border: 1px solid black;">Aula 9</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Aula 10" class="clickable-row color"
									title="Ver Detalle" style="border: 1px solid black;">Aula 10</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Lab 1" class="clickable-row color" title="Ver Detalle"
									style="border: 1px solid black;">Lab 1</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Lab 2" class="clickable-row color" title="Ver Detalle"
									style="border: 1px solid black;">Lab 2</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Lab 3" class="clickable-row color" title="Ver Detalle"
									style="border: 1px solid black;">Lab 3</th>
								<th data-toggle="modal" data-target="#exampleModal"
									data-whatever="Lab 4" class="clickable-row color" title="Ver Detalle"
									style="border: 1px solid black;">Lab 4</th>
							</tr>
						</thead>
						<tbody class="buscar">
				<?php
				$hora = 8;
				$min = 0;
				$cont = 1;
				
				for($i = 1; $i <= 28; $i ++) {
					?>
                    <tr>
                    <?php
					if ($i % 2 != 0) {
						?> 
                     <td class="color" rowspan="2"
									style="vertical-align: middle; font-size: small; border: 1px solid black;">
                         <?php
						if ($hora < 10) {
							echo 0 . $hora . ':' . $min . 0;
						} else {
							echo $hora . ':' . $min . 0;
						}
						?>  
						</td>
					<?php
						$hora ++;
					}
					
					for($j = 1; $j <= 14; $j ++) {
						if ($aulas [$j] ['horario'] [0] == $cont) {
							?>											
						 <td
									style="padding: 2px; margin: 0px; border: 1px solid black; height: 25px;"
									rowspan="<?php echo $aulas[$j]['horario'][3]?>">
									<?php echo $aulas[$j]['materia']. ' ' . $aulas[$j]['profesor']?></td>
					<?php
						}
					}
					$cont = $cont + 1;
					?>
					</tr>
					<?php
				}
				?>	                                  
                </tbody>

					</table>

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
								<div class="modal-body"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<script type="text/javascript">
$('#exampleModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget);
var aula = button.data('whatever');
var modal = $(this);
modal.find('.modal-title').text('Recursos del ' + aula );
});

$(document).ready(function () {
 
            (function ($) {
 
                $('#filtrar').keyup(function () {
 
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
 
                })
 
            }(jQuery));
 
        });


	</script>
	
	</section>

</body>
</html>
