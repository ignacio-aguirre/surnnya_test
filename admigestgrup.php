<?php
include("Funciones.php");
session_start();
noconsulta();
$_SESSION["Prestacion"]="Gesti&oacute;n de Recurso";
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
$grup=$_GET["igru"];
include("encabezado-test.php");
if(isset($_GET['fecha'])) {
  $reg=registros("select admi_legajo, idhogares_admision as admi, etapa, fecha_etapa, admi_hogar from hogares_admision 
   left join sujetos on legajo=admi_legajo left join grupos_legajos on grupos_legajos.grupo_legajo=admi_legajo
   left join grupos on grupo=idgrupos
   where grupo=".$grup." and admi_cate in (4,6) and admi_fderiv is null and admi_fped is not null and  admi_susp is null and admi_alta is null");
  $lista_ids="("; 
  while ($le = mysqli_fetch_assoc($reg)) {
    $sql="insert into intervenciones (inter_admision, inter_fecha, inter_usuario, inter_oper, inter_obse,inter_grupo, inter_tipo,inter_dispo,inter_legajo,fechahora) 
     values(".$le["admi"].",".fsql($_GET['fecha']).",'".$_SESSION["glusua"]."', '".$_SESSION["glusua"]."', '".$_GET["observaciones"]."','A',29,".$_SESSION["gldispo"].",".$le["admi_legajo"].",concat(curdate(),' ',curtime()))";
    ejecute($sql);
    $lista_ids=$lista_ids.$le["admi"].",";
  };
  $lista_ids=$lista_ids."0)";
  $reg=registros("select idhogares_admision as admi, etapa, fecha_etapa, admi_hogar from hogares_admision where idhogares_admision in ".$lista_ids);
  while($r=mysqli_fetch_assoc($reg)){
     if(fget("fecha")>=fsql(ffec($r["fecha_etapa"]))||ffec($r["fecha_etapa"])==""){
 	$estado=$_GET["estado"];
 	$estado_anterior=si($r["etapa"]=="","0",$r["etapa"]);
 	$hogar=$_GET["hogar"];
 	if($hogar==""){$hogar="0";};
 	$hogar_anterior=si($r["admi_hogar"]=="","0",$r["admi_hogar"]); 
 	if($estado!=$estado_anterior||$hogar!=$hogar_anterior){
  	  $motivo_cambio=tget("motivo_cambio");
  	  $fecha=fget("fecha");
  	  $idestado_anterior=un_campo("select id from ad_pedidos_estados where vacante=".$r["admi"]." order by fecha desc, id desc limit 1");
  		ejecute("update ad_pedidos_estados set motivo_cambio=".$motivo_cambio." where id=".nulea($idestado_anterior));
  		inserte("insert into ad_pedidos_estados (fecha, vacante, estado, usuario, hogar) values(".$fecha.",".$r["admi"].",".nulea($estado).",".tsql($_SESSION["glusua"]).",".nulea($hogar).")");
  		ejecute("update hogares_admision set etapa=".$estado.", fecha_etapa=".$fecha.", admi_hogar=".$hogar." where idhogares_admision=".$r["admi"]);
 	};
      };
  };
Redirect("admicons");
};
$r=un_registro("select admi_legajo, idhogares_admision as admi, etapa, fecha_etapa, admi_hogar from hogares_admision 
   left join sujetos on legajo=admi_legajo left join grupos_legajos on grupos_legajos.grupo_legajo=admi_legajo
   left join grupos on grupo=idgrupos
   where grupo=".$grup." and admi_cate=4 and admi_fderiv is null and admi_fped is not null and  admi_susp is null and admi_alta is null limit 1");
?>

</div>

<div class="container">

<p>Grupo de Hermanos: <strong><?php echo un_campo('select apellidos from grupos where idgrupos='.$grup)?></strong></p>

<form class="form" method='get' onsubmit='return valida_campos()'>

<div class="form-group has-warning">

<label class="label-form" for="fecha">Fecha Gesti&oacute;n</label>

<input class="form-control" size='10 maxlength='10' name='fecha' id='fecha' onblur='valida_fecha(this.id)' value="<?php echo $_SESSION["DiaHoy"]?>">

</div>

<div class="form-group has-warning">

<label class="label-form" for="observaciones">Resumen de la Gesti&oacute;n(m&aacute;ximo 2048 caracteres) - Actual:</label>

<input type='text' size='2' readonly id='usado'/><br>

<textarea class="form-control" cols='80' rows='4' name='observaciones' onkeyup='limite("observaciones","2048","usado")' onblur='valida_obse()' id='observaciones'></textarea>

<input type='hidden' name='igru' value="<?php echo $grup?>"/>

</div>
<div class="form-group has-warning">
<label class="label-form">Nuevo Estado</label>
<select class="form-control" name="estado" id="estado">
<?php echo opc_tablav("ADEV")?>
</select>
<script>
seleccionar("estado","<?php echo $r['etapa']?>");
</script>
</div>
<div class="form-group has-warning">
<label class="label-form">Hogar de la articulaci&oacute;n</label>
<select class="form-control" name="hogar" id="hogar">
<?php echo str_replace("Completar","Ninguno",$_SESSION["Opc_Hoga"])?></select>
<script>
seleccionar("hogar","<?php echo $r['admi_hogar']?>");
</script>
</div>
<div class="form-group has-warning">
	<label class="label-form">Motivo del Cambio&nbsp;</label>
	<input class="form-control" id="motivo_cambio" name="motivo_cambio" size="60" maxlength="60">
</div>


<input name='submit' id='sub' type='submit' value='Aceptar' />

</form>

<div class="table-responsive pre-scrollable">

<table class="table">

<tr class="bg-primary" style="font-size:.8em"><th>Fecha</th><th>Admisor</th><th>Detalle</th></tr>

<?php

$reg=registros("select inter_fecha, inter_obse, inter_usuario from intervenciones where inter_admision in (select idhogares_admision as admi from hogares_admision 

   left join sujetos on legajo=admi_legajo left join grupos_legajos on grupos_legajos.grupo_legajo=admi_legajo

   left join grupos on grupo=idgrupos

   where grupo=".$grup." and admi_cate=4 and admi_fderiv is null and admi_fped is not null and  admi_susp is null and admi_alta is null) order by inter_fecha desc, idintervenciones desc");

$ante="";

$fecha="";

while($r=mysqli_fetch_assoc($reg)){

 if($r["inter_obse"]!=$ante||$r["inter_fecha"]!=$fecha) {

   echo "<tr style='font-size:.8em;'><td>".ffec($r["inter_fecha"]),"</td><td>",$r["inter_usuario"],"</td><td>",$r["inter_obse"],"</td></tr>";

   $ante=$r["inter_obse"];

   $fecha=$r["inter_fecha"];

 };

};

?>

</table>

</div>

</div>

<script type="text/javascript">

enfoca("fecha");

function valida_campos() {

var sc=<?php echo $_SESSION['glcons'];?>;

if(sc=="1"){alert("Su perfil es de solo consulta"); return false;};

valida_fecha("fecha");

if(document.getElementById("fecha").value==""|document.getElementById("observaciones").value=="") return false;

fecha=fsql(document.getElementById("fecha").value);

fechahoy=fsql('<?php echo $_SESSION["DiaHoy"];?>');

if(fecha>fechahoy) {alert("Lo siento, no se permiten gestiones futuras. Gracias");return false;};

return true;

}



function valida_obse() {

var obse=document.getElementById("observaciones");

var texto=obse.value;

while (texto.indexOf("'")>-1) texto=texto.replace("'",'"');

obse.value=texto;

}

</script>



</body>

</html>