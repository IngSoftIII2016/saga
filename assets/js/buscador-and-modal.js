
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
