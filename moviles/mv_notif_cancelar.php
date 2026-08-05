<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Emisión de documento de viajes aprobados y cancelados";
include("encabezado.php");
$id=nget("id");
echo "<script>
    naveganuevo('mv_generar_envio_do?id=".$id."&titulo=CANCELAR');
</script>";
?>
</div>
<br><br>
<div class="container">
    
    <button class="btn-success" onclick="navega('mv_gestiones')">Mail</button>&nbsp;
</div>
    
<script>
function mail(id){
    //navega("mv_mail_cancelacion?id="+id);
}
</script>

           