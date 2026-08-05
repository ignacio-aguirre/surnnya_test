<?php 
include("funciones.php");
session_start();
tranca();
$status="";
$rubro="";
$articulo="";
$efector="";
if(isset($_GET['status'])) $status=$_GET['status'];
if(isset($_GET['rubro'])) $rubro=$_GET['rubro'];
if(isset($_GET['articulo'])) $articulo=$_GET['articulo'];
if(isset($_GET['efector'])) $efector=$_GET['efector'];
$_SESSION["prestacion"]="Consulta de Entregas Mensuales por Art&iacute;culo";
include("encabezado.php");echo $status;?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Rubro</th><th>Art&iacute;culo</th></tr>
<tr><td><select class="form-control" id='rubro' name='rubro'><?php echo opciones('articulos_rubros')?></select></td>
<td><select class="form-control" id='articulo' name='articulo' onfocus='traeart()'</select></td></tr>
</table>
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Efector</th><th>Acci&oacute;n</th></tr>
<tr><td><select class="form-control" id='efector' name='efector'><?php echo opciones('efectores')?></select></td><td><button class='btn-primary' onclick='despliega_movimientos()'>Consultar</button></td></tr>
</table>
</div>
</div>
<div class="container">
<div class="table-responsive pre_scrollable" id="tabla">
</div> 
</div> 
<script src='js/particulares.js'></script>
<script>
function traeart(){
    rubr=document.getElementById('rubro').value;
    if(rubr>"0") document.getElementById('articulo').innerHTML = ejec("ej_tablas","ARTICULO_SELECT","&rubro="+rubr);
}
function despliega_movimientos(){
   arti=document.getElementById("articulo").value; 	
   if(arti<1) {alert("debe seleccionar articulo");return false;};
   efec=document.getElementById("efector").value; 	
   if(efec<1) {alert("debe seleccionar efector");return false;};
   document.getElementById("tabla").innerHTML=ejec("browser_remitos","ENTREGAS","&articulo="+arti+"&efector="+efec);
}
seleccionar("rubro",<?php echo $rubro;?>);
traeart();
seleccionar("articulo",<?php echo $articulo;?>);
seleccionar("efector",<?php echo $efector;?>);
</script>
</div>
</div>
<script src="bootstrap-3.3.6-dist/js/jquery.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
</body>