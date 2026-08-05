<?php
include("Funciones.php");
session_start();
noconsulta();
$_SESSION["prestacion"]="Asignaci&oacute;n de Recurso";
registre();
include("encabezado-test.php");
$iid=$_GET["iid"];
$da = un_registro("select Apellidos, Nombres, admi_susp, admi_mots, admi_fped, hogares_de.deno as deriv, admi_deriv_cual, legajo from hogares_admision left join sujetos on legajo=admi_legajo left join tablas hogares_de on hogares_de.valo=admi_deriv and hogares_de.tipo='ADDER' where idhogares_admision=".$iid);
$legajo=$da["legajo"];
if(isset($_GET['fech'])) {
    /* chequea condición de asignación: no puede haber otro asignado sin alta ni una alta activa en el mismo hogar-familia */
    $da = un_registro("select count(*) as cant from hogares_admision where admi_fderiv is not null and admi_alta is null and admi_susp is null and admi_legajo=".$legajo);
    if($da['cant']!="0") Redirect('admicons?mensaje=Ya tiene recurso asignado, se ignora la admision ingresada.');
    $da = un_registro("select count(*) as cant from hogares_admision where admi_alta is not null and admi_baja is null and admi_legajo =".$legajo." and admi_hogar=".$_GET['hogar']);
    if($da['cant']!="0") Redirect('admicons?mensaje=Ya tiene ingreso en el hogar, se ignora la admision ingresada.');
    ejecute("update hogares_admision set admi_hogar=".nget('hogar').", admi_fderiv=".fget('fech').", admi_fami=".nget('familia')." where idhogares_admision=".$iid);
    Redirect('admicons?mensaje=Recurso Otorgado');
};
?>
<div class="container">
<form class="form-inline" method='get' onsubmit='return valida_campos()'>
<strong><?php echo $da["Apellidos"].", ".$da["Nombres"];?></strong><br>
Fecha Pedido: <strong><?php echo ffec($da["admi_fped"]);?></strong><br><br>
<div class="form-group has-warning">
 <label class="label-form">Fecha Asignaci&oacute;n</label>
 <input class="form-control" size="10" maxlength="10" name='fech' id='fecha' onblur='valida_fecha("fecha")' autofocus value='<?php echo $_SESSION["DiaHoy"];?>'/>
</div>
<div class="form-group has-warning">
 <label class="label-form">Hogar</label>
 <select class="form-control" name='hogar' id='hogar' onblur='sale_hogar()'><?php echo $_SESSION['Opc_Hoga'];?></select>
</div>
<br><br>
<div class="form-group has-warning">
 <label class="label-form">Familia</label>
 <select class="form-control" id="familia" name="familia"></select>
</div>
<br><br>
<input type="hidden" name='iid' value='<?php echo $iid;?>'/>
<input class="btn-primary" name="submit" id='sub' type="submit" value="Asignar" />
</form>
</div>
</div>

<script type="text/javascript">
function valida_campos() {
if (document.getElementById("fecha").value=="") {alert("complete fecha");return false;};
if (document.getElementById("hogar").value=="") {alert("complete hogar");return false;};
if (!document.getElementById("familia").disabled && document.getElementById("familia").value==0) {alert("complete familia");return false;};
return true;
}

function sale_hogar(){
 hoga=document.getElementById("hogar").value;
 fami=document.getElementById("familia");
 defa=document.getElementById("descfam");
 if(hoga!="") {
    url = "sq_tipo_dispositivo?id="+hoga;
    pet = new XMLHttpRequest();
    pet.open('GET', url, false);
    pet.send(null);
    var acog = pet.responseText;
    document.getElementById("familia").value="";	
    if(acog!="1") {document.getElementById("familia").disabled=true;}
    else{
     document.getElementById("familia").disabled=false;
     url = "ej?tipo=FAHOGARES&id="+hoga;
     pet = new XMLHttpRequest();
     pet.open('GET', url, false);
     pet.send(null);
     var acog = pet.responseText;
     document.getElementById("familia").innerHTML="<option value=0>Seleccionar</option>"+acog;
    };
 };
 return true;
}
</script>

</body>

</html>