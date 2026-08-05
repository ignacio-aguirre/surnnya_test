<?php 
include("Funciones.php"); 
session_start();
$prestacion="Ingreso en Hogar";
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
include("encabezado.php");
$iid=$_GET["iid"];
$fech=$_SESSION["DiaHoy"];
$r = un_registro("select admi_hogar,apellidos, nombres, admi_fderiv, case when tipo_dispositivo=1 then concat('AF: ',af_familias.denominacion) else nombre end as hogar, case when tipo_dispositivo=1 then admi_fami else 0 end as familia,case when tipo_dispositivo=1 then af_familias.estado1 else 0 end as estado1,case when tipo_dispositivo=1 then af_familias.tipo_prestacion else 0 end as estado2, legajo from hogares_admision left join af_familias on admi_fami=idaf_familias left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$iid);
?>

<script type="text/javascript">
function valida_campos() {
valida_fecha("fecha");
idh_ad="<?php echo $iid;?>";
legajo="<?php echo $r["legajo"];?>";
if(document.getElementById("fecha").value=="") {alert("complete la fecha de Alta");return false;};
fecha=fsql(document.getElementById("fecha").value);
fechahoy=fsql('<?php echo $_SESSION["DiaHoy"];?>');
if(fecha>fechahoy) {alert("Lo siento, no se permiten altas con fechas futuras. Gracias");return false;};
fechaasi=fsql("<?php echo ffec($r["admi_fderiv"])?>");
if(fechaasi>fecha) {alert("La fecha de Alta no puede ser anterior a la de asignación");return false;};
cantidad=ejec("sq_altasbajas","1","&legajo="+legajo);
if(parseInt(cantidad)>0) {alert("hay un alojamiento en curso no puede procesarse un nuevo ingreso");return false;};
ultimabaja=ejec("sq_altasbajas","2","&legajo="+legajo);
if(ultimabaja!=""){
  if(fsql(ultimabaja)>fecha){alert("la ultima baja es mayor a la fecha de alta");return false;};
};
return true;
}
</script>
<?php $hogar=$r["hogar"];$hoga=$r["admi_hogar"];?>
</div>
<div class="container">
 <div class="row">
   <div class="col-md-12">
    Apellidos: <strong><?php echo $r["apellidos"];?></strong>
   &nbsp;Nombres: <strong><?php echo $r["nombres"];?></strong>
   </div>
 </div>
 <div class="row">
   <div class="col-md-12">
     Fecha Asignaci&oacute;n: <strong><?php echo ffec($r["admi_fderiv"]);?></strong>
     &nbsp;Hogar: <strong><?php echo $hogar;?></strong>
   </div>
 </div>
 <?php if($r["estado1"]!="0" && $r["estado1"]<>"1") {die("La familia no est&aacute; admitida en el programa. Contactar a PAF");};
   if($r["estado2"]!="0" && $r["estado2"]!="1" && $r["estado2"]!="3" && $r["estado2"]!="4" && $r["estado2"]!="6"&& $r["estado2"]!="8"){die("La familia no est&aacute; disponible. Contactar a PAF");};
 ?>
<hr>
 <form class="form-inline" action='#' onsubmit='return false'>
  <div class="form-group has-warning">
   <label class="label-form" for="fecha">Fecha de Alta</label>
   <input class="form-control" size="10" maxlength="10" id='fecha' onblur='valida_fecha(this.id,1)' value='<?php echo $fech;?>'>
  <div>
</form>
<hr>
<button class="btn-primary" onclick="aceptar()">Registrar Alta</button>

<script type="text/javascript">
enfoca('fecha');
function aceptar(){
  if(valida_campos()){
	idh_ad="<?php echo $iid;?>";
	fecha=document.getElementById("fecha").value;
        navega("admialta_do?id="+idh_ad+"&fecha="+fecha);
  };
}
</script>
</div>
</body>
</html>