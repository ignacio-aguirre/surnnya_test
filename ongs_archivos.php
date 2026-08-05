<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Documentos Vinculados a la ONG";
include("encabezado-test.php");
$id=$_GET["id"];
?>
</div>
<div class="container">
<h3><?php echo un_campo("select nombre from hogares_ong where id=".$id)?></h3>
Subir Nuevo <a href="subir_archivos?ong=<?php echo $id;?>">Documento</a><br>
<h3>Documentos Vinculados</h3>
<div class="table-responsive pre-scrollable">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class='bg-primary' style='font-size:.80em;'><th>Tipo</th><th>Descripci&oacute;n</th><th>Fecha Doc.</th><th>Sector - Usuario</th><th>Fecha Subida</th><th>Acciones</th></tr></thead>
<tbody id='cuerpo'>
</tbody>
</table>
</div>
<button onclick='orden(1)'>Ordenar por Tipo</button>&nbsp;&nbsp;<button onclick='orden(2)'>Ordenar por Fecha</button>
</body>
<script>
orden(2);
function orden(ord){
document.getElementById("cuerpo").innerHTML=ejec("ej","CONS_ARCHIVOS_ONG","&orden="+ord+"&ong=<?php echo $id;?>");
return true;
}
</script>
</div>
</body>
</html>