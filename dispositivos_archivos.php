<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Documentos Vinculados al Dispositivo";
include("encabezado.php");
$id=$_GET["id"];
?>
</div>
<div class="container">
<h3><?php echo un_campo("select nombre from dispositivos where dispositivos.id=".$id)?></h3>
Subir Nuevo <a href="subir_archivos?hogar=<?php echo $id;?>&ret=dispositivos_archivos">Documento</a><br>
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
texto=ejec("ej","CONS_ARCHIVOS_DISPOSITIVO","&orden="+ord+"&dispositivo=<?php echo $id;?>");
document.getElementById("cuerpo").innerHTML=texto;
return true;
}
</script>
</div>
</body>
</html>