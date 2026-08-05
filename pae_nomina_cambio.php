<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Cambio de Etapa en PAE";
include("encabezado-test.php");
noconsulta();
$id=$_GET["id"];
$r=un_registro("select pae_nomina.*,concat(apellidos,', ',nombres) as apyn from pae_nomina left join sujetos on pae_nomina.legajo=sujetos.legajo where pae_nomina.id=".$id);
?>
</div>
<div class="container">

<h4>Inclusi&oacute;n en PAE de <?php echo $r["apyn"];?></h4>
<form class="form-inline" action='pae_nomina_cambio_do' method="get" onsubmit="return valida_datos()">
<div class="form-group has-warning">
<label class="label-form" for="etapa">Nueva Etapa</label>
<select class="form-control" id="etapa" name="etapa" onfocus="llenaetapas()"></select>
</div>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="fecha">Fecha</label>
<input class='form-control' size='10' maxlength='10' name='fecha' id='fecha' onblur='valida_fecha(this.id)'>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="comentarios">Comentarios</label>
<input class='form-control' size='60' maxlength='200' name='comentarios' id='comentarios'>
</div>

<input type="hidden" name="id" value="<?php echo $id;?>">
<button class='btn-primary' type='submit'>Cambiar Etapa</button>
</form>
</div>



<script type="text/javascript">

enfoca('etapa');

function valida_datos() {
if (document.getElementById("etapa").value=="") {status("Indique etapa");return false;};
valida_fecha("fecha");
if (document.getElementById("fecha").value=="") {status("Indique fecha");return false;};
return true;
}
function llenaetapas(){
if(document.getElementById("etapa").value==""){
etapa_actual="<?php echo $r['etapa']?>";
document.getElementById("etapa").innerHTML="";
 if(etapa_actual!="1"){document.getElementById("etapa").innerHTML=document.getElementById("etapa").innerHTML+"<option value=1>Etapa 1</option>";};
 if(etapa_actual!="2"){document.getElementById("etapa").innerHTML=document.getElementById("etapa").innerHTML+"<option value=2>Etapa 2</option>";};
};
return true;
}
</script>
</body>
</html>