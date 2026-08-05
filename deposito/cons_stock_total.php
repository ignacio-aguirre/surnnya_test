<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Stock Total";
include("encabezado.php");?>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Rubro (vac&iacute;o para todos)</th><th>Acciones</th></tr>
<tr><td><select class="form-control" id='rubro' autofocus><?php echo opciones("articulos_rubros");?><select></td><td>
<button class='btn-primary' onclick='despliega_stock()'>Consultar</button>&nbsp;<button class='btn-success' onclick='aexcel()') >Excel</button></td></tr>
</table>
</div>
</div>
<div class="container">
<div class="table-responsive" id="tabla">
</div> 
</div> 
</div>
</div>
<script src='js/particulares.js'></script>
<script>
function despliega_stock(){
    rubr=document.getElementById('rubro').value;
    document.getElementById("tabla").innerHTML=ejec("browser_stock","STOCK","&rubro="+rubr);	
}

function movimientos(rubr,arti){
navega("cons_stock_movimientos?rubro="+rubr+"&articulo="+arti);
}

function carga_minimo(id){
if(document.getElementById(id).value>0){
	valida_entero(id);
        document.getElementById(id).value=parseInt(document.getElementById(id).value);
        arti=id;
        mini=document.getElementById(id).value;
        ejec("ej_stock","ACTUALIZA_MINIMO","&articulo="+arti+"&minimo="+mini);
};
}

function aexcel(){
navega("browser_stock?tipo=STOCK_EXCEL&rubro="+document.getElementById("rubro").value);
}
</script>
</body>