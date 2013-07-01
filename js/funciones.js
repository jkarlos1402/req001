//************************************//
//Nombre: Regino Tabares
//Funcion: antes del envio de formulario manda a llamar la funcion que realiza las validaciones
//Fecha:10/05/03
//*************************************

$(function(){
	$("#Reg_Cli,#formModificaCli").submit(function(){if(validaCliente()) return true; else return false;});
	
});

function validaCliente(){
	var banderaCliente = true;
	$("#Reg_Cli,#formModificaCli").find(".requerido").each(function() {
        if($(this).val()==""){
			alert("Campo requerido");
			$(this).focus();
			banderaCliente = false;
			return false;
		}
    });
	if(!banderaCliente)
		return false;
	if(isNaN($("#TelEntCli").val()) || $("#TelEntCli").val().length < 7 || $("#TelEntCli").val().length > 12 ){
		alert("Número telefónico inválido");
		$("#TelEntCli").focus();
		return false;
	}
	return true;
}

$(function(){
	$("#formRegUsu").submit(function(){if(validaUsuario()) return false; else return false;});
	});
	
function validaUsuario(){
	var aux;
	var bandera=true;
	$("#formRegUsu").find(".requerido").each(function(){
		if($(this).val()==""){
			$("#errorReg").css("visibility","visible");
			$("#errorReg").css("display","");
			$(this).focus();
			bandera=false;
			return false;
		}
		else
			$("#errorReg").css("visibility","hidden");
			$("#errorReg").css("display","none");
	});
	if(bandera==true){
		var NomEntUsu = $("#NomEntUsu").val();
		var PwdEntUsu = $("#PwdEntUsu").val();
		var PflEntUsu = $("#PflEntUsu").val();
		var url="../usuario/alta.php";
		$.post(url,{NomEntUsu:NomEntUsu,PwdEntUsu:PwdEntUsu,PflEntUsu:PflEntUsu},function(responseText){
			$("#formRegUsu").find(".requerido").each(function(){
				$(this).val("");
			});
			$("#mensaje").html(responseText);
		});
		
	}
	
}
function modificaUsu(IdEntUsu){
	var url="../usuario/usuario.php";
	$.post(url,{IdEntUsu:IdEntUsu},function(responseText){
		$("#consultarUsuarios").dialog("close");
		$("#modificarUsuarios").dialog("open");
		$("#modificarUsuarios").find("#datosMod").html(responseText);
	});
	
}

$(function(){
	$("#formModUsu").submit(function(){if(validaUsuarioMod()) return false; else return false;});
	});
	
function validaUsuarioMod(){
	var aux;
	var bandera=true;
	$("#formModUsu").find(".requerido").each(function(){
		if($(this).val()==""){
			$("#errorMod").css("visibility","visible");
			$("#errorMod").css("display","");
			$(this).focus();
			bandera=false;
			return false;
		}
		else
			$("#errorMod").css("visibility","hidden");
			$("#errorMod").css("display","none");
	});
	if(bandera==true){
		var IdEntUsu =$("#formModUsu").find("#IdEntUsu").val();
		var NomEntUsu = $("#formModUsu").find("#NomEntUsu").val();
		var PwdEntUsu = $("#formModUsu").find("#PwdEntUsu").val();
		var PflEntUsu = $("#formModUsu").find("#PflEntUsu").val();
		var url="../usuario/modifica.php";
		$.post(url,{IdEntUsu:IdEntUsu,NomEntUsu:NomEntUsu,PwdEntUsu:PwdEntUsu,PflEntUsu:PflEntUsu},function(responseText){
			$("#mensajeMod").html(responseText);
		});
		
	}
	
}

//************************************//
//Nombre: Regino Tabares
//Funcion: Asignacion de propiedades de JQuery UI a los componentes BOTON, SUBMIT.
//			agrega estilo visual a los componentes
//			Inicializa el calendario
//Fecha:10/05/03
//*************************************
$(function() {	
		$("input[type=button],input[type=submit]").button();
		$(".botonAdd").button({icons: {primary: "ui-icon-plusthick"},text: false});
		$("input[type=text],input[type=password],select,td,h2").addClass("ui-corner-all");
		$( "#accordion,#cliente" ).accordion({
		heightStyle: "content"
		});
		$( "input[type=fecha]" ).datepicker({ dateFormat: 'dd-mm-yy' });
		
		
		$( "#dialog , #dialog2, #dialogregistro,#dialogmod,#consultarUsuarios,#registrarUsuarios,#modificarUsuarios").dialog({
			width: 350,
			modal: true,
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
	  
    						});
	  $(".botonAddDisS").button({icons: {
        		primary: "ui-icon-plusthick"
      		},
      		text: false
    	});
		$(".botonDelDis").button({icons: {
        		primary: "ui-icon-trash"
      		},
      		text: false
    	});
		
		$("#ident").button().click(function() {
          var menu = $( this ).parent().next().show().position({
            my: "left top",
            at: "left bottom",
            of: this
          });
          $( document ).one( "click", function() {
            menu.hide();
          });
          return false;
        })
        .parent()
          .buttonset()
          .next()
            .hide()
            .menu();
		
		$("#select").button(
		{text:false,icons:{primary:"ui-icon-power"}}
		).click(function(){
			url = "../login/logout.php";
			$(location).attr('href',url);
		});
		
		$("#consulta").click(function(){
			$("#consultarUsuarios").dialog("open");
			var url ="../usuario/usuario.php";
			$.post(url,{},function(responseText){
				$("#datosUsuario").html(responseText);
			});
		});
		
		$("#registra").click(function(){
			$("#consultarUsuarios").dialog("close");
			$("#registrarUsuarios").dialog("open");
		});
		
		$("#inicio").button();
		$("#clientes").button().hover(function() {
          var menu = $( this ).parent().next().show().position({
            my: "left top",
            at: "left bottom",
            of: this
          });
          $( document ).one("click", function() {
            menu.hide();
          });
          return false;
        })
        .parent()
          .buttonset()
          .next()
            .hide()
            .menu();
		
  
});



//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: modificaCliente()
//Funcion del módulo: Habilita los 'inputs' para poder modificar el contenido y deshabilita los botones 'Eliminar' y 'Modificar'
//Fecha:10/05/03
//*************************************
function modificaCliente(){
	var con = confirm("¿Desea modificar los datos?");
	if (con == true){
		$("#formModificaCli").find("input").removeAttr("disabled");
		
		$("#botonG").css("visibility","visible");
		$("#botonG").css("display","");
		$("#botonesME").css("display","hidden");
		$("#botonesME").css("display","none");
		/*
		document.getElementById("botonG").style.visibility = 'visible';
		document.getElementById("botonG").style.display='';
		document.getElementById("botonesME").style.visibility = 'hidden';
		document.getElementById("botonesME").style.display='none';
		*/
	}
		}	
	
//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: eliminaCliente()
//Funcion del módulo: Llama a eliminaCliente.php para realizar la baja "lógica" del cliente
//Fecha:10/05/03
//*************************************
	function eliminaCliente(IdEntCli){
		var conf=confirm("¿Desea eliminar el cliente y todos sus proyectos?");
		if(conf==true){
			$("#formElimina").submit();
		}
	}
	
	
//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfoCliente()
//Funcion del módulo: Llamar a "consultaCliente.php" para consultar e imprimir los datos del cliente sin recargar la página
//Fecha:10/05/03
//*************************************
function mostrarInfoCliente(IdEntCli){
	creaBarra();
	$("#datos").html("");
	var url = "../cliente/consultaCliente.php";
	$.post(url,{IdEntCli:IdEntCli},function(responseText){
		$("#datos").html(responseText);
		$("#datos").find($("input[type=button],input[type=submit]")).button();
		$("input[type=text],select,td,tr,h2").addClass("ui-corner-all");
		eliminaBarra();
	});
}

function creaBarra(){
	$( "#progressbar" ).progressbar({
      	value: false,
	});
	$("#progressbar").css("visibility","visible");
	$("#progressbar").css("display","");
	$(".progress-label").css("visibility","visible");
	$(".progress-label").css("display","");
}

function eliminaBarra(){
	$("#progressbar").progressbar("destroy");
	$(".progress-label").css("visibility","hidden");
	$(".progress-label").css("display","none");
}
var contador=0;
var ct=0;

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfo()
//Funcion del módulo: Llamar a "consultaProyecto.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:13/05/03
//*************************************
function mostrarInfoProyecto(IdEntPry){
	$("#datos").html("");
	if(IdEntPry != 0){
		creaBarra();
		var url = "../proyecto/consultaProyecto.php";
		$.post(url,{IdEntPry:IdEntPry},function(responseText){
			$("#datos").html(responseText);
			$("#datos").find("a").button();
			eliminaBarra();
		});
	}
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfo()
//Funcion del módulo: Llamar a "consultaProyecto.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:13/05/03
//*************************************
function mostrarInfoIng(IdEntPry){
	if(IdEntPry!=0){
		creaBarra();
		var url = "../ingresos/consultaIngresos.php";
		$.post(url,{IdEntPry:IdEntPry},function(responseText){
			$("#datos").html(responseText);
			eliminaBarra();
		});
	}
	else{
		$("#datos").html("");
		return;
	}
}

//*************************************//
var totalpry=0;
var cuentapag=0;
var cuentavalidar=0;
var sumaporcentaje=0;
var alerta;
function enviaTotal(tot,cueral,cueval,por,aler){
	totalpry=tot;
	cuentapag=cueral;
	cuentavalidar=cueval;
	sumaporcentaje=por;
	alerta=aler;
	canttot=parseFloat(cuentapag);
	if(alerta==true){
		verificaAlerta(true);	
	}
}

function verificaPass(IdEntPag,cont,pago){
	//Agregar cuando ya esten los passwords
	var aux=confirm("¿Deseas modificar la fecha de pago?");
		if(aux==true){
			modificaFecha(IdEntPag,cont);
			
		}
}
var contFecha;
function modificaFecha(IdEntPag,cont){
	contFecha=cont;
	//Agregar cuando ya esten los passwords
	$("#fechaPagoM").val("");
	$("#mensajeM").html("");
	$("#IdEntPagM").val(IdEntPag);
	$("input[type=fechaPagoM]").datepicker({dateFormat:'dd-mm-yy'}).datepicker('setDate','today');
	$( "#dialogmod").dialog( "open" );
}
function guardarFecha(){
	var url = "../ingresos/actualizaFecha.php"
	var IdEntPag=$("#IdEntPagM").val();
	var FecEntPagRal=$("#FecEntPagRalM").val();
	$.post(url,{IdEntPag:IdEntPag,FecEntPagRal:FecEntPagRal},function(responseText){
		$("#mensajeM").html(responseText);
		$( "#dialogmod").dialog( "close" );
		$("#fec"+contFecha).html(FecEntPagRal);
	});
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: registrarPago()
//Funcion del módulo: Abre la ventana para registrar el Monto del pago y la fecha
//Fecha:10/05/03
//*************************************
var contoculta=0;
var pagoprg;
var suma =0;
var total=0;
var canttot=0;

function registraPago(IdEntPag,cont,pago){
	//document.getElementById("IdEntPagRal").value = IdEntPag;
	$("#IdEntPagRal").val(IdEntPag);
	$("#MonEntPagRal").val(pago);
	$("#FecEntPagRal").val("");
	$("input[type=fechaPago]").datepicker({dateFormat:'dd-mm-yy'}).datepicker('setDate','today');
	$("#mensaje").html("");
	$( "#dialogregistro").dialog( "open" );
	contoculta=cont;
	pagoprg=pago.toFixed(2);

	
}


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: guardarPago()
//Funcion del módulo: Manda llamar a guardarPago.php para la actualización de los registros, Verifica la validacion de los campos
//					 y verifica que el monto que se va a registrar sea igual al monto programado, si no envía una alerta para avisar
//						que ocurrio un desequilibrio en los montos6
//Fecha:10/05/03
//*************************************
	var sumainterna=0;
function guardarPago(){

	if(document.getElementById("MonEntPagRal").value=="" || isNaN(document.getElementById("MonEntPagRal").value)){
		alert("Por favor ingrese el monto");
		document.getElementById("MonEntPagRal").value = "";
		document.getElementById("MonEntPagRal").focus();
		return false;	
	}
	else if(document.getElementById("FecEntPagRal").value==""){
		alert("Por favor ingrese la fecha");
		document.getElementById("FecEntPagRal").focus();
		return false;	
	}
	else{
			if(parseFloat(document.getElementById("MonEntPagRal").value).toFixed(2) > pagoprg || parseFloat(document.getElementById("MonEntPagRal").value).toFixed(2) < pagoprg)
			{
				var band =confirm("El monto del pago es diferente al monto programado,\n es necesario ajuste. ¿Desea Continuar? ");
						if(band==true){
							
					cantpag = document.getElementById("MonEntPagRal").value;
					canttot=canttot+parseFloat(cantpag);
					
					sumainterna=sumainterna+parseFloat(cantpag);
				
					if((canttot>totalpry && totalpry>0) || sumainterna>totalpry)
					{
						alert("Se excedio el total");
						sumainterna = sumainterna-parseFloat(cantpag);
						canttot=canttot-parseFloat(cantpag);
						return false;
					}
					else
					{
						
						PorEntPagRal=cantpag*100/totalpry;
						PorEntPagRal.toFixed(3);
						sumaporcentaje=sumaporcentaje+parseFloat(PorEntPagRal);
						var url = "../ingresos/guardarPago.php";
					IdEntPag = document.getElementById("IdEntPagRal").value;
					MonEntPagRal =  document.getElementById("MonEntPagRal").value;
					FecEntPagRal =  document.getElementById("FecEntPagRal").value;
					
					$.post(url,{IdEntPag:IdEntPag,MonEntPagRal:MonEntPagRal,FecEntPagRal:FecEntPagRal,PorEntPagRal:PorEntPagRal},function(responseText){
						$("#mensaje").html(responseText);
					});
					$("#est"+contoculta).css("background-color","#00D615");
					$("#montoreal"+contoculta).html("$"+MonEntPagRal);
				  $("#totreal").html("$"+(canttot).toFixed(2));
				  $("#porreal"+contoculta).html(PorEntPagRal.toFixed(3)+"%");
				   $("#porcreal").html((sumaporcentaje).toFixed(3)+"%");
					verificaAlerta(true);
					$( "#dialogregistro" ).dialog( "close" );
					document.getElementById("div"+contoculta).style.visivility = "hidden";
						document.getElementById("div"+contoculta).style.display = "none";
					document.getElementById("divoculto"+contoculta).style.visibility = 'visible';
							document.getElementById("divoculto"+contoculta).style.display = '';
					}
						}
						
			}
			else
			{
					cantpag = document.getElementById("MonEntPagRal").value;
					canttot=canttot+parseFloat(cantpag);
					sumainterna=sumainterna+parseFloat(cantpag);
					
					
					if((canttot>totalpry && totalpry>0) || sumainterna>totalpry)
					{
						alert("Se excedio el total");
						canttot=canttot-parseFloat(cantpag);
						sumainterna = sumainterna-parseFloat(cantpag);
					}
					else
					{
						PorEntPagRal=cantpag*100/totalpry;
						PorEntPagRal.toFixed(3);
						sumaporcentaje=sumaporcentaje+parseFloat(PorEntPagRal);
						var url = "../ingresos/guardarPago.php";
					IdEntPag = document.getElementById("IdEntPagRal").value;
					MonEntPagRal =  document.getElementById("MonEntPagRal").value;
					FecEntPagRal =  document.getElementById("FecEntPagRal").value;
					$.post(url,{IdEntPag:IdEntPag,MonEntPagRal:MonEntPagRal,FecEntPagRal:FecEntPagRal,PorEntPagRal:PorEntPagRal},function(responseText){
						$("#mensaje").html(responseText);
					});
					$( "#dialogregistro" ).dialog( "close" );
					$("#est"+contoculta).css("background-color","#00D615");
					$("#est"+contoculta).css("background-color","#00D615");
					$("#montoreal"+contoculta).html("$"+MonEntPagRal);
					$("#porreal"+contoculta).html(PorEntPagRal.toFixed(3)+"%");
					 $("#totreal").html("$"+(canttot).toFixed(2));
					 $("#porcreal").html((sumaporcentaje).toFixed(3)+"%");
					
					document.getElementById("div"+contoculta).style.visivility = "hidden";
						document.getElementById("div"+contoculta).style.display = "none";
					document.getElementById("divoculto"+contoculta).style.visibility = 'visible';
							document.getElementById("divoculto"+contoculta).style.display = '';
					}
					
			}
	}
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: verificaAlerta()
//Funcion del módulo: Verifica que la variable de entrada, si es true. muestra un error
//Fecha:10/05/03
//*************************************
function verificaAlerta(alerta){
	if(alerta==true && (canttot != totalpry && canttot!=null)){
			$("#alerta").addClass("ui-state-error ui-corner-all");
			$("#alerta").html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Atención: Se necesita ajuste en los montos de pago!!!");
		return false;	
		}
		else{
			$("#alerta").removeClass("ui-state-error ui-corner-all");
			$("#alerta").html("");
			return true;
	}
}


////////////////////////////////////////////////////////////////////////////
function selTodos(cont,proceso)
{

		if(proceso==1)
		{
			for(var i=1;i<cont;i++)
				{
				document.getElementById("pago"+i).checked=1;
				}
			if(confirm("¿Deseas programar todos los pagos?"))
				{
				document.getElementById("formulario").submit();
				}
			else
				{
					for(var i=1;i<cont;i++)
					{
					document.getElementById("pago"+i).checked=0;
					}
				}
		}
		if(proceso==2)
		{
			for(var i=1;i<cont;i++)
				{
				document.getElementById("pago"+i).checked=1;
				}
			if(confirm("¿Deseas consultar todos los pagos?"))
				{
				
				}
			else
				{
					for(var i=1;i<cont;i++)
					{
					document.getElementById("pago"+i).checked=0;
					}
				}
		}
	
}

////////////////////////////////////////////////////////////////////////////
function programaDisp(aux){
	if(confirm("¿Deseas programar dispersión?")){
	document.getElementById("pago"+aux).checked=1;
	document.getElementById("formulario").submit();
	}
}

////////////////////////////////////////////////////////////////////////////
function programaSel(){
	document.getElementById("formulario").submit();	
}

/////////////////////////////////////////////////////////////////////////////
function eliminarProyecto(){
	if(confirm("¿Seguro de eliminar el proyecto?")){
		$("#formElimina").submit();
	}
}