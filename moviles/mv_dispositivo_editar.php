<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Editar datos de dispositivo";
include("encabezado.php");
$id=nget("id");
$d=un_registro("select * from dispositivos where id=".$id);
?>
</div>
<br>
<div class="container">
    <div class="row">
        <h4 class="col-md-6">Datos de <?php echo $d["nombre"]?></h4>
    </div>
    <form class="form" onsubmit="return valida_formulario()" method="get" action="mv_dispositivo_editar_do">
        <input hidden name="id" value="<?php echo $id?>">
        <div class="row">
        <div class="form-group has-warning col-md-6">
            <label class="label-form">Empresa</label>
            <select class="form-control" name="transporte" id="transporte" required autofocus>
                <?php
                    
                    $emp=registros("select deno,valo from tablas where tipo='ETRA' order by deno");
                    while($e=mysqli_fetch_assoc($emp)){
                        echo "<option value='".$e["valo"]."'>".$e["deno"]."</option>";
                    }
                ?>
            </select>
        </div>
        <script>seleccionar("transporte","<?php echo $d['transporte']?>")</script>
        
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