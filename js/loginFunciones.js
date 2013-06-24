///////////////////////////
$(function(){
	$("#formLogin").submit(function(){if(validaLogin()) return false; else return false;});
});

function validaLogin(){
	var NomEntUsu = $("#NomEntUsu").val();
	var PwdEntUsu = $("#PwdEntUsu").val();
	var url="../login/verificaLogin.php";
	$.post(url,{NomEntUsu:NomEntUsu,PwdEntUsu:PwdEntUsu},function(responseText){
		$("#error").html(responseText);
	});
	
}
