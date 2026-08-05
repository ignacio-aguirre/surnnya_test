<?php
include("Funciones.php"); 
session_start();
noconsulta();
$_SESSION["prestacion"]="Baja de caso PAE";
include("encabezado.php");
$id=$_GET["id"];
$r=un_registro("select pae_nomina.*,concat(apellidos,', ',nombres) as apyn from pae_nomina left join sujetos on pae_nomina.legajo=sujetos.legajo where pae_nomina.id=".$id);
if($r["accion_amb"]=="BAJA" &&  ffec($r["f_baja"])==""){
   die("Ya de baja. Presionar ((Atr&aacute;s)) para continuar");
};
?>
</div>
<div class="container">

<h4>Baja PAE de <?php echo $r["apyn"];?></h4>
<form class="form-inline" action='pae_baja_do' method="get" onsubmit="return valida_datos()">
<div class="form-group has-warning">
<label class="label-form" for="fecha">Fecha Baja</label>
<input class='form-control' size='10' maxlength='10' name='fecha' id='fecha' onblur='valida_fecha(this.id)'>
<hr>
<div class="form-group has-warning">
<label class="label-form" for="comentarios">Comentarios</label>
<input class='form-control' size='60' maxlength='200' name='comentarios' id='comentarios'>
</div>

<input type="hidden" name="id" value="<?php echo $id;?>">
<button class='btn-danger' type='submit'>Baja</button>
</form>
</div>
</body>
</html>

