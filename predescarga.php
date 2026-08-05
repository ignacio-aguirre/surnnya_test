<?php
session_start();
include('Funciones.php');
$_SESSION["prestacion"]="Predescarga de documentos Excel";
include("encabezado-test.php");
$nombre=$_GET["nombre"];
$cuil=un_campo("select cuil from usuarios where id=".$_SESSION["glidusua"]);
$pth="archivos/temp/".$cuil."/".$nombre;
?>
<div class="container">
	<h2>Hacé click en Descargar para descargar el documento</h2>
	<h3><?php echo $nombre?></h3>
	<button class="btn-success" onclick="descargar('<?php echo $pth?>','<?php echo $nombre?>')">Descargar</button>
</div>
</body>
<script>
	function descargar(archivo,nombre){
		naveganuevo('descarga?link='+archivo+"&nombre="+nombre);
		navega("<?php echo $_SESSION['menu']?>");
	}
</script>
</html>