<nav class="navbar navbar-dark" style="background-color: #881300 !important;">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand header navclass" href="<?php echo base_url('planilla') ?>">SAGA</a>
        </div>


        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1"
             style="background-color: #881300 !important;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=base_url('horario')?>" class="header navclass" style=" font-size: medium;">Buscador</a>
                </li>
                <li class="dropdown" id="edificios">
                    <a href="#" class="dropdown-toggle header navclass" style=" font-size: medium;"
                       data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Edificio <span
                                class="caret"></span></a>

                </li>
			<?php	if ($this->ion_auth->is_admin()){ ?>
                <li class="dropdown" id="administrar">
                    <a href="#" class="dropdown-toggle header navclass" style=" font-size: medium;"
                       data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrar <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu menudesplegable">
                        <li><a href="<?php echo base_url('asignatura') ?>">Asignaturas</a></li>
                        <li><a href="<?php echo base_url('asignatura_carrera') ?>">Asignatura/Carreras</a></li>
                        <li><a href="<?php echo base_url('aula') ?>">Aulas</a></li>
                        <li><a href="<?php echo base_url('carrera') ?>">Carreras</a></li>
                        <li><a href="<?php echo base_url('comision') ?>">Comisiones</a></li>
                        <li><a href="<?php echo base_url('docente') ?>">Docentes</a></li>
                        <li><a href="<?php echo base_url('edificio') ?>">Edificios</a></li>
                        <li><a href="<?php echo base_url('evento') ?>">Eventos</a></li>
                        <li><a href="<?php echo base_url('periodo') ?>">Periodos</a></li>
                        <li><a href="<?php echo base_url('usuario') ?>">Usuarios</a></li>
                    </ul>
                </li>
			<?php	}?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle header navclass" style=" font-size: medium;"
                       data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Perfil <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu menudesplegable">
						<li><a href="#"> <?php echo $this->session->userdata('username');?></a></li>
                        <li><a href="<?php echo base_url('login/salir') ?>">Salir</a></li>

                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<script>
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: base_url + "edificio/get_edificios_ajax",
            success: function (data) {
                $('li[id="edificios"]').append(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("�Error Detectado!",
                        "Por favor, vuelva a intentarlo en un momento.",
                        "error");
            }
        });
    });
</script>