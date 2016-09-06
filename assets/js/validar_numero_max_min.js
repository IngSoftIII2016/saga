function validadMaxMin(input){
	valor= parseInt(input.value);
	maximo= parseInt(input.max);
	minimo= parseInt(input.min);
    if (valor > maximo)
    {
  	  input.value=maximo;
    }
    else if (valor <minimo )
    {
  	  input.value=minimo;
    } 
}