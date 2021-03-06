 <?php
 //**********************************************************************************************//
// Nombre: Regino Tabares																		//
// Nombre del módulo: Consulta de Proyectos 												//
// Función del módulo: Obtiene los Proyectos registrados y sus datos						//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");

session_start();

//Consulta 2 Para obtener los datos de la empresa
$IdEntPry=$_POST['IdEntPry'];
$consulta="SELECT * 
    FROM tblentpag, tblentest
    WHERE tblentpag.IdEntEst = tblentest.IdEntEst
    AND tblentpag.IdEntPry =$IdEntPry ORDER BY tblentpag.IdEntEst DESC";
$consulta2= "SELECT * 
    FROM tblentcli, tblentpry
    WHERE IdEntPry =$IdEntPry
    AND tblentcli.IdEntCli = tblentpry.IdEntCli";

$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());
$resultadocliente=mysql_query("$consulta2",$conexion) or die (mysql_error());
$color;
$total=0;;
$totalporc=0;
$dias=0;
$contdias=1;

 //******************************************************************************************************//
// Nombre: Regino Tabares																				//
// Nombre del módulo: diasEntreFechas 																	 //
// Función del módulo: Obtener la diferencia de dias entre la fecha programada y la actual para          //
//						determinar el estatus del pago.
//						Si la diferencia es mayor a 5 no se hace cambio al estatus						//
//						Si la diferencia es menor a 3 se actualiza el estado a 3 -> "Próximo a ejecutar" //
//						Si la diferencia es negativa se actualiza al estado a 4 -> "Desfazado"			//		
// Fecha: 13/05/2013																			//
//**********************************************************************************************//	
function diasEntreFechas($fechainicio, $fechafin,$id){
    $dias = ((strtotime($fechafin)-strtotime($fechainicio))/86400);			
    if($dias>3){
        $query = "select IdEntEst from tblentest where DscEntEst like 'PLANEADO'";
        $res = mysql_query($query);
        while($fila = mysql_fetch_array($res)){
                $estado = $fila['IdEntEst'];
        }
        $qact="UPDATE tblentpag set IdEntEst=$estado where IdEntPag=$id";
        $ejec=mysql_query("$qact");
    }
    if($dias<=3){
        $query = "select IdEntEst from tblentest where DscEntEst like 'PROXIMO A EJECUTAR'";
        $res = mysql_query($query);
        while($fila = mysql_fetch_array($res)){
                $estado = $fila['IdEntEst'];
        }
        $qact="UPDATE tblentpag set IdEntEst=$estado where IdEntPag=$id";
        $ejec=mysql_query("$qact");
    }
    if($dias<0){
        $query = "select IdEntEst from tblentest where DscEntEst like 'DESFASADO'";
        $res = mysql_query($query);
        while($fila = mysql_fetch_array($res)){
                $estado = $fila['IdEntEst'];
        }
        $qact="UPDATE tblentpag set IdEntEst=4 where IdEntPag=$id";
        $ejec=mysql_query("$qact");
    }
}

function diasFaltantes($fechainicio, $fechafin,$id){
    return $dias =((strtotime($fechafin)-strtotime($fechainicio))/86400);	
}

 //******************************************************************************************************//
// Nombre: Regino Tabares																				//
// Nombre del módulo: colorEstatus																	 //
// Función del módulo: Obtiene el estado de pago y dependiendo de el se asigna un color para el semáforo //
// Fecha: 13/05/2013																			//
//**********************************************************************************************//		
function colorEstatus($id){
    $query = "select DscEntEst from tblentest where IdEntEst = $id";
    $res = mysql_query($query);
    while($fila = mysql_fetch_array($res)){
        $estado = $fila['DscEntEst'];
    }
    if($estado=="EJECUTADO"){
        $color="bgcolor='5EBA67'";
    }
    if($estado=="PLANEADO"){
        $color="bgcolor='#5DA1E5'";
    }
    if($estado=="PROXIMO A EJECUTAR"){
        $color="bgcolor='#DFD96B'";
    }
    if($estado=="DESFASADO"){
        $color="bgcolor='#DA3E3E'";
    }
    return $color;	
}
while($renglon = mysql_fetch_array($resultadocliente)){
    if($renglon['IVAEntPry']==1){
        $auxiva=1;	
    }
    else{
        $auxiva=0;
    }
    echo '<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
        <label>Cliente: <b>'.$renglon['NomEntCli'].'</b></label>';
}
echo '<table CellSpacing="3">
    <tr class="encabezado">
        <td colspan="9"><h2 align="center">ESTATUS DE PAGOS</h2></td>
    </tr>
    <tr align="center">
            <td colspan="2"></td><td>No.</td><td>Fecha Programada</td><td>Porcentaje (%)</td><td>Monto $</td><td>Concepto</td><td colspan="2">Estatus</td>	
    </tr>';
$cont = 1;
while($renglon = mysql_fetch_array($resultado)){		
    if($renglon['FecEntPagRal'] == Null){
        diasEntreFechas(date("d-m-Y"),$renglon['FecEntPagPrg'],$renglon['IdEntPag']);
    }
}
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());
while($renglon = mysql_fetch_array($resultado)){
    $dias = diasFaltantes(date("d-m-Y"),$renglon['FecEntPagPrg'],$renglon['IdEntPag']);
    echo '<tr align="center">
            <form class="form" id="formulario'.$cont.'" name="formulario'.$cont.'" method="POST" action="../ingresos/consultaDispersion.php">';
            if($_SESSION['k_perfil']!="USU"){
            echo '
            <td><img src="../vista/images/vista.png" style="cursor:pointer;" width="25" onclick=consultarDispersion('.$renglon['IdEntPag'].');></td>
            <td><img src="../vista/images/config.gif" style="cursor:pointer;" onclick=programarDispersion('.$renglon['IdEntPag'].') width="25"></td>';            
            }
            else{
                echo'<td><img src="../vista/images/vista.png" style="cursor:pointer;" width="25" onclick=consultarDispersion('.$renglon['IdEntPag'].');></td><td></td>';
            }
           echo' <td>'.$cont.'<input type="text" id="IdEntPag" name="IdEntPag" value="'.$renglon['IdEntPag'].'" style="visibility:hidden; display:none"><input type="text" id="IdEntPry" name="IdEntPry" value="'.$IdEntPry.'" style="visibility:hidden; display:none"></td>';
    if($renglon['FecEntPagRal']==null){	
        echo '<td>'.date("d-m-Y",strtotime($renglon['FecEntPagPrg'])).'</td>';
        echo '<td>'.$renglon['PorEntPagPrg'].'%</td>';
        if($auxiva==1){
            //$iva = $renglon['MonEntPagPrg'] * .16;
            $iva = 0;
            //$total =$total +($renglon['MonEntPagPrg']+$iva);  
            //$totalporc = $totalporc + $renglon['PorEntPagPrg'];
            echo '<td>$'.$renglon['MonEntPagPrg'].'</td>';		
        }else{
            echo '<td>$'.$renglon['MonEntPagPrg'].'</td>';
        }
    }else{
        $total =$total +($renglon['MonEntPagRal']);  
        $totalporc = $totalporc + $renglon['PorEntPagRal'];
        echo '<td>'.date("d-m-Y",strtotime($renglon['FecEntPagRal'])).'</td>
              <td>'.$renglon['PorEntPagRal'].'%</td>';
        echo '<td>$'.$renglon['MonEntPagRal'].'</td>';
    }
    if($renglon['IdEntEst']==3){
        echo '<td>'.$renglon['CtoEntPag'].'</td><td>'.$renglon['DscEntEst'].'<br><font size="-5">(Faltan '.$dias.' dias para el pago)</font></td>';
    }else{
        echo '<td>'.$renglon['CtoEntPag'].'</td><td>'.$renglon['DscEntEst'].'</td>';	
    }
    echo '<td '.colorEstatus($renglon['IdEntEst']).'>&nbsp;&nbsp;</td>
        </form>
    </tr>';
    $cont++;	
}
echo '  <tr align="center" class="registro">
            <td colspan="4">Total pagado</td><td>'.round($totalporc,2).'%</td><td>$'.round($total,2).'</td><td colspan="3"></td>
        </tr>';
if($_SESSION['k_perfil']!="USU"){
    echo'<tr>
          <td colspan="9" align="right">
            <a href="javascript:enviaModificar('.$IdEntPry.');">Modificar proyecto</a>
            <input id="deleteProy" type="button" value="Eliminar proyecto" onclick="eliminarProyecto();"/>                          
          </td>
        </tr>
    </table>
    
    <form id="formElimina" method="post" target="_top" action="../proyecto/eliminaProyecto.php">
        <input type="hidden" name="IdEntPry" value="'.$IdEntPry.'"/>
    </form>';
}
?>
               
                

                   
                    
    

