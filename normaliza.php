<?php
session_start();
include("Funciones.php");
include("encabezado-test.php");
$direccion=$_GET["direccion"];
?>
</div>
<script>
calle="<?php echo $direccion?>";
calle=calle.replace("Ñ","N").replace("ñ","n")+", CABA";
resp=ejec_sq("https://servicios.usig.buenosaires.gob.ar/normalizar/?direccion="+calle+"&maxOptions=25&geocodificar=true");
alert(resp);
</script>