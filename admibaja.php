<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Egreso de Hogar";
noconsulta();
include("encabezado-test.php");
$id=$_GET["iid"];
$reg = un_registro("select admi_alta as alta, concat(Apellidos,', ',Nombres) as apyn, nombre as hoga, Hogares_Mail, admi_legajo  from hogares_admision left join sujetos on legajo=admi_legajo left join dispositivos on dispositivos.id=admi_hogar where idhogares_admision=".$id);

$hoga=$reg['hoga'];

$alta=ffec($reg['alta']);

$legajo=$reg['admi_legajo'];

$apyn=$reg['apyn'];

?>

<script type="text/javascript">

function valida_datos() {

valida_fecha("fecha");

fecha=fsql(document.getElementById("fecha").value);

legajo="<?php echo $legajo?>";

if (document.getElementById("fecha").value==""|document.getElementById("mote").value=="") {alert("completá ambos campos datos");return false;};

if (fsql(document.getElementById("fecha").value)>fsql("<?php echo $_SESSION["DiaHoy"];?>")){alert("la fecha de baja no puede ser futura");return false;};

if(fsql("<?php echo $alta?>")>fecha){alert("la fecha de baja no puede ser menor que la de alta");return false;};

cantidad=ejec("sq_altasbajas","1","&legajo="+legajo);

if(parseInt(cantidad)==0) {alert("no hay un alojamiento en curso. No puede procesarse esta baja");return false;};

ultimabaja=ejec("sq_altasbajas","2","&legajo="+legajo);

if(ultimabaja!=""){

  if(fsql(ultimabaja)>fecha){alert("este no es el último tramo del alojamiento. No puede procesarse esta baja");return false;};

};

return true;

}

function aceptar(){

  if(!valida_datos()) return false;

  navega("admibaja_do?id=<?php echo $id?>"+"&fecha="+document.getElementById("fecha").value+"&mote="+document.getElementById("mote").value);

  return true;

}



</script>

</div>

<div class="container">

<div class="row">

 <div class="col-md-12">

  <?php echo 'Sujeto:<strong>'.$apyn.'</strong>';?>

 </div>

</div>

<div class="row">

 <div class="col-md-8">

  <?php echo 'Hogar:<strong>'.$hoga.'</strong>';?>

 </div>

 <div class="col-md-4">

  <?php echo 'Alta:<strong>'.$alta.'</strong>';?>

 </div>

</div>



<form class="form-inline" action="#" onsubmit="return false">

 <div class="form-group has-warning">

  <label class="label-form" for="fecha">Fecha de Baja</label>

  <input class="form-control" size='10' maxlength='10' id='fecha' onblur='valida_fecha(this.id)'>

 </div>

 <div class="form-group has-warning">

  <label class="label-form" for="mote">Motivo de Egreso</label>

  <select class='form-control' id='mote'><?php echo $_SESSION['Opc_Hoga_Megr'];?></select>

 </div>

<input type="hidden" name="iid" value="<?php echo $id;?>">

</form>

<button class="btn-primary" onclick="aceptar()">Registrar Baja</button>

<script type='text/javascript'>enfoca('fecha');</script>

</div>

</body>

</html>