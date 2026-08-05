<?php
session_start();
include("Funciones.php");
$_SESSION["prestacion"]="Desactivar un hogar";
include("encabezado.php");
$id=$_GET["id"];
$descripcion=un_campo("select nombre from dispositivos where dispositivos.id=".$id);
?>
</div>
<div class="container">
<p class="text-warning">Est&aacute;s por desactivar el hogar <?php echo $descripcion?>. Deber&iacute;a usarse esta opci&oacute;n cuando un hogar se cierra o no tiene m&aacute;s convenio con DGNYA. <br></p>
<button class='btn-primary' onclick='proceder()'>Proceder</button>
</div>
<script>
function proceder(){
 navega("hogar_desactivar_do?id=<?php echo $id?>");
 return true
};
</script>
</body>
