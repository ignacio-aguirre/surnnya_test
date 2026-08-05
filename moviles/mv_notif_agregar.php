<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Emisión de documento de viajes agregados";
include("encabezado.php");
$id=nget("id");
echo "<script>
    naveganuevo('mv_generar_envio_do?id=".$id."&titulo=AGREGAR');
</script>";
ejecute("update movil_viajes set bandeja=7, lote_envio=".$_SESSION["idproceso"].", estado='APR' where id=".$id);
?>
</div>
<br><br>
<div class="container">
    
    <button class="btn-success" onclick="navega('mv_gestiones')">Volver</button>&nbsp;
</div>
<script>
    
    



function mail(id){
    //navega("mv_mail_agregar?id="+id)
}
</script>

           