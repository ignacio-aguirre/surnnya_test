<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Editar Datos Familia";
registre();
include("encabezado.php");
$id=$_GET["id"];
$r=un_registro("select * from af_familias where idaf_familias=".$id);
?>
</div>
<div class="container">
<button class="btn-info" onclick="navega('af_familias_grupos?id=<?php echo $id?>')">Ir a Grupo Familiar</button><br><br>
<form class="form-inline" method="GET" action="af_familias_editar_do" onsubmit="return valida()">
  <div class="form-group has-warning">
    <label class="label-form" for="hogar">Dispositivo</label>
    <select class="form-control" id='hogar' name='hogar'><?php echo $_SESSION['Opc_Hoga_AF'];?></select>
    <script>seleccionar("hogar","<?php echo $r['hogar']?>");</script>
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="denominacion">Denominaci&oacute;n (apellido/s)</label>
    <input class="form-control" id="denominacion" name="denominacion" size="30" maxlength="45" onblur='valida_0(this.id)' value="<?php echo $r['denominacion']?>">
  </div>
  <h3>Solo para familias Admitidas</h3>
  <div class="form-group has-warning">
    <label class="label-form" for="disposicion">Disposici&oacute;n</label>
    <input class="form-control" name="disposicion" id="disposicion" size="30" maxlength="45" onblur="valida_0(this.id)" value="<?php echo $r['disposicion']?>">
  </div>
  <div class="form-group has-warning">
    <label class="label-form" for="fecha_disposicion">Fecha de Alta</label>
    <input class="form-control" id="fecha_disposicion" name="fecha_disposicion" maxlength="10" size="8" onblur="valida_fecha(this.id,1)" value="<?php echo ffec($r['fecha_disposicion'])?>">
  </div> 
  <div class="form-group has-warning">
    <label class="label-form" for="registro_unico">N&uacute;mero Legajo SAF / A&ntilde;o</label>
    <input class="form-control" name="registro_unico" id="registro_unico" type="number" min="0" max="999999" value="<?php echo $r['registro_unico']?>">
    <input class="form-control" name="anio" id="anio" type="number" min="2022" max="2027" value="<?php echo $r['anio']?>">
  </div>	
  <h3>Datos de la persona referente</h3>
  <p class="text-warning">Los datos de la persona referente se modifican desde el men&uacute; de personas</p>
  Apellido y Nombre <strong> <?php echo un_campo("select concat(apellidos,', ',nombres) from personas where idpersonas=".$r["persona"]);?>
  <h3>Capacitaciones realizadas</h3>
  <div class="form-group has-warning">
    <label class="label-form" for="cp_rcp">RCP - Fecha</label>
    <select class="form-control" id='cp_rcp' name='cp_rcp'><option value='0'>No</option><option value='1'>S&iacute;</option></select>
    <script>seleccionar("cp_rcp","<?php echo $r['cp_rcp']?>");</script>
    <input class="form-control" id='cp_rcp_fecha' name='cp_rcp_fecha' size='10' maxlength='10' onblur='valida_fecha(this.id,1)' value="<?php echo ffec($r['cp_rcp_fecha'])?>">
  </div><br><br>
  <div class="form-group has-warning">
    <label class="label-form" for="cp_rcp">Rol - Fecha</label>
    <select class="form-control" id='cp_rol' name='cp_rol'><option value='0'>No</option><option value='1'>S&iacute;</option></select>
    <script>seleccionar("cp_rol","<?php echo $r['cp_rol']?>");</script>
    <input class="form-control" id='cp_rol_fecha' name='cp_rol_fecha' size='10' maxlength='10' onblur='valida_fecha(this.id,1)' value="<?php echo ffec($r['cp_rol_fecha'])?>">
  </div><br><br>
  <div class="form-group has-warning">
    <label class="label-form" for="cp_rcp">Marco Legal - Fecha</label>
    <select class="form-control" id='cp_marcolegal' name='cp_marcolegal'><option value='0'>No</option><option value='1'>S&iacute;</option></select>
    <script>seleccionar("cp_marcolegal","<?php echo $r['cp_marcolegal']?>");</script>
    <input class="form-control" id='cp_marcolegal_fecha' name='cp_marcolegal_fecha' size='10' maxlength='10' onblur='valida_fecha(this.id,1)' value="<?php echo ffec($r['cp_marcolegal_fecha'])?>">
  </div><br><br>
  <input hidden name="id" value="<?php echo $id?>">
  <br><br> 
  <button class="btn-primary btn-md">Actualizar</button>
</form>
<hr>
</div>
<script>
function valida(){
 valida_0("denominacion");
 if(document.getElementById("denominacion").value==""){alert("Completa la denominacion");return false;};
 valida_fecha("fecha_disposicion",1);
  return true;
}
enfoca("denominacion");
</script>
</body>
</html>