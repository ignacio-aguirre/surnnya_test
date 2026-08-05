<?php 
include("funciones.php");
session_start();
tranca(4);
$status="";
if(isset($_GET['status'])) $status=$_GET['status'];
$_SESSION["prestacion"]="Stocks F&iacute;sicos Año:".un_campo("select valorentero from parametros where codigo='SE_ANIO'")." Mes:".un_campo("select valorentero from parametros where codigo='SE_MES'");
include("encabezado.php");echo $status;
$valor=un_campo("select valorentero from parametros where codigo='SE_HABILITADO'");
if($valor=="0") {
 echo "</div><div class='container'><p class='warning-text'>No est&aacute; habilitada la carga de stock f&iacute;sico</p>";
 die("Presion&aacute; (atr&aacute;s) para regresar");
};
$anio=un_campo("select valorentero from parametros where codigo='SE_ANIO'");
$mes=un_campo("select valorentero from parametros where codigo='SE_MES'");

$valor=un_campo("select idcomprobantes from comprobantes where tipo='PED' and tipo_entidad='EF' and entidad=".$_SESSION["efector"]." and mensual_anio=".$anio." and mensual_mes=".$mes);
if($valor>"0") {
 echo "</div><div class='container'><p class='warning-text'>Se ha generado Pedido Mensual. No se puede actualizar stock f&iacute;sico de este mes</p>";
 die("Presion&aacute; (atr&aacute;s) para regresar");
};

?>
</div>
<div class="container">
<form class="form-inline" onsubmit="return false">
 <div class="form-group has-warning">
  <label class="label-form" for="efector">Efector</label>
  <select class="form-control" id='efector'>
   <?php echo opciones("efectores");?>
  </select>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="rubro">Rubro</label>
  <select class="form-control" id='rubro'>
   <?php echo opciones("articulos_rubros");?>
  </select>
 </div>
 <button class='btn-primary' onclick='despliega_stock()'>Consultar</button>
</form>
 <div class="table-responsive">
 <table class="table" id="tabla">
 </table>
 </div> 
<button class='btn-primary' onclick='guardar()') >Guardar Cambios</button>&nbsp;<br><br> 
<button class='btn-success' onclick='aexcel()') >Excel</button>&nbsp;<br><br> 
</div> 

<script src='js/particulares.js'></script>
<script>
function guardar(){
   efec=document.getElementById('efector').value;
   rubr=document.getElementById('rubro').value;  
   filas=document.getElementById("tabla").rows.length;
  if(efec=="0"){status("Indicar Efector");return false;};
  if(rubr=="0"){status("Indicar Rubro");return false;};
  if(filas==0){status("Nada que guardar");return false;};
  status("");
 ejec("ej_stock","CANTIDADES_FISICAS","&efector="+document.getElementById("efector").value);
 navega("cargar_fisico");
}
function valida_cantidad(id){
 valida_entero(id);
 cant=document.getElementById(id).value;
 arti=id;
 cantidad=ejec_sq("sq_cantidad_fisico?articulo="+arti+"&cantidad="+cant+"&efector="+document.getElementById("efector").value);
 document.getElementById(id).value=cantidad;
 return true;

}


function despliega_stock(){
    efec=document.getElementById('efector').value;
    rubr=document.getElementById('rubro').value;  
    if(efec=="0"){status("Indicar Efector");return false;};
    if(rubr=="0"){status("Indicar Rubro");return false;};
    status("");
    document.getElementById("tabla").innerHTML=ejec_sq("sq_arti_traefisicocarga?efector="+efec+"&rubro="+rubr);
};
document.getElementById("efector").focus();



function aexcel(){
 efec=document.getElementById('efector').value;
 if(efec=="0"){status("Indicar Efector");return false;};
 navega("browser_stock?tipo=STOCK_FISICO1EF_EXCEL&efector="+efec);
}
</script>
</body>