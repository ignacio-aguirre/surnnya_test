<?php
include("Funciones.php");
session_start(); 
$_SESSION["prestacion"]="Eliminar Egreso de Hogar";
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado-test.php");
$id=$_GET["id"];
$sql="select concat(apellidos,', ',nombres) as apyn,vacante, altasybajas.legajo,fecha_operacion, hogar,nombre as dhogar from altasybajas left join sujetos on sujetos.legajo=altasybajas.legajo left join dispositivos on dispositivos.id=altasybajas.hogar where idaltasybajas=".$id;
$r = un_registro($sql);
$legajo=$r["legajo"];
$hogar=$r["hogar"];
$vacante=$r["vacante"];
if($vacante=="") die("ya no existe esta baja");
$baja=ffec($r["fecha_operacion"]);

if (isset($_GET['submit'])) {
ejecute("update hogares_admision set admi_baja=null, permanencia=0 ,admi_mote=null where idhogares_admision=".$vacante);
ejecute("insert into altasybajas_log (legajo,hogar,operacion,fecha_operacion,accion,fecha_accion,usuario) values(".$legajo.",".$hogar.",'B',".fsql($baja).",'Eliminar',curdate(),".tsql($_SESSION["glusua"]).")");
ejecute("delete from altasybajas where idaltasybajas=".$id);
//presencialidad
$regaelim=un_campo("select max(id) from alojados_presencia where vacante=".$vacante);
ejecute("delete from alojados_presencia where id=".$regaelim);
$regnuev=un_campo("select max(id) from alojados_presencia where vacante=".$vacante);
$rn=un_registro("select * from alojados_presencia where id=".$regnuev);
ejecute("update hogares_admision set presencialidad=".$rn["estado"].", fecha_presencialidad=".fsql(ffec($rn["fecha_estado"]))." where idhogares_admision=".$vacante);
Redirect("admiconsbajas");}
?>
<script>
function valida_datos(){
cantidad=ejec("sq_altasbajas","1","&legajo=<?php echo $legajo?>");
if(parseInt(cantidad)>0) {alert("Hay un alojamiento en curso, no puede eliminarse esta baja"); return false;};
ultimabaja=ejec("sq_altasbajas","2","&legajo=<?php echo $legajo?>");
if(fsql(ultimabaja)>fsql("<?php echo $baja?>")){alert("No es el último tramo de alojamiento no puede eliminarse esta baja");return false;};
return true;
};
</script>
</div>
<div class="container">
<form class="form-inline" onsubmit="return valida_datos()" method='get' action='admiborrabaja'>
<div class="form-group has-warning">
Apellidos: <strong><?php echo $r["apyn"];?></strong><br>
Fecha Baja:<strong><?php echo $baja;?></strong><br>
Hogar: <strong><?php echo $r["dhogar"];?></strong><br><br>
<input type="hidden" name='id' value='<?php echo $id;?>'/>
<input class="form-control" name="submit" id='sub' type="submit" value="Eliminar" />
</div>
</form>
</div>
</body>
</html>