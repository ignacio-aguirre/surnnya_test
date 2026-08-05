<?php
include("Funciones.php");
session_start();
$legajo=$_GET["legajo"];
$familia=$_SESSION["temp_ffv"];
if(!$familia>0){Redirect("salir");};
$_SESSION["prestacion"]="Agregar NNYA a la Familia ".un_campo("select descripcion from fv_familias where idfv_familias=".$familia);
include("encabezado-test.php");
$nnya=un_registro("select sujetos.*,tablas.deno, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as eda 
 from sujetos left join tablas on tablas.tipo='TD' and tablas.valo=tipodni 
 where sujetos.legajo=".$legajo);
?>
</div>
<div class="container">
<div class="row">
<div class="col-sm-4">Apellido y Nombre <strong><?php echo $nnya["Apellidos"].", ".$nnya["Nombres"]?></strong></div>
<div class="col-sm-4">Fecha Nacimiento y Edad <strong><?php echo ffec($nnya["f_nacimiento"]).", ".$nnya["eda"]?> a&ntilde;os</strong></div>
</div>
<div class="row">
<hr>
</div>
<div class="row">
<div class="col-sm-4">Tipo y N&uacute;mero Documento <strong><?php echo $nnya["deno"]." ".$nnya["SujetosDNI"]?></strong></div>
<div class="col-sm-4">RIB <strong><?php echo rib($nnya["rib_anio"],$nnya["rib_numero"],$nnya["rib_reparticion"])?></strong></div>
</div>
<div class="row">
<hr>
</div>
<?php
 $nfamilia=un_campo("select descripcion from fv_familias_miembros left join fv_familias on familia=idfv_familias where fv_familias_miembros.legajo=".$legajo);
 if($nfamilia!=""){die("En grupo familiar ".$nfamilia);}
 else{echo "NNYA no incluido en otro grupo familiar";};
?>
<div class="row">
<hr>
</div>

<form class="form-inline" method="get" action="fv_nnya_alta_do" onsubmit="return valida()">
<div class="form-group has-warning">
 <p class="text-warning">Fecha de Incorporaci&oacute;n a la familia, o fecha de ingreso de la familia al programa, mayor entre ambas</p>
 <label class="label-form">Fecha Alta</label>
 <input class="form-control" id="fecha_alta" name="fecha_alta" size="10" maxlength="10" onblur="valida_fecha(this.id)" autofocus required>
</div>
<input name="familia" value="<?php echo $familia?>" hidden>
<input name="legajo" value="<?php echo $legajo?>" hidden>
<hr>
<button class="btn-primary" type="submit">Agregar</button>
</form>
</div>
<script>
function valida(){
valida_fecha("fecha_alta");
return true;
};
</script>
</body>
</html>
