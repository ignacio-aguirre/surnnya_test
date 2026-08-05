<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="B&uacute;squeda de Art&iacute;culos";
include("encabezado.php");?>
<div class="container">
<div class="row">
  <div class="col-md-6"><button class='btn btn-info' onclick=navega('articulos_nuevo')>Nuevo</button></div>
</div>
<h4>Consultar</h4>
<div class="row">
<form class="form col-md-6" onsubmit="return false">
  <div class="form-group has-warning">
	<label class="label-form">Rubro (vac&iacute;o=Todos)</label>
	<select class="form-control" id="rubro" autofocus><?php echo opciones("articulos_rubros");?></select>
  </div>
  <div class="form-group has-warning">
	<label class="label-form">Filtro</label><br>
	<input class="form-control" id='frase' maxlength='45'>
  </div>
  <button class="btn-primary btn" onclick="despliega_articulos()">Buscar</button>&nbsp;
  <button class="btn-success btn" onclick="excel_articulos()">Excel</button>
  </div>
</form>
<hr>
<div class="table-responsive" id="tabla">
</div> 
<script src='js/particulares.js'></script>
<script>
function despliega_articulos(){
    valida_0("frase");	
    rubr=document.getElementById('rubro').value;
    frase=document.getElementById('frase').value;
    resp=ejec("browser_tablas","ARTICULOS_BUSQUEDA","&rubro="+rubr+"&frase="+frase);	
    document.getElementById("tabla").innerHTML=resp;
}
function excel_articulos(){
    rubr=document.getElementById('rubro').value;
    navega("articulos_excel?rubro="+rubr);
}

function descarga(id){
naveganuevo("archivo_descarga?id="+id);
};

function subir(id){
navega("archivo_subir?tipo=ARTIC&id="+id+"&referencia=ART."+id+"&retorno=articulos");
}
</script>
</div>
</body>