<?php 
include("funciones.php");
session_start();
if(!isset($_SESSION["hogar"])){Redirect(".");};
if(!$_SESSION["hogar"]>"0"){Redirect(".");};
$status="";
if(isset($_GET['status'])) $status=$_GET['status'];
if($status=='ErrPerm') $status='No tiene acceso a la prestaci&oacute;n elegida';
$_SESSION["prestacion"]="N&oacute;mina de Alojados ".un_campo("select nombre from dispositivos where id=".$_SESSION["hogar"]);
include("encabezado.php");
echo $status;?>
</div>
<div class="container">
<div class="table-responsive col-md-12">
<table  class="table table-hover table-condensed">
<thead id="enca">
<tr class="bg-primary"><th>Apellidos</th><th>Nombres</th><th>Ingreso</th><th>Egreso</th><th>Carga</th><th>Acciones</th></tr>
</thead>
<tbody id="datos">
<script>
function actualizar(nnya){
hogar="<?php echo $_SESSION['hogar'];?>";
if(hogar=="0") hogar=document.getElementById("hogar").value;
navega("actualizar?nnya="+nnya+"&hogar="+hogar);
return true;

}

function firmar(informe){
if(confirm("Firmas el informe?")){
ejec("ej_sistema","FIRMAR","&id="+informe);
navega("nomina");
};
return true;
}
</script>
<?php
$hogar=$_SESSION["hogar"];
$trimestre=$_SESSION["trimestre"];
$anio=$_SESSION["anio"];
$desde=$anio.si($trimestre=="1","01",si($trimestre=="2","04",si($trimestre=="3","07","10")))."01";
$hasta=$anio.si($trimestre=="1","0331",si($trimestre=="2","0630",si($trimestre=="3","0930","1231")));
$reg=registros("select idalojados, sujetos.*, admi_alta,admi_baja, datediff(".$hasta.",f_nacimiento)/365.25 as edadaprox from hogares_admision  
left join sujetos on admi_legajo=sujetos.legajo 
left join alojados on admi_legajo=idsurnnya where admi_hogar=".$hogar." and admi_alta<=".$hasta." and (admi_baja is null or admi_baja>=".$desde.") order by apellidos, nombres, admi_alta desc");
$ante=0;
$cont=0;
while($r=mysqli_fetch_assoc($reg)){
 if($ante!=$r["idalojados"]){
   $cont=$cont+1;
   $ante=$r["idalojados"];
   $cargados="";
  
   echo "<tr><td>".$r["Apellidos"]."</td><td>".$r["Nombres"]."</td><td>".ffec($r["admi_alta"])."</td><td>".ffec($r["admi_baja"]).
   "</td><td>";
   if(un_campo("select id from trim_identidad where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>IDE </span></strong>";} else{echo "<span class='text-danger'>IDE </span>";};
   if(un_campo("select id from trim_juridicos where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>A/L </span></strong>";} else{echo "<span class='text-danger'>A/L </span>";};
   if(un_campo("select id from trim_ingreso where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>ING </span></strong>";} else {echo "<span class='text-danger'>ING </span>";};
   if(un_campo("select id from trim_convivencial where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>CON </span></strong>";} else {echo "<span class='text-danger'>CON ";};
   if(un_campo("select id from trim_salud_fisica where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>SAF </span></strong>";} else{echo "<span class='text-danger'>SAF </span>";};
   if(un_campo("select id from trim_salud_mental where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>SAM </span></strong>";} else{echo "<span class='text-danger'>SAM </span>";};
   if(un_campo("select id from trim_discapacidad where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>DIS </span></strong>";} else{echo "<span class='text-danger'>DIS </span>";};
   if(un_campo("select id from trim_educacion where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>EDU </span></strong>";} else{echo "<span class='text-danger'>EDU </span>";};
   if($r["edadaprox"]>="16"){
   if(un_campo("select id from trim_trayectos where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>E/F </span></strong>";} else{echo "<span class='text-danger'>E/F </span>";};
   };
   if(un_campo("select id from trim_actividades where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>ACT </span></strong>";} else{echo "<span class='text-danger'>ACT </span>";};
   if(un_campo("select id from trim_vinculaciones where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>VIN </span></strong>";} else{echo "<span class='text-danger'>VIN </span>";};
   if(un_campo("select id from trim_egreso where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>EGR </span></strong>";} else{echo "<span class='text-danger'>EGR </span>";};
   if(un_campo("select id from trim_estrategias where trimestre=".$trimestre." and anio=".$anio." and hogar=".$hogar." and legajo=".$ante)>"0"){echo "<strong><span class='text-success'>EST </span></strong>";} else{echo "<span class='text-danger'>EST </span>";};
   echo "</td><td style='font-size:.9em'><button class='btn-sm btn-secondary' onclick='actualizar(".$r["idalojados"].")'>Actualizar</button></td></tr>";
 };
};
echo $cont." NNYA Alojados";

?>
</tbody>
</table>
</div>
</div>
</body>