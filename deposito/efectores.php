<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Efectores";
include("encabezado.php")?>
<div class="container">
<button class='btn btn-primary' onclick=navega('efectores_nuevo')>Nuevo</button>&nbsp;
<button class='btn btn-success' onclick=navega('efectores_excel')>Excel</button>
<div class="table-responsive pre-scrollable" id="tabla">
</div> 
</div> 
</div>
</div>
<script>
resp=ejec("browser_tablas","EFECTORES","");	
document.getElementById("tabla").innerHTML=resp;
</script>
</body>