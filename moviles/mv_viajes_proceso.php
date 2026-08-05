<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Emisión de documentos de viajes aprobados";
include("encabezado.php");

?>
</div>
<br><br>
<div class="container">
    <form class="form-inline" method="get" onsubmit="return false">
        <div class="form-group has-warning col-md-4">
            <label class="label-form">Fecha Proceso</label>
            <input class="form-control" id="fecha" name="fecha" required autofocus type="date" value="<?php echo $_SESSION["hoy_c"]?>">
        </div>
        <div class="form-group has-warning col-md-4">
         <button class="btn-success" onclick="excel()">Excel</button>&nbsp;   
     </div>
    </form>    
</div>
<script>
    function excel(){
    fecha=document.getElementById("fecha").value;
    fec=fecha.replaceAll("-","");

    naveganuevo("mv_generar_envio_do?fecha="+fec);
    return true;
}
</script>

           