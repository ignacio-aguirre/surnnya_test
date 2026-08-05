<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Eliminar Ingreso a Hogar";
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado-test.php");
$id=$_GET["id"];
$sql="select legajo, fecha_operacion, hogar,vacante from altasybajas  where idaltasybajas=".$id;
$r = un_registro($sql);
$legajo=$r["legajo"];
$hogar=$r["hogar"];
$fecha=fsql(ffec($r["fecha_operacion"]));
$vacante=$r["vacante"];
if($vacante=="") die("ya no existe esta alta");
if (isset($_GET['submit'])) {
ejecute("update hogares_admision set baja_anterior=null, admi_alta=null, perm_anterior=0, permanencia=0  where idhogares_admision=".$vacante);
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$hogar.",'A',".$fecha.",'Eliminar',curdate(),".tsql($_SESSION["glusua"]).")");
ejecute("delete from altasybajas where idaltasybajas=".$id);
//presencialidad
ejecute("delete from alojados_presencia where vacante=".$vacante);
ejecute("update hogares_admision set presencialidad=0, fecha_presencialidad=null where idhogares_admision=".$vacante);

Redirect("admiconsaltas");}
?>
</div>
<div class="container">
<form class="form-inline" method='get'>
<div class="form-group has-warning">
Apellido y Nombre: <strong><?php echo un_campo("select concat(apellidos,', ',nombres) from sujetos where legajo=".$legajo);?></strong><br>
Fecha Alta:<strong><?php echo ffec($r["fecha_operacion"]);?></strong><br>
Hogar: <strong><?php echo un_campo("select nombre from dispositivos where id=".$hogar);?></strong><br><br>
<input type="hidden" name='id' value='<?php echo $id;?>'/>
<input class="form-control" name="submit" id='sub' type="submit" value="Eliminar" />
</div>
</form>
</div>
</body>
</html>