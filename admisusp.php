<?php

include("Funciones.php"); 

session_start();

$_SESSION["prestacion"]="Suspensi&oacute;n de Pedidos sin Ingreso a Hogar";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");

if (isset($_GET["retorno"])) {$retorno=$_GET["retorno"];} else $retorno=$_SERVER["HTTP_REFERER"];

$iid=$_GET["iid"];

$sql="select Apellidos, sujetos.legajo, Nombres, admi_susp, admi_mots, admi_fped, concat(hogares_de.deno, ' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) as deriv

 from hogares_admision left join sujetos on legajo=admi_legajo left join tablas hogares_de on hogares_de.valo=admi_deriv and hogares_de.tipo='ADDER' where idhogares_admision=".$iid;

$da = un_registro($sql);

$acc="";

if (gettype($da['admi_susp'])=="NULL") $acc="Suspender";

if(isset($_GET['ifech'])) {

if ($acc=="Suspender"){
 ejecute("update hogares_admision set admi_susp=".fsql($_GET['ifech']).",  admi_mots='".$_GET['imoti']."', admi_motivo_suspension=".$_GET["motivo"]." where idhogares_admision=".$iid);
 $dispositivo=un_campo("select nombre from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_legajo=".$da["legajo"]." and admi_alta is not null and admi_baja is null");
 if($dispositivo!="") {Redirect("admi_aviso_alojado?legajo=".$da["legajo"]);};
};
 

Redirect($retorno);

};

?>

<div class="container">
<strong><?php echo $da["Apellidos"].", ". $da["Nombres"];?></strong><br>
Fecha Asignaci&oacute;n:<strong><?php echo ffec($da["admi_fderiv"])."</strong><br>";
  echo "Hogar: ".$da["hogar"]."<br></strong>";?>
Solicitante: <strong><?php echo $da["deriv"];?></strong>

<form class='form-inline' onsubmit='return valida_campos()'>
<div class="form-group has-warning">
<label class="label-form" for="i_fech">Fecha Suspensi&oacute;n</label>
<input class="form-control" size="10" maxlength="10" name='ifech' id='i_fech' onblur='valida_fecha("i_fech")' value='<?php echo ffec($da["admi_susp"]);?>'/>&nbsp;&nbsp;
</div>

<div class="form-group has-warning">
<label class="label-form" for="motivo">Motivo</label>
<select class="form-control" name='motivo' id='motivo'>
<?php echo opc_tabla("ADMSU");?>
</select>
</div>

<div class="form-group has-warning">
<label class="label-form" for="i_moti">Observaciones</label>
<input class="form-control" size="100" maxlength="200" name='imoti' id='i_moti' onblur='valida_0("i_moti")' value='<?php echo $da["admi_mots"];?>'/>
</div>
<input type="hidden" name='iid' value='<?php echo $iid;?>'/>

<input type="hidden" name='retorno' value='<?php echo $retorno;?>'/>

<input name="submit" id='sub' type="submit" value="<?php echo $acc;?>" />



</form>

</div>

<script type="text/javascript">

function valida_campos() {

if(document.getElementById("sub").value=="Suspender") {

  if(document.getElementById("i_fech").value==""||document.getElementById("i_moti").value=="") return false;

};

return true;

}
document.getElementById("i_fech").focus();
</script>



</body>

</html>