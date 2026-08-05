<?php 
include("funciones.php");
session_start();
$rubro="";
$articulo="";
if(isset($_GET['rubro'])) $rubro=$_GET['rubro'];
if(isset($_GET['articulo'])) $articulo=$_GET['articulo'];
$_SESSION["prestacion"]="Consulta Puntual de Movimientos";
include("encabezado.php");?>
<div class="container">
<form class="form-inline" onsubmit='return false' action="">
<div class="form-group pres-cdh_docid has-warning">
<label class="control-label" for="rubro">Rubro</label>
<select class="form-control" id="rubro" autofocus><?php echo opciones('articulos_rubros')?></select>
</div>
<div class="form-group pres-cdh_docid has-warning">
<label class="control-label" for="articulo">Art&iacute;culo</label>
<select class="form-control" id="articulo" onfocus='traeart()' onblur()='traetotal()'></select>
</div>
</form>
<button class='btn-primary' onclick='despliega_movimientos()'>Consultar</button><br>
<div class="table-responsive pre-scrollable" id="tabla">
</div> 
</div> 
<script>
function traeart(){
    rubr=document.getElementById('rubro').value;
    if(rubr>0) document.getElementById('articulo').innerHTML = ejec_sq("sq_arti_select?rubro="+rubr);
}
function despliega_movimientos(){
   arti=document.getElementById("articulo").value; 	
   if(arti<1) {alert("debe seleccionar articulo");return false;};
   document.getElementById("tabla").innerHTML=ejec("browser_stock","STOCK_MOVIMIENTOS","&articulo="+arti);
}
seleccionar("rubro",<?php echo $rubro;?>);
traeart();
seleccionar("articulo",<?php echo $articulo;?>);
</script>
</div>
</div>
</body>