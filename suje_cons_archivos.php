<?php
session_start();
include('Funciones.php');
$_SESSION['prestacion']="Archivos Subidos al Legajo";
include('encabezado.php');
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: index");
registre();
$lega= $_GET["legajo"];
$tipo="";
if ($lega=="" ) Redirect("Location: consultasujetos");
if (isset($_GET["tipo"])) $tipo=$_GET["tipo"] ;
$_SESSION["posicion"]="5";
include("mnu_superior.php");
?>
<div>
<div class="container">
Subir Nuevo <a href="subir_archivos?legajo=<?php echo $lega;?>">Archivo</a>&nbsp&nbsp(**NO SUBIR MEDIDAS POR ESTA PANTALLA**)<br>
<h2>Archivos Vinculados</h2>
<div class="table-responsive pre-scrollable">
<table class="table table-striped table-bordered table-condensed">
<thead><tr class='bg-primary' style='font-size:.80em;'><th>Tipo</th><th>Descripci&oacute;n</th><th>Fecha Doc.</th><th>Efector - Usuario</th><th>Fecha Subida</th><th>Acciones</th></tr></thead>
<tbody id='cuerpo'>
</tbody>
</table>
</div>
<button onclick='orden(1)'>Ordenar por Tipo</button>&nbsp;&nbsp;<button onclick='orden(2)'>Ordenar por Fecha</button>
</body>
<script>
orden(2);
function orden(ord){
document.getElementById("cuerpo").innerHTML=ejec("ej","CONS_ARCHIVOS","&orden="+ord+"&legajo="+"<?php echo $lega;?>");
return true;
}
</script>
</html>