
$.expr[':'].icontains = function(obj, index, meta, stack){
	return (obj.textContent || obj.innerText || jQuery(obj).text() || '').toLowerCase().indexOf(meta[3].toLowerCase()) >= 0;
};
$(document).ready(function(){
		$( "#input" ).click(function() {
			if($('#buscador').attr('type') == 'hidden'){
			 $('#buscador').prop('type', 'text');
			}else {
				$('#buscador').prop('type', 'hidden');
			}
	});
	$('#buscador').keyup(function(){
				 buscar = $(this).val();
				 $('.buscar').removeClass('resaltar');
				 $('.buscara').removeClass('resaltar');
						if(jQuery.trim(buscar) != ''){
						   $(".buscar:icontains('" + buscar + "')").addClass('resaltar');
						    $(".buscara:icontains('" + buscar + "')").addClass('resaltar');
						}
		});
		$(document).ready(function(){
    $('[data-toggle*="tooltip"]').tooltip(); 
});

		
});
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
	$('#calendario').datepicker({
				language : "es",
				orientation : "bottom auto"
			});
	$('#calendario').datepicker().on('changeDate', function() {	
		var calendario=$('#calendario').val();
		fecha = calendario.replace("/", "-");
		fecha = fecha.replace("/", "-");
		$.ajax({
			type : "POST",
			url : base_url + "planilla/calendario_ajax",
			data : {
				fecha : fecha,
				fecha_calendario : calendario					
			},
			success : function(data) {
				$('div[id="contenido"]').remove();
				$('section[id="contect"]').append(data);
				$('section[id="contect"]').hide();
				$('section[id="contect"]').fadeIn(200);
				$('.datepicker').hide();
				},
			error : function(xhr, ajaxOptions, thrownError) {
				swal("¡Error Detectado!",
						"Por favor, vuelva a intentarlo en un momento.",
						"error");
			}
		});
		});

		function reload(fecha,operacion,calendario){
				$.ajax({
					type : "POST",
					url : base_url + "planilla/horario_ajax",
					data : {
						fecha : fecha,
						operacion : operacion,
						calendario : calendario
					},
					success : function(data) {
						$('div[id="contenido"]').remove();
						$('section[id="contect"]').append(data);
						$('section[id="contect"]').hide();
						$('section[id="contect"]').fadeIn(200);
						},
					error : function(xhr, ajaxOptions, thrownError) {
						swal("¡Error Detectado!",
								"Por favor, vuelva a intentarlo en un momento.",
								"error");
					}
				});
			}

		$("button[id='reload-sig']").click(function(e){
			e.preventDefault();
			reload($('#fecha').val(), '+',$('#calendario').val());		
			});
		$("button[id='reload-ant']").click(function(e){
			e.preventDefault();
			reload($('#fecha').val(), '-',$('#calendario').val());	
			});
		$("a[id='reload-hoy']").click(function(e){
			e.preventDefault();
			$.ajax({
				type : "POST",
				url : base_url + "planilla/cargar_ajax",
				success : function(data) {
					$('div[id="contenido"]').remove();
					$('section[id="contect"]').append(data);
					$('section[id="contect"]').hide();
					$('section[id="contect"]').fadeIn(200);
					},
				error : function(xhr, ajaxOptions, thrownError) {
					swal("¡Error Detectado!",
							"Por favor, vuelva a intentarlo en un momento.",
							"error");
				}
			});		
			});
