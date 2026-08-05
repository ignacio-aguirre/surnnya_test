<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Editar datos de adulto";
include("encabezado.php");
$dispositivo=$_SESSION["hogar"];
$ndispo=un_campo("select nombre from dispositivos where id=".nulea($dispositivo));
$tdispo="d";
if(!$dispositivo>"0"){
    $dispositivo=$_SESSION["sector"];
    $ndispo=un_campo("select denominacion from sectores where id=".nulea($dispositivo));
    $tdispo="s";
};

$id=nget("id");
$a=un_registro("select * from movil_adultos where id=".$id);

?>
</div>
<div class="container">
    <div class="row">
        <h4 class="col-md-6">Datos de <?php echo $a["apellido"].", ".$a["nombre"]?></h4>
    </div>
    <form class="form" onsubmit="return valida_formulario()" method="get" action="mv_adulto_editar_do">
        <input hidden name="id" value="<?php echo $id?>">
        <div class="row">
        <div class="form-group has-warning col-md-6">
            <label class="label-form">Apellido</label>
            <input class="form-control" name="apellido" id="apellido" onblur="valida_0(this.id)" value="<?php echo $a['apellido']?>" required autofocus>
        </div>
        <div class="form-group has-warning col-md-6">
            <label class="label-form">Nombre</label>
            <input class="form-control" name="nombre" id="nombre" onblur="valida_0(this.id)" value="<?php echo $a['nombre']?>" required >
        </div>
        </div>
        <div class="row">
        <div class="form-group has-warning col-md-6">
            <label class="label-form">Celular</label>
            <input class="form-control" name="celular" id="celular" onblur="valida_0(this.id)" value="<?php echo $a['celular']?>" required >
        </div>
        </div>
        <button class="btn-success">Guardar</button>
    </form>
</div>

<script>
    function valida_formulario(){
        status("");
        return true;
    }
</script>
</body>    