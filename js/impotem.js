$('.esMoneda').change(function(){
	var campo = $(this);
	var valor =campo.val();
	if(valor<0){
		$(this).val('0.00')
	}else{
		$(this).val(parseFloat(valor).toFixed(2));
	}
});
$("input").focus(function(){
  this.select();
});