$.expr[':'].icontains = function (obj, index, meta, stack) {
    return (obj.textContent || obj.innerText || jQuery(obj).text() || '').toLowerCase().indexOf(meta[3].toLowerCase()) >= 0;
};
$(document).ready(function () {
    $("#input").click(function () {
        if ($('#buscador').attr('type') == 'hidden') {
            $('#buscador').prop('type', 'text');
        } else {
            $('#buscador').prop('type', 'hidden');
        }
    });
    $('#buscador').keyup(function () {
        buscar = $(this).val();
        $('.buscar').removeClass('resaltar');
        $('.buscara').removeClass('resaltar');
        if (jQuery.trim(buscar) != '') {
            $(".buscar:icontains('" + buscar + "')").addClass('resaltar');
            $(".buscara:icontains('" + buscar + "')").addClass('resaltar');
        }
    });
    $('[data-toggle*="tooltip"]').tooltip();


    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var materia = button.data('whatever');
        var horario = button.data('horario');
        var profesor = button.data('profesor');
        var aula = button.data('aula');
        var id = button.data('idclase');
        var comentario = button.data('comentario');
        var modal = $(this);
        modal.find('.modal-title').text(materia);
        $(".modal-text3").empty();
        $(".modal-text").empty();
        $(".modal-text2").empty();
        $(".modal-text4").empty();
        $("#clasemodal").remove();
        $("#idclase").remove();
        $("#agregarevento").remove();
        $("#cambiarhorario").remove();
        $(".strong").remove();
        $(".modal-text3").append("<strong class='strong'>Aula: </strong>" + aula);
        $(".modal-text").append("<strong class='strong'>Horario: </strong>" + horario);
        $(".modal-text2").append("<strong class='strong'>Profesor: </strong>" + profesor);
        $(".row.boton-comentario").append("  <button type='reset' id='cambiarhorario' title='Cambiar horario' class='btn btn-info btn-cambiar-horario col-md-offset-10' data-toggle='modal' data-target='#modalCambiarHorario'><i class='fa fa-pencil-square-o'></i></button>");
        $(".row.boton-comentario").append("  <input type='hidden' id='idclase' name='idclase' value='" + id + "'>");
        if (comentario != '') {
            $(".modal-text4").append("<strong class='strong'>Comentario: </strong>" + comentario);
        } else {
            $(".row.boton-comentario").append("  <input type='hidden' id='clasemodal' name='idclase' value='" + id + "'>");
          
            $(".row.boton-comentario").append("  <a id='agregarevento' title='Agregar comentario' class='btn btn-info btn-agregar-comentario' action='" + base_url + "clase/agregar_comentario_ajax" + "'><i class='fa fa-plus-square'></i></a>");
            $('#agregarevento').click(function (e) {
                e.preventDefault();
                var id = $("input[id='clasemodal']").val();
                var action = $('#agregarevento').attr("action");
                agregar_comentario(action, id);

            });
        }
    });
    function agregar_comentario(urlAction, id) {
        $('#exampleModal').modal('hide');
        swal({
            title: "¿Seguro que desea agregar un comentario?",
            text: "Escribe un comentario",
            type: "input",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false,
            animation: "slide-from-top"
        }, function (inputValue) {
            if (inputValue === false)
                return false;
            if (inputValue === "") {
                swal.showInputError("¡No agregaste ningún comentario!");
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: urlAction,
                    data: {
                        idclase: id,
                        comentarioclase: inputValue
                    },
                    success: function (msg) {
                        if (msg == 1) {
                            swal({
                                title: "¡Hecho!",
                                text: "Comentario agregado con exito!",
                                type: "success"
                            }, function (isConfirm) {
                                if (isConfirm)
                                    window.location.href = base_url + "planilla";
                            });
                        } else {
                            swal({
                                title: "¡Error!",
                                text: "Comentario no fue agregado!",
                                type: "error"
                            });
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("¡Error Detectado!",
                            "Por favor, vuelva a intentarlo en un momento.",
                            "error");
                    }
                });

            }
        });

    }

    $('#exampleModalEvento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var motivo = button.data('motivo');
        var horario = button.data('horario');
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-title-evento').text('Evento');
        $(".modal-text-evento").empty();
        $(".modal-text2-evento").empty();
        $(".strong").remove();
        $(".modal-text-evento").append("<strong class='strong'>Motivo: </strong>" + motivo);
        $(".modal-text2-evento").append("<strong class='strong'>Horario: </strong>" + horario);
        $(".btn.btn-danger.btn-delete-evento.col-md-offset-11").attr('id', id);
    });

    $('#ModalInsertarEvento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
    });

    $('#modalCambiarHorario').on('show.bs.modal', function (event) {
        $('#exampleModal').modal('hide');
        var id= $('#idclase').val();
        $(".row.cambiar-clase-horario").append("  <input type='hidden' id='claseid' name='claseid' value='" + id + "'>");
        var button = $(event.relatedTarget);
        var modal = $(this);
    });

    $('#exampleModalAula').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var aula = button.data('whatever');
        var capacidad = button.data('capacidad');
        var edificio = button.data('edificio');
        var modal = $(this);
        modal.find('.modal-title-aula').text(aula);
        $(".modal-text-aula").empty();
        $(".modal-text2-aula").empty();
        $(".strong").remove();
        $(".modal-text-aula").append("<strong class='strong'>Capacidad: </strong>" + capacidad);

        $(".modal-text2-aula").append("<strong class='strong'>Edificio: </strong>" + edificio);

    });
    $('#calendario').datepicker({
        language: "es",
        orientation: "bottom auto"
    });
    $('#calendario').datepicker().on('changeDate', function () {
        var calendario = $('#calendario').val();
        fecha = calendario.replace("/", "-");
        fecha = fecha.replace("/", "-");
        $.ajax({
            type: "POST",
            url: base_url + "planilla/calendario_ajax",
            data: {
                fecha: fecha,
                fecha_calendario: calendario
            },
            success: function (data) {
                $('div[id="contenido"]').remove();
                $('section[id="contect"]').append(data);
                $('section[id="contect"]').hide();
                $('section[id="contect"]').fadeIn(200);
                $('.datepicker').hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("¡Error Detectado!",
                    "Por favor, vuelva a intentarlo en un momento.",
                    "error");
            }
        });
    });
    for (i = 1; i < 25; i++) {
        $("#" + i).sticky({topSpacing: 0});
    }

    $("#horario").sticky({topSpacing: 0});

    function reload(fecha, operacion, calendario) {
        $.ajax({
            type: "POST",
            url: base_url + "planilla/horario_ajax",
            data: {
                fecha: fecha,
                operacion: operacion,
                calendario: calendario
            },
            success: function (data) {
                $('#contenido').remove();
                $('#contect').append(data);
                $('#contect').hide();
                $('#contect').fadeIn(200);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("¡Error Detectado!",
                    "Por favor, vuelva a intentarlo en un momento.",
                    "error");
            }
        });
    }

    $("#aulaevento").change(function () {
        $("#horainicioevento").val('');
        $("#horafinevento").val('');
        $("#horainicioevento").attr('readonly', false);
        $("#horafinevento").attr('readonly', false);
    });
    $("button[id='reload-sig']").click(function (e) {
        e.preventDefault();
        reload($('#fecha').val(), '+', $('#calendario').val());
    });
    $("button[id='reload-ant']").click(function (e) {
        e.preventDefault();
        reload($('#fecha').val(), '-', $('#calendario').val());
    });
    $("a[id='reload-hoy']").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: base_url + "planilla/cargar_ajax",
            success: function (data) {
                $('div[id="contenido"]').remove();
                $('section[id="contect"]').append(data);
                $('section[id="contect"]').hide();
                $('section[id="contect"]').fadeIn(200);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("¡Error Detectado!",
                    "Por favor, vuelva a intentarlo en un momento.",
                    "error");
            }
        });
    });
});

//Cambiar Horario
jQuery('#form-cambiar-horario').on(
    'submit',
    function (e) {
        var formData = $('#form-cambiar-horario').serialize();
        var formAction = $('#form-cambiar-horario').attr('action');
        $.ajax({
            type: "POST",
            url: formAction,
            data: formData,
            success: function (msg) {
                if (msg == '1') {
                    swal({
                        title: "¡Hecho!",
                        text: "Clase cambiada con éxito!",
                        type: "success"
                    }, function (isConfirm) {
                        if (isConfirm)
                            window.location.href = base_url + "planilla";
                    });
                } else {
                    swal({
                        title: "¡Error!",
                        text: "Clase no fue cambiada, verifique que el aula este disponible!",
                        type: "error"
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("¡Error Detectado!", "Por favor, intentelo de nuevo",
                    "error");
            }
        });
        e.preventDefault();
        return false;
    });
$("#idaula").change(function () {
    $("#horainicio").val('');
    $("#horafin").val('');
    $("#horainicio").attr('readonly', false);
    $("#horafin").attr('readonly', false);
});

//Alta Evento
jQuery('#form-evento').on(
    'submit',
    function (e) {
        var formData = $('#form-evento').serialize();
        var formAction = $('#form-evento').attr('action');
        $.ajax({
            type: "POST",
            url: formAction,
            data: formData,
            success: function (msg) {
                if (msg == 1) {
                    swal({
                        title: "¡Hecho!",
                        text: "Evento agregado con éxito!",
                        type: "success"
                    }, function (isConfirm) {
                        if (isConfirm)
                            window.location.href = base_url + "planilla";
                    });
                } else {
                    swal({
                        title: "¡Error!",
                        text: "Evento no fue agregado, verifique que el aula este disponible!",
                        type: "error"
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("¡Error Detectado!", "Por favor, intentelo de nuevo",
                    "error");
            }
        });
        e.preventDefault();
        return false;
    });

jQuery('.btn.btn-danger.btn-delete-evento.col-md-offset-11').click(
    function () {
        var id = $(this).attr('id');
        swal({
            title: "¿Seguro que desea eliminar el evento?",
            text: "No podrás deshacer esta acción",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: base_url + "evento/borrar",
                    data: {
                        id: id
                    },
                    success: function () {
                        swal({
                            title: "¡Hecho!",
                            text: "Evento eliminado con éxito!",
                            type: "success"
                        }, function (isConfirm) {
                            if (isConfirm)
                                window.location.href = base_url + "planilla";
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("¡Error Detectado!",
                            "Vuelva a intentarlo en un momento.",
                            "error");
                    }
                });
            } else {
                swal("Cancelado", "Tu archivo imaginario está a salvo :)",
                    "error");
            }
        });
    });