<?php
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Firmar Informe Trimestral";
include("encabezado.php");
$id=$_GET["id"];
$tri=un_registro("select * from trimestrales where id=".$id);
$trimestre=$tri["trimestre"];
$anio=$tri["anio"];
$nnya=$tri["legajo"];
$hogar=$tri["hogar"];
if(isset($_SESSION)){
if(un_campo("select firma from usuarios_hogares where baja is null and id=".$_SESSION["usuario"])!="1"){
die("Usuario no habilitado para firmar");};}
else{Redirect("sesion_expirada")};
$trimestral=un_campo("select id from trimestrales where anio=".$anio." and trimestre=".$trimestre." and hogar=".$hogar." and legajo=".$nnya);
if(!$trimestral>0){die("Sin datos cargados");};
$ida=un_campo("select id from trim_identidad where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Identidad");};
$ida=un_campo("select id from trim_juridicos where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Sit.Adm/Legal");};
$ida=un_campo("select id from trim_ingreso where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Sit. al Ingreso");};
$ida=un_campo("select id from trim_convivencial where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Sit. Convivencial");};
$ida=un_campo("select id from trim_salud_fisica where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Salud F&iacute;sica");};
$ida=un_campo("select id from trim_salud_mental where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Salud Mental");};
$ida=un_campo("select id from trim_salud_fisica where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Salud F&iacute;sica");};
$ida=un_campo("select id from trim_educacion where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Escolaridad");};
$ida=un_campo("select id from trim_vinculaciones where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Vinculaciones");};
$ida=un_campo("select id from trim_egreso where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Egreso");};
$ida=un_campo("select id from trim_estrategias where trimestral=".$trimestral);
if(!$ida>0){die("Sin datos cargados para el conjunto Estrategias");};
$ida=un_campo("select id from trim_profesional where trimestral=".$trimestral);
if($_SESSION["usuario"]=="0"){Redirect("firma_do_supervision?id=".$id);};

?>
</div>
<div class="container">
<h3>Informe trimestral</h3>
<?php 
echo "NNYA <strong>".un_campo("select concat(apellidos,', ',nombres) from alojados where idalojados=".$nnya)."</strong><br>";
echo "Hogar <strong>".un_campo("select nombre from dispositivos where id=".$hogar)."</strong><br>";
echo "Trimestre <strong>".$trimestre." / ".$anio;

?>
<form class="form-inline" action="firma_do" method="get" onsubmit="return valida()">
<div class="form-group has-warning">
<label class="label-form">DNI</label>
<input class="form-control" id="dni" name="dni" size="8" maxlength="8" onblur="valida_entero(this.id)" autofocus>
</div>
<input name="id" hidden value="<?php echo $id?>">
<input class="btn-success" type="submit" value="Firmar">
</form>
<script>
function valida(){
valida_entero("dni");
if(document.getElementById("dni").value==""){alert("DNI es obligatorio");return false;};
dnivalor=parseInt(document.getElementById("dni").value);
if(dnivalor<1000000){alert("DNI es incorrecto");return false;};
return true;
}
</script>
</div>
