<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Perfiles";
if ($_SESSION['gl_usuarios']!="1") redirect('error_noautorizado');
include("encabezado-test.php");
$id= nget("id");
$sql="select * from perfiles where id=".$id;
$reg=registros($sql);;
$cant=mysqli_num_rows($reg);
$denominacion="";
$menu_nuevo="";
$soloconsulta="";
$todos_dispo="";
$nuevo_sujeto="";
$editar_sujeto="";

$acciones="";

$admision="";
$super_supervisar="";
$tabla_hogares="";
$tabla_ongs="";
$editar_dispositivos="";
$usuarios="";
$definicion="";
if ($cant>0) {
  $r = mysqli_fetch_assoc($reg);
  $denominacion=$r["denominacion"];
  $menu_nuevo=$r["menu_nuevo"];
  $soloconsulta=$r["soloconsulta"];

  $acciones=$r["acciones"];
  $nuevo_sujeto=$r["nuevo_sujeto"];
  $editar_sujeto=$r["editar_sujeto"];
  $todos_dispo=$r["todos_dispo"];

  $admision=$r["admision"];
  $super_supervisar=$r["super_supervisar"];
  $usuarios=$r["usuarios"];
  $tabla_hogares=$r["tabla_hogares"];
  $tabla_ongs=$r["tabla_ongs"];
  $editar_dispositivos=$r["editar_dispositivos"];
  $definicion=$r["definicion"];
};
?>
</div>
<div class="container">

<form class="form" method='post' action='perfilactualiza'>
<div class="form-group has-warning">
<label class="label-form" for="denominacion">Nombre del Perfil</label>
<input class='form-control' name='denominacion' id='denominacion' value='<?php echo $denominacion;?>' required autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form" for="menu_nuevo">Men&uacute; Inicial</label>
<select class="form-control" name="menu_nuevo" id="menu_nuevo" required>
<?php
 $men=registros("select * from menues order by nombre");
 while($m=mysqli_fetch_assoc($men)){
  echo "<option value='".$m["idmenues"]."'>".$m["nombre"]."</option>";
 };
?> 
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="soloconsulta">Permiso General</label>
<select class="form-control" name="soloconsulta" id="soloconsulta" required>
<option value='1'>Consulta</option>
<option value='0'>Carga</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="todosdispo">Puede Consultar M&uacute;ltiples Sectores (en desuso)</label>
<select class="form-control" name="todos_dispo" id="todos_dispo" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="nuevo_sujeto">Puede crear legajos de NNYA</label>
<select class="form-control" name="nuevo_sujeto" id="nuevo_sujeto" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="editar_sujeto">Puede editar datos de legajos de NNYA</label>
<select class="form-control" name="editar_sujeto" id="editar_sujeto" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>

<div class="form-group has-warning">
<label class="label-form" for="acciones">Puede registrar acciones de la intervenci&oacute;n con NNYA</label>
<select class="form-control" name="acciones" id="acciones" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="admision">Tiene pleno acceso a las funciones de Admisi&oacute;n</label>
<select class="form-control" name="admision" id="admision" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="super_supervisar">Puede registrar Visitas de Supervisi&oacute;n</label>
<select class="form-control" name="super_supervisar" id="super_supervisar" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="tabla_hogares">Puede registrar Acciones con Dispositivos de Cuidado</label>
<select class="form-control" name="tabla_hogares" id="tabla_hogares" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="tabla_ongs">Tiene acceso al Registro de ONGs</label>
<select class="form-control" name="tabla_ongs" id="tabla_ongs" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="tabla_ongs">Registro de ONGs editar dispositivos</label>
<select class="form-control" name="editar_dispositivos" id="editar_dispositivos" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>

<div class="form-group has-warning">
<label class="label-form" for="usuarios">Puede crear y modificar datos de Usuarios y Perfiles de Usuarios</label>
<select class="form-control" name="usuarios" id="usuarios" required>
<option value='0'>No</option>
<option value='1'>S&iacute;</option>
</select>
</div>
<div class="form-group has-warning">
<label class="label-form" for="definicion">Definici&oacute;n breve</label>
<input class="form-control" name="definicion" id="definicion" value="<?php echo $r['definicion']?>" maxlength="100">
</div>
<input type='hidden' name='id' value='<?php echo $id;?>'><br>
<input class="bg-primary" type='submit' value='Aceptar'>


</form>
<script langtype='text/javascript'>
seleccionar('menu_nuevo','<?php echo $menu_nuevo;?>');
seleccionar('soloconsulta','<?php echo $soloconsulta;?>');
seleccionar('todos_dispo','<?php echo $todos_dispo;?>');
seleccionar('nuevo_sujeto','<?php echo $nuevo_sujeto;?>');
seleccionar('editar_sujeto','<?php echo $editar_sujeto;?>');
seleccionar('subir_archivos','<?php echo $subir_archivos;?>');
seleccionar('acciones','<?php echo $acciones;?>');
seleccionar('admision','<?php echo $admision;?>');
seleccionar('super_supervisar','<?php echo $super_supervisar;?>');
seleccionar('tabla_hogares','<?php echo $tabla_hogares;?>');
seleccionar('tabla_ongs','<?php echo $tabla_ongs;?>');
seleccionar('editar_dispositivos','<?php echo $editar_dispositivos;?>');
seleccionar('usuarios','<?php echo $usuarios;?>');
</script>


</div>

</body>



</html>