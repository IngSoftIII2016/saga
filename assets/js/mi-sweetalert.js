jQuery('.btn.btn-success.btn-reset-usuario').click(
		function() {
			var id = $(this).attr('name');
			var username = $(this).attr('username');
			swal({
				title : "¿Seguro que desea restablecer la contraseña a " + username
						+ "?",
				text : "No podrás deshacer esta acción",
				type : "warning",
				showCancelButton : true,
				cancelButtonText : "Cancelar",
				confirmButtonColor : "#DD6B55",
				confirmButtonText : "Aceptar",
				closeOnConfirm : false
			}, function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						type : "POST",
						url : "http://localhost/AdminEx/usuario/reset_password",
						data : {
							id : id,
							username : username
						},
						success : function() {
							swal({
								title : "¡Hecho!",
								text : "Contraseña restablecida con éxito!",
								type : "success"
							},function(isConfirm) {
								if (isConfirm)
									window.location.href = "http://localhost/AdminEx/usuario";
								});
						},
						error : function(xhr, ajaxOptions, thrownError) {
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

//----------------------------//
//--- Usuario ---------------//
//----------------------------//
//----- Borrar usuario -------//
jQuery('.btn.btn-danger.btn-delete-usuario')
		.click(
				function() {
					var id = $(this).attr('id');
					var nombre = $(this).attr('nombre');
					var apellido = $(this).attr('apellido');
					swal(
							{
								title : "¿Seguro que deseas eliminar el usuario " + nombre + " " + apellido +"?",
								text : "",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/usuario/baja",
												data : {
													id : id
												},
												success : function() {
													swal(
															{
																title : "Hecho!",
																text : "Usuario borrado con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/usuario";
															});
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Vuelvo a intentarlo en un momento.",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo",
											"error");
								}
							});
				});
// Alta o modificacion
jQuery('#form-usuario')
		.on(
				'submit',
				function(e) {
					var formData = $('#form-usuario').serialize();
					var formAction = $('#form-usuario').attr('action');
					$
							.ajax({
								type : "POST",
								url : formAction,
								data : formData,
								success : function(msg) {
									if (msg == '1') {
										swal(
												{
													title : "Hecho!",
													text : "Usuario cargado con exito",
													type : "success"
												},
												function(isConfirm) {
													if (isConfirm)
														window.location.href = "http://localhost/AdminEx/usuario";
												});
									} else {
										$('#pass').val("");
										$('#passconf').val("");
										$('#validation-error').html(
												"<span style=color:red;>" + msg
														+ "</span>");
									}
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("Error Detectado!",
											"Por favor, intente de nuevo",
											"error");
								}
							});
					e.preventDefault();
					return false;
				});
// Restablecer PASSWORD - Administrador
jQuery('#form-password')
		.on(
				'submit',
				function() {
					var formData = $('#form-password').serialize();
					var formUrl = $('#form-password').attr('action');
					$
							.ajax({
								type : "POST",
								url : formUrl,
								data : formData,
								success : function(msg) {
									if (msg == '1') {
										swal(
												{
													title : "Hecho!",
													text : "Contraseña restablecida con exito",
													type : "success"
												},
												function(isConfirm) {
													if (isConfirm)
														window.location.href = "http://localhost/AdminEx/usuario";
												});
									} else {
										$('#pass').val("");
										$('#passconf').val("");
										$('#validation-error').append(
												"<span style=color:red;>" + msg
														+ "</span>");
									}
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("Error Detectado!",
											"Por favor, intente de nuevo",
											"error");
								}
							});
					return false;
				});
// Restablecer PASSWORD - otros usuarios
jQuery('#form-password')
		.on(
				'submit',
				function() {
					var formData = $('#form-password').serialize();
					var formUrl = $('#form-password').attr('action');
					$
							.ajax({
								type : "POST",
								url : formUrl,
								data : formData,
								success : function(msg) {
									if (msg == '1') {
										swal(
												{
													title : "Hecho!",
													text : "Contraseña restablecida con exito: se procederá a cerrar sesión",
													type : "success"
												},
												function(isConfirm) {
													if (isConfirm)
														window.location.href = "http://localhost/AdminEx/login/cerrar_sesion";
												});
									} else {
										$('#pass').val("");
										$('#passconf').val("");
										$('#validation-error').html(
												"<span style=color:red;>" + msg
														+ "</span>");
									}
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("Error Detectado!",
											"Por favor, intente de nuevo",
											"error");
								}
							});
					return false;
				});
// Modificar perfil de usuario
jQuery('#form-perfil').on('submit', function(e) {
	var formData = $('#form-perfil').serialize();
	var formAction = $('#form-perfil').attr('action');
	$.ajax({
		type : "POST",
		url : formAction,
		data : formData,
		success : function() {
			swal({
				title : "Hecho!",
				text : "Perfil Modificado",
				type : "success"
			}, function(isConfirm) {
				if (isConfirm)
					window.location.href = "http://localhost/AdminEx/perfil";
			});
		},
		error : function(xhr, ajaxOptions, thrownError) {
			swal("Error Detectado!", "Por favor, intente de nuevo", "error");
		}
	});
	e.preventDefault();
});
//Restablecer PASSWORD - Desde el perfil
jQuery('#form-password').on( 'submit', function(e) {
	var formData = $('#form-password').serialize();
	var formUrl = $('#form-password').attr('action');
	$.ajax({
		type : "POST",
		url : formUrl,
		data : formData,
		success : function() {	
			if (msg == 1) {
				swal({
					title : "¡Hecho!",
					text : "Contraseña restablecida con éxito: Se procederá a cerrar la sesión",
					type : "success"
					},
					function(isConfirm) {
						if (isConfirm)
							window.location.href = "http://localhost/AdminEx/login/cerrar_sesion";
						});
			} else {				
				$('#pass').val("");
				$('#passconf').val("");
				$('#validation-error-pass').html("<span style=color:red;>" + msg + "</span>");
			}
		},				
	});
	return false;
});
// Modificar perfil de usuario
jQuery('#form-perfil')
		.on(
				'submit',
				function(e) {
					var formData = $('#form-perfil').serialize();
					var formAction = $('#form-perfil').attr('action');
					$
							.ajax({
								type : "POST",
								url : formAction,
								data : formData,
								success : function(msg) {
									if (msg == 1) {
										swal(
												{
													title : "¡Hecho!",
													text : "Perfil Modificado",
													type : "success"
												},
												function(isConfirm) {
													if (isConfirm)
														window.location.href = base_url
																+ "perfil";
												});
									} else {
										$('#validation-error').html(
												"<span style=color:red;>" + msg
														+ "</span>");
									}
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("¡Error Detectado!",
											"Por favor, intentelo de nuevo",
											"error");
								}
							});
					e.preventDefault();
				});

// ----------------------------//
// --- Clientes ---------------//
// ----------------------------//
// ----- Borrar Cliente -------//
jQuery('.btn.btn-danger.btn-delete-cliente')
		.click(
				function() {
					var id = $(this).attr('name');
					var nombre = $(this).attr("nombre");
					var apellido = $(this).attr('apellido');
					swal(
							{
								title : "¿Seguro que deseas eliminar al cliente "
										+ nombre + " " + apellido + "?",
								text : "No podrás deshacer esta acción",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/cliente/baja",
												data : {
													id : id
												},
												success : function() {
													swal(
															{
																title : "Hecho!",
																text : "Cliente borrado con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/cliente";
															});
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Por favor, verifique si este registro no se encuentra asociado con otro",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo ",
											"error");
								}
							});
				});
// Alta o modificacion
jQuery('#form-cliente').on('submit', function(e) {
	var formData = $('#form-cliente').serialize();
	var formAction = $('#form-cliente').attr('action');
	$.ajax({
		type : "POST",
		url : formAction,
		data : formData,
		success : function() {
			swal({
				title : "Hecho!",
				text : "Cliente guardado con exito",
				type : "success"
			}, function(isConfirm) {
				if (isConfirm)
					window.location.href = "http://localhost/AdminEx/cliente";
			});
		},
		error : function(xhr, ajaxOptions, thrownError) {
			swal("Error Detectado!", "Por favor, intente de nuevo", "error");
		}
	});
	e.preventDefault();
});

// ----------------------------//
// --- Vehiculos ---------------//
// ----------------------------//
// ----- Borrar vehiculo -------//

jQuery('.btn.btn-danger.btn-delete-vehiculo')
		.click(
				function() {
					var id = $(this).attr('name');
					var patente = $(this).attr('patente');
					swal(
							{
								title : "¿Seguro que deseas eliminar el vehículo con patente " + patente + " ?",
								text : "Al eliminar el vehiculo se eliminara de las salidas asociadas",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/vehiculo/baja",
												data : {
													id : id
												},
												success :  function(msg) {
													if (msg == 'true') {
													swal(
															{
																title : "Hecho!",
																text : "Vehículo borrado con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/vehiculo";
															});
												} else {
													swal({
																title : "Error Detectado",
																text : "Verifique si este registro no se encuentre asociado a una salida vigente",
																type : "error"
															});
												}
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Por favor, verifique si este registro no se encuentre asociado a una salida vigente",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo :)",
											"error");
								}
							});
				});

// Alta o modificacion
jQuery('#form-vehiculo').on('submit', function(e) {
	var formData = $('#form-vehiculo').serialize();
	var formAction = $('#form-vehiculo').attr('action');
	$.ajax({
		type : "POST",
		url : formAction,
		data : formData,
		success : function() {
			swal({
				title : "Hecho!",
				text : "Vehiculo guardado con exito",
				type : "success"
			}, function(isConfirm) {
				if (isConfirm)
					window.location.href = "http://localhost/AdminEx/vehiculo";
			});
		},
		error : function(xhr, ajaxOptions, thrownError) {
			swal("Error Detectado!", "Por favor, intente de nuevo", "error");
		}
	});
	e.preventDefault();
});

// ----------------------------//
// --- Excursiones ---------------//
// ----------------------------//
// ----- Borrar excursion -------//

jQuery('.btn.btn-danger.btn-delete-excursion')
		.click(
				function() {
					var id = $(this).attr('name');
					var nombre = $(this).attr('nombre');
					swal(
							{
								title : "¿Seguro que deseas eliminar la excursión " +nombre +" ?",
								text : "Se eliminara las salidas asociada a la excursión",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/excursion/baja",
												data : {
													id : id
												},
												success : function(msg) {
													if (msg == 'true') {
													swal(
															{
																title : "Hecho!",
																text : "Excursión borrada con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/excursion";
															});
													} else {
														swal({
																	title : "Error Detectado",
																	text : "Verifique si este registro no se encuentre asociado a una salida vigente",
																	type : "error"
																});
													}
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Por favor, verifique si este registro no se encuentra asociado con otro",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo :)",
											"error");
								}
							});
				});



// Alta o modificacion
jQuery('#form-excursion')
		.on(
				'submit',
				function(e) {
					var formData = $('#form-excursion').serialize();
					var formAction = $('#form-excursion').attr('action');
					$
							.ajax({
								type : "POST",
								url : formAction,
								data : formData,
								success : function() {
									swal(
											{
												title : "Hecho!",
												text : "Excursión guardada con exito",
												type : "success"
											},
											function(isConfirm) {
												if (isConfirm)
													window.location.href = "http://localhost/AdminEx/excursion";
											});
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("Error Detectado!",
											"Por favor, intente de nuevo",
											"error");
								}
							});
					e.preventDefault();
				});
// ----------------------------//
// ---- Salidas ---------------//
// ----------------------------//
// ----- Borrar salidas -------//

jQuery('.btn.btn-danger.btn-delete-salida')
		.click(
				function() {
					var id = $(this).attr('name');
					var fecha = $(this).attr('fecha');
					var hora = $(this).attr('hora');
					swal(
							{
								title : "¿Seguro que deseas eliminar la salida con fecha "+ fecha
								+" y hora " + hora +" ?",
								text : "",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/salida/baja",
												data : {
													id : id
												},
												success : function() {
													swal(
															{
																title : "Hecho!",
																text : "Salida borrada con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/salida";
															});
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Por favor, verifique si este registro no se encuentra asociado con otro",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo :)",
											"error");
								}
							});
				});

// Alta o modificacion
jQuery('#form-salida').on('submit', function(e) {
	var formData = $('#form-salida').serialize();
	var formAction = $('#form-salida').attr('action');	
	$.ajax({
		type : "POST",
		url : formAction,
		data : formData,
		success : function() {
			swal({
				title : "Hecho!",
				text : "Salida guardada con exito",
				type : "success"
			}, function(isConfirm) {
				if (isConfirm)
					window.location.href = "http://localhost/AdminEx/salida";
			});
		},
		error : function(xhr, ajaxOptions, thrownError) {
			swal("Error Detectado!", "Por favor, intente de nuevo", "error");
		}
	});
	e.preventDefault();
});

// ----------------------------//
// ---- Alojamientos ---------------//
// ----------------------------//
// ----- Borrar Alojamientos -------//

jQuery('.btn.btn-danger.btn-delete-alojamiento')
		.click(
				function() {
					var id = $(this).attr('name');
					var nombre = $(this).attr('nombre');
					swal(
							{
								title : "¿Seguro que deseas eliminar el alojamiento " + nombre + " ?",
								text : "",
								type : "warning",
								showCancelButton : true,
								cancelButtonText : "Cancelar",
								confirmButtonColor : "#DD6B55",
								confirmButtonText : "Aceptar",
								closeOnConfirm : false
							},
							function(isConfirm) {
								if (isConfirm) {
									$
											.ajax({
												type : "POST",
												url : "http://localhost/AdminEx/alojamiento/baja",
												data : {
													id : id
												},
												success : function() {
													swal(
															{
																title : "Hecho!",
																text : "Alojamiento borrado con exito",
																type : "success"
															},
															function(isConfirm) {
																if (isConfirm)
																	window.location.href = "http://localhost/AdminEx/alojamiento";
															});
												},
												error : function(xhr,
														ajaxOptions,
														thrownError) {
													swal(
															"Error Detectado!",
															"Por favor, verifique si este registro no se encuentra asociado con otro",
															"error");
												}
											});
								} else {
									swal(
											"Cancelado",
											"Tu archivo imaginario está a salvo :)",
											"error");
								}
							});
				});
function modalError(error) {
	swal("¡Error Detectado!", error, "error");
}
function modalRecursosAulas(titulo,msj) {
	swal(titulo, msj, "success");
}
// Alta o modificacion
jQuery('#form-alojamiento')
		.on(
				'submit',
				function(e) {
					var formData = $('#form-alojamiento').serialize();
					var formAction = $('#form-alojamiento').attr('action');
					$
							.ajax({
								type : "POST",
								url : formAction,
								data : formData,
								success : function() {
									swal(
											{
												title : "Hecho!",
												text : "Alojamiento guardado con exito",
												type : "success"
											},
											function(isConfirm) {
												if (isConfirm)
													window.location.href = "http://localhost/AdminEx/alojamiento";
											});
								},
								error : function(xhr, ajaxOptions, thrownError) {
									swal("Error Detectado!",
											"Por favor, intente de nuevo",
											"error");
								}
							});
					e.preventDefault();
				});
