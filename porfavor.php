<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Esperar finalizaci&oacute;n de Proceso Autom&aacute;tico";
include("encabezado-test.php");
$url=$_GET["url"];
?>
</div>
<div class="container">
Por favor espera un momento. Se est&aacute; realizando el proceso autom&aacute;tico <strong>
<?php echo un_campo("select proc_deno from procesos where proc_url=".tsql($url))?></strong>
<br>Cuando finalice, ser&aacute;s redirigido/a al men&uacute;
<script>
setTimeout(navega("<?php echo $url?>"),1000);
</script>
</div>
</body>
</html>