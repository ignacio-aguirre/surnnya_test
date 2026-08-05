<?php 
include("funciones.php");
session_start();
$id=nget("id");
$baja=(isset($_GET["baja"]));
$marca=si($baja," READONLY","");
$_SESSION["prestacion"]=si($baja,"Eliminar","Editar")." Usuario";
include("encabezado.php"); 
$r=un_registro("select * from usuarios where idusuarios=".$id);
?>
<div class="container">
<form class="form-inline" onsubmit="return <?php echo si($baja,'baja()','valida()')?>" action="usuarios_do" method="GET">
   <input name="id" hidden value="<?php echo $id?>">
   <div class="row">
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="apellido">Apellido</label>
    <input <?php echo $marca?> class="form-control" id='apellido' name='apellido' size="45" maxlength='45' onblur='valida_0(this.id)' required value="<?php echo $r["apellido"]?>">
   </div>
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="nombre">Nombre</label>
    <input <?php echo $marca?> class="form-control" id='nombre' name='nombre' size="45" maxlength='45' onblur='valida_0(this.id)' required value="<?php echo $r["nombre"]?>">
   </div></div><br><br>
   <div class="row">
   <div class="form-group has-warning col-md-3">
    <label class="label-form" for="cuil">CUIL</label>
    <input <?php echo $marca?> class="form-control" id='cuil' name='cuil' size="11" maxlength='11' onblur='validaCuit(this.id)' placeholder="sin guiones" required value="<?php echo $r["cuil"]?>">
   </div>
   <div class="form-group has-warning col-md-3">
    <label class="label-form" for="email">Email</label>
    <input <?php echo $marca?> class="form-control" id='email' name='email' size="30" maxlength='45' onblur='valida_mail(this.id)' required  value="<?php echo $r["email"]?>">
   </div>
   </div><br><br>
   <div class="row">
   <div class="form-group has-warning col-md-4">
    <label class="label-form" for="rol">Rol</label>
    <select <?php echo $marca?> class="form-control" id='rol' name='rol' required>
     <option value=""></option>
     <option value="2">Adm.Dep&oacute;sito</option>
     <option value="1">Adm.Sistema</option>
    </select>
    <script>seleccionar("rol","<?php echo $r['rol']?>");</script>
   </div></div><br><br>
   <button class=<?php echo si($baja,"'btn btn-danger'>Eliminar","'btn btn-primary'>Guardar")?></button>
</form>
</div>
<script>
function valida(){
return true;
}
function baja(){
  navega("ej_tablas?tipo=USUARIOS_BAJA&id=<?php echo $id?>");
  return false;
}
</script>
</body>
</html>



