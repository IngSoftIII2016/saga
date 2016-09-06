/**
 * Script para manejar las pesañas de los componentes de la orden de publicidad
 * y gestionar las fechas de los mismos
 */

var fechaInicioOP; // Variable global para la fecha de inicio de la Orden de
// publicidad
var fechaFinOP; // Variable global para la fecha de fin de la Orden de
// publicidad
var fechaInicioOPWeb;
var fechaInicioOPRadio;
var fechaInicioOPMedios;

var montoTotal = 0;
var couta = 0;

Date.dateDiff = function(datepart, fromdate, todate) {
	datepart = datepart.toLowerCase();
	var diff = todate - fromdate;
	var divideBy = {
		m : 2628000000,
		w : 604800000,
		d : 86400000,
		h : 3600000,
		n : 60000,
		s : 1000
	};

	return Math.floor(diff / divideBy[datepart]);
}

function calcularCantidadDias(fechaInicio, fechaFin) {

	finArray = fechaFin.split("/");
	inicioArray = fechaInicio.split("/");

	dateDiff = Date.dateDiff("d", new Date(inicioArray[2], inicioArray[1],
			inicioArray[0]), new Date(finArray[2], finArray[1], finArray[0]));
	return dateDiff;
}

function calcularCantidadMeses(fechaInicio, fechaFin) {

	finArray = fechaFin.split("/");
	inicioArray = fechaInicio.split("/");

	dateDiff = Date.dateDiff("m", new Date(inicioArray[2], inicioArray[1]),
			new Date(finArray[2], finArray[1]));
	return dateDiff;
}

function habilitarCoutas(valor) {
	if (valor == "proporcional") {
		$(".box-coutas").find('input[name*="mes-"]').attr("readonly", true);
	} else {
		$(".box-coutas").find('input[name*="mes-"]').attr("readonly", false);
	}

}

function modificarCouta() {

	var arrayCoutas = $('input[name*="mes-"]').toArray();
	var total = 0;
	for (i = 0; i < arrayCoutas.length; i++) {
		total += parseFloat(arrayCoutas[i].value);

	}
	var diferencia = (montoTotal - total).toFixed(2);

	if (diferencia > 0) {
		$('input[name="monto-final-sumado"]').val(total);
		$('input[name="monto-final-sumado"]').removeAttr("class");
		$('input[name="monto-final-sumado"]').hide(0);
		$('input[name="monto-final-sumado"]').attr("class",
				"form-control monto-final-error");
		$('input[name="monto-final-sumado"]').show(0);
		$("#error-suma").text(
				"Faltan " + diferencia + " para llegar al monto total.");

	} else if (diferencia < 0) {
		$('input[name="monto-final-sumado"]').val(total);
		$('input[name="monto-final-sumado"]').removeAttr("class");
		$('input[name="monto-final-sumado"]').hide(0);
		$('input[name="monto-final-sumado"]').attr("class",
				"form-control monto-final-error");
		$('input[name="monto-final-sumado"]').show(0);

		$("#error-suma").text("Monto superado por " + diferencia * (-1));

	} else {
		$('input[name="monto-final-sumado"]').val(total);
		$('input[name="monto-final-sumado"]').removeAttr("class");
		$('input[name="monto-final-sumado"]').hide(0);
		$('input[name="monto-final-sumado"]').attr("class",
				"form-control monto-final-success");
		$('input[name="monto-final-sumado"]').show(0);
		$("#error-suma").text("");
	}
}

function reset() {
	if ( $( "select[name='forma-pago']").val() == "Mes Vencido" ) {
		$(".box-coutas").find('[id*="mes-"]').remove(); // Elimimno los inputs
		// de cada cuota.
		$("#plan-pago").hide(500);
		$("select[name='forma-pago']").val("Contado");
		var hoy = new Date();
		dia = hoy.getDate(); 
		mes = hoy.getMonth() + 1;
		anio= hoy.getFullYear();
		fecha_actual = String(dia+"/"+mes+"/"+anio);
		$("input[name='fechaFactura']").val( fecha_actual );
	}
}

$("#plan-pago").toggle();
function formaPagoChange() {
	var forma_pago = $("select[name='forma-pago']").val();
	var hoy = new Date();
	dia = hoy.getDate(); 
	mes = hoy.getMonth() + 1;
	anio= hoy.getFullYear();
	fecha_actual = String(dia+"/"+mes+"/"+anio);
	switch (forma_pago) {
	case "Contado":
		dia = fecha_actual;
		$("#plan-pago").hide(500);
		break;
	case "Fin Pauta":
		dia = fechaFinOP;
		$("#plan-pago").hide(500);
		break;
	case "Mes Vencido":
		$(".box-coutas").find('[id*="mes-"]').remove(); // Elimimno los inputs
		// de cada cuota.
		$("#plan-pago").show(500);
		montoTotal = $('input[name="total-forma-pago"]').val(); // Recupero el
		// monto total
		// de la OP
		$('input[name="monto-final-sumado"]').val(montoTotal);
		var diffDias = calcularCantidadDias($('input[name="start"]').val(), $(
				'input[name="end"]').val()); // Calculo la direfencia de
		// dias
		// entre el inicio y el fin de la OP
		if (diffDias <= 30) { // Si es menos de un mes
			cuota = montoTotal; // Calculo el valor de la cuota
			$(".box-coutas").append(
					'<input type="hidden" name="cantidad-cuotas" value=' + 1
							+ ' >')
			var fin = $('input[name="end"]').val().split("/");
			fin = new Date(fin[2], fin[1] - 1, fin[0]);
			var dd = fin.getDate();
			var mm = fin.getMonth() + 1;
			var y = fin.getFullYear();
			dia = dd + '/' + mm + '/' + y;
			$(".box-coutas")
					.append(
							'<div class="form-group col-md-4" id="mes-'
									+ 1
									+ '">'
									+ '<label class="control-label">Vence: '
									+ dd
									+ '-'
									+ mm
									+ '-'
									+ y
									+ '</label>'
									+ '<div class="input-group"> <span class="input-group-addon precio">$</span> <input type="hidden" name="fecha-'
									+ +0 + '" value="' + dd + '-' + mm + '-'
									+ y + '">'
									+ '<input type="text" class="form-control"'
									+ 'name="mes-' + 0 + '" value="' + Math.round(cuota)
									+ '" readonly onChange="modificarCouta()">'
									+ '</div> </div>');
		} else {
			cantidadPago = Math.floor(diffDias / 30); //Calculo la cant de cuotas
			restoDias = diffDias % 30; //Calculo los dias sobrantes
			var inicioCoutas = $('input[name="start"]').val().split("/");
			inicioCoutas = new Date(inicioCoutas[2], inicioCoutas[1] - 1, inicioCoutas[0]);
			
			if (restoDias > 20) {
				cantidadPago = cantidadPago + 1;
			} 
			
			cuota = montoTotal / (cantidadPago); // Calculo el valor de
			// una couta
			$(".box-coutas").append(
					'<input type="hidden" name="cantidad-cuotas" value='
							+ cantidadPago + ' >');
			
			for (i = 0; i < cantidadPago; i++) {
				inicioCoutas.setDate(inicioCoutas.getDate() + 30);
				var dd = inicioCoutas.getDate();
				var mm = inicioCoutas.getMonth() + 1;
				var y = inicioCoutas.getFullYear();
				if (i == 0)
					dia = dd + '/' + mm + '/' + y;
				$(".box-coutas")
						.append(
								'<div class="form-group col-md-4" id="mes-'
										+ i
										+ '">'
										+ '<label class="control-label">Vence: '
										+ dd
										+ '-'
										+ mm
										+ '-'
										+ y
										+ '</label>'
										+ '<input type="hidden" name="fecha-'
										+ +i
										+ '" value="'
										+ dd
										+ '-'
										+ mm
										+ '-'
										+ y
										+ '">'
										+ '<div class="input-group"> <span class="input-group-addon precio">$</span><input type="text" class="form-control"'
										+ 'name="mes-'
										+ i
										+ '" value="'
										+ Math.round(cuota)
										+ '" readonly onChange="modificarCouta()">'
										+ '</div></div>');
			}
			
		}
		break;
	default:
		$("#plan-pago").hide(500);
	}
	document.getElementById("fechaFactura").value = dia;
	
}

/**
 * Crea los calendarios correspondientes para el formulario, indicando como
 * fechas validas las que se encuentran entre INICIO y FIN.
 * 
 * @param fin =
 *            fecha de fin del intervalo
 * @param inicio =
 *            inicio del intervalo
 */
function crearCalendarios(fin, inicio) {

	fechaInicioOP = inicio;
	fechaFinOP = fin;

	fechaInicioOPWeb = inicio;
	fechaInicioOPRadio = inicio;
	fechaInicioOPMedios = inicio;
	fechaInicioOPDate = inicio;

	$('#fecha-inicio-papel').val('');
	$('#fecha-inicio-papel').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOP,
		endDate : fechaFinOP,
		multidate : true
	});

	$('#fecha-inicio-web').val('');
	$('#fecha-inicio-web').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOP,
		endDate : fechaFinOP
	});
	
	$('#fecha-fin-web').val('');
	$('#fecha-fin-web').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOPWeb,
		endDate : fechaFinOP
	});
	
	$('#fecha-inicio-radio').val('');
	$('#fecha-inicio-radio').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOP,
		endDate : fechaFinOP
	});
	
	$('#fecha-fin-radio').val('');
	$('#fecha-fin-radio').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOPRadio,
		endDate : fechaFinOP
	});

	$('#fecha-inicio-medios').val('');
	$('#fecha-inicio-medios').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOP,
		endDate : fechaFinOP
	});
	
	$('#fecha-fin-medios').val('');
	$('#fecha-fin-medios').datepicker({
		language : "es",
		orientation : "bottom auto",
		startDate : fechaInicioOPMedios,
		endDate : fechaFinOP
	});

}

/**
 * Destruye los calendarios que contengan como ID la siguientes cadenas
 * "fecha-inicio-" y "fecha-fin-"
 */
function destruirCalendarios() {
	$('input[id*="fecha-inicio-"]').datepicker('destroy');
	$('input[id*="fecha-fin-"]').datepicker('destroy');
}

$(function() {
	$('input[id*="checkbox-"]').click(
			function() {
				var tab = $(this).val();
				if ($(this).is(':checked')) {
					$('a[href="' + tab + '"]').attr("data-toggle", "tab");
					$('a[href="' + tab + '"]').parent("li").attr("class", "");

					switch ($(this).val()) {

					case "#papel":
						$("#papel").find("[id*='-papel']").attr('disabled',
								false);
						break;
					case "#web":
						$("#web").find("[id*='-web']").attr('disabled', false);
						break;
					case "#radio":
						$("#radio").find("[id*='-radio']").attr('disabled',
								false);
						break;
					case "#medios":
						$("#medios").find("[id*='-medios']").attr('disabled',
								false);
						break;
					}
				} else {
					$('a[href="' + tab + '"]').removeAttr("data-toggle");
					$('a[href="' + tab + '"]').parent("li").attr("class",
							"disabled-tab");

					switch ($(this).val()) {

					case "#papel":
						$("#papel").find("[id*='-papel']").attr('disabled',
								true);
						break;
					case "#web":
						$("#web").find("[id*='-web']").attr('disabled', true);
						break;
					case "#radio":
						$("#radio").find("[id*='-radio']").attr('disabled',
								true);
						break;
					case "#medios":
						$("#medios").find("[id*='-medios']").attr('disabled',
								true);
						break;
					}

				}

			});

});

var rangeOP = $('.input-daterange').datepicker({
	startDate : new Date(),
	language : "es",
	orientation : "bottom auto"
});

$('input[name="end"]').change(function() {
	var inicio = $('input[name="start"]').val();
	var fin = $(this).val();
	destruirCalendarios();
	crearCalendarios(fin, inicio);

});

$('input[name="start"]').change(function() {
	var inicio = $(this).val(); 
	var fin = $('input[name="end"]').val();;
	destruirCalendarios();
	crearCalendarios(fin, inicio);

});

// Operaciones sobre las fechas para la pauta web
$('#fecha-inicio-web').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-fin-web').val() != '') {
				$('input[name="cant-dias-web"]').val(
						calcularCantidadDias($('#fecha-inicio-web').val(), $(
								'#fecha-fin-web').val()));
			}
			$('#fecha-fin-web').datepicker('setStartDate', $(this).val());
		});

$('#fecha-fin-web').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-inicio-web').val() != '') {
				$('input[name="cant-dias-web"]').val(
						calcularCantidadDias($('#fecha-inicio-web').val(), $(
								'#fecha-fin-web').val()));
			}
		});
// ¨**FIN** Operaciones para la puta wb

// Operaciones sobre las fechas para la pauta en radio
$('#fecha-inicio-radio').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-fin-radio').val() != '') {
				$('input[name="cant-dias-radio"]').val(
						calcularCantidadDias($('#fecha-inicio-radio').val(), $(
								'#fecha-fin-radio').val()));
			}
			$('#fecha-fin-radio').datepicker('setStartDate', $(this).val());
		});

$('#fecha-fin-radio').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-inicio-radio').val() != '') {
				$('input[name="cant-dias-radio"]').val(
						calcularCantidadDias($('#fecha-inicio-radio').val(), $(
								'#fecha-fin-radio').val()));
			}
		});
// **FIN** Operaciones para la pauta en radio

// Operaciones sobre las fechas para la pauta en medios variados
$('#fecha-inicio-medios').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-fin-medios').val() != '') {
				$('input[name="cant-dias-medios"]').val(
						calcularCantidadDias($('#fecha-inicio-medios').val(),
								$('#fecha-fin-medios').val()));
			}
			$('#fecha-fin-medios').datepicker('setStartDate', $(this).val());
		});

$('#fecha-fin-medios').datepicker().on(
		'changeDate',
		function() {
			if ($('#fecha-inicio-medios').val() != '') {
				$('input[name="cant-dias-medios"]').val(
						calcularCantidadDias($('#fecha-inicio-medios').val(),
								$('#fecha-fin-medios').val()));
			}
		});
// **FIN** Operaciones para la pauta en medios variados

// Operaciones sobre las fechas para la pauta en papel
$('#fecha-inicio-papel').datepicker().on('changeDate', function() {
	$('input[name="cant-dias-papel"]').val($(this).val().split(",").length);
});
// **FIN** Operaciones sobre las fechas para la pauta en papel


