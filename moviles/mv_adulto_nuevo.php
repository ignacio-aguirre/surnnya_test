<?php
session_start();
include("funciones.php");
$_SESSION["prestacion"]="Nuevo adulto";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};

?>
</div>
<div class="container">
<h4>Nuevo adulto para <strong><?php echo $ndispo?></strong></h4>
<form class="form" method="get" onsubmit="return valida_formulario()" action="mv_adulto_nuevo_do">     <input hidden name="dispositivo" value="<?php echo $dispositivo?>"> <input hidden name="td" value="<?php echo $tdispo?>">

    <div class="row">
    <div class="form-group col-md-6 has-warning">
        <label class="label-form">Apellido</label>
        <input class="form-control" id="apellido" name="apellido" size="50" maxlength="50" required autofocus>
    </div>
    <div class="form-group col-md-6 has-warning">
        <label class="label-form">Nombre</label>
        <input class="form-control" id="nombre" name="nombre" size="50" maxlength="50" required>
    </div>
    
</div>
<div class="row">
   
    <div class="form-group has-warning col-md-4">
        <label class="label-form">Celular</label>
        <input class="form-control" id="celular" name="celular"  required size="20" maxlength="30">
    </div>
    </div>
    <div class="row">
    <br><br>
    
    <div class="form-group has-warning col-md-4">
        
        <button class="btn-success">Guardar</button>
    </div>    
</div>
</form>

<script>
    

function valida_formulario(){
    
    status("");
    return true;

}    
</script>
</div>
</html>
	
