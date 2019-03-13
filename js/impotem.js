$('.esMoneda').change(function(){
	var campo = $(this);
	var valor =campo.val();
	if(valor<0){
		$(this).val('0.00')
	}else{
		$(this).val(parseFloat(valor).toFixed(2));
	}
});
$("body").on('focus', 'input',function(){
  this.select();
});
$('.esGalon').change(function(){
	var campo = $(this);
	var valor =campo.val();
	if(valor<0){
		$(this).val('0.00')
	}else{
		$(this).val(parseFloat(valor).toFixed(3));
	}
});
$('.soloNumeros').keypress(function (e) {//|| 
	if( !(e.which >= 48 /* 0 */ && e.which <= 90 /* 9 */)  ) {
        e.preventDefault();
    }
});