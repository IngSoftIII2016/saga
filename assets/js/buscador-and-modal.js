$('#modal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var aula = button.data('whatever');
	var modal = $(this);
	modal.find('.modal-title').text('Recursos del ' + aula );
});
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
						if(jQuery.trim(buscar) != ''){
						   $(".buscar:icontains('" + buscar + "')").addClass('resaltar');
						}
		});
		$(document).ready(function(){
    $('[data-toggle*="tooltip"]').tooltip(); 
});

		
});
