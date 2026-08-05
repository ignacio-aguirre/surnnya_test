<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Emisión de documento de viajes aprobados y cancelados";
include("encabezado.php");

?>
</div>
<br><br>
<div class="container">
    <form class="form-inline" method="get" onsubmit="return false">
        <div class="form-group has-warning col-md-4">
            <label class="label-form">Fecha Desde</label>
            <input class="form-control" id="fini" name="fini" required autofocus type="date" value="<?php echo $_SESSION["hoy_c"]?>">
        </div>
        <div class="form-group has-warning col-md-4">
            <label class="label-form">Fecha Hasta</label>
            <input class="form-control" id="ffin" name="ffin" required autofocus type="date" value="<?php echo $_SESSION["hoy_c"]?>">
        </div>
        <div class="form-group has-warning col-md-4">
         <button class="btn-success" onclick="excel()">Excel</button>&nbsp;   
     </div>
    </form>    
</div>
<script>
    function excel(){
    fini=document.getElementById("fini").value;
    ffin=document.getElementById("ffin").value;
    fin=fini.replaceAll("-","");
    ffi=ffin.replaceAll("-","");
    naveganuevo("mv_generar_descarga?fini="+fin+"&ffin="+ffi);
    return true;
}
</script>

           