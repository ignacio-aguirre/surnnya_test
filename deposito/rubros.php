<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Rubros";
include("encabezado.php");?>
<div class="container">
<div class="row">
  <div class="col-md-6"><button class='btn btn-info' onclick=navega('rubros_nuevo')>Nuevo</button></div>
</div>
<h4>Consultar</h4>
<div class="row">
<form class="form col-md-6" onsubmit="return false">
  <div class="form-group has-warning">
	<label class="label-form">Filtro</label><br>
	<input class="form-control" id='frase' maxlength='45'>
  </div>
  <button class="btn-primary btn" onclick="despliega_rubros()">Buscar</button>&nbsp;
  <button class="btn-success btn" onclick="excel_rubros()">Excel</button>
  </div>
</form>
<hr>
<div class="table-responsive" id="tabla">
</div> 
<script src='js/particulares.js'></script>
<script>
function despliega_rubros(){
    valida_0("frase");	
    frase=document.getElementById('frase').value;
    resp=ejec("browser_tablas","RUBROS","&frase="+frase);	
    document.getElementById("tabla").innerHTML=resp;
}
function excel_rubros(){
    navega("rubros_excel");
}
</script>
</div>
</body>