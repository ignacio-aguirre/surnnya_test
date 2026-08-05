<?php
include("Funciones.php"); 
session_start();
$_SESSION["prestacion"]="Horario";
registre();
include("encabezado-test.php");
$id=$_GET['iid'];
$desc="";
$lune="";
$mart="";
$mier="";
$juev="";
$vier="";
$saba="";
$domi="";
$feri="";
if(isset($_GET['accion'])) {
$desc=$_GET['descripcion'];
$lune=$_GET['lunes'];
$mart=$_GET['martes'];
$mier=$_GET['miercoles'];
$juev=$_GET['jueves'];
$vier=$_GET['viernes'];
$saba=$_GET['sabados'];
$domi=$_GET['domingos'];
$feri=$_GET['feriados'];
if($id==0) {$sql="insert into ac_horarios (descripcion, lunes, martes, miercoles, jueves, viernes, sabados, domingos, feriados) 
values('".$desc."', ".nulea($lune).",".nulea($mart).",".nulea($mier).",".nulea($juev).",".nulea($vier).",".nulea($saba).",".nulea($domi).",".nulea($feri).")";} 
else 
{$sql="update ac_horarios set descripcion='".$desc."', lunes=".nulea($lune).",martes=".nulea($mart).",miercoles=".nulea($mier).
  ",jueves=".nulea($juev).",viernes=".nulea($vier).",sabados=".nulea($saba).",domingos=".$domi.",feriados=".nulea($feri)." where idac_horarios=".$id;
};
ejecute($sql);
Redirect("ac_horarios");
};
$da=un_registro("select * from ac_horarios where idac_horarios=".$id); 
$desc=$da['descripcion'];
$lune=$da['lunes'];
$mart=$da['martes'];
$mier=$da['miercoles'];
$juev=$da['jueves'];
$vier=$da['viernes'];
$saba=$da['sabados'];
$domi=$da['domingos'];
$feri=$da['feriados'];
if ($id==0) {$acc="Nuevo";} else $acc="Editar"; 
?>
<script type="text/javascript">
function valida_datos() {
if(document.getElementById("descripcion").value=="") {status("debe indicar descripción");return false;};
if(document.getElementById("lunes").value=="") document.getElementById("lunes").value="0";
if(document.getElementById("martes").value=="") document.getElementById("martes").value="0";
if(document.getElementById("miercoles").value=="") document.getElementById("miercoles").value="0";
if(document.getElementById("jueves").value=="") document.getElementById("jueves").value="0";
if(document.getElementById("viernes").value=="") document.getElementById("viernes").value="0";
if(document.getElementById("sabados").value=="") document.getElementById("sabados").value="0";
if(document.getElementById("domingos").value=="") document.getElementById("domingos").value="0";
if(document.getElementById("feriados").value=="") document.getElementById("feriados").value="0";
return true;
}
</script>
</div>

<div class="container">
<?php echo $acc;?>
<form class="form-inline" method='get' onsubmit='return valida_datos()'>
<div class="table-responsive">
<table class="table">

<tr><td>Descripci&oacute;n:</td><td><input size='40' maxlength="45" type='text' onblur='valida_0("descripcion")'name='descripcion' id='descripcion' value='<?php echo $desc;?>'/></td></tr>

<tr><td>Lunes:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("lunes")' name='lunes' id='lunes' value='<?php echo $lune;?>'/></td></tr>

<tr><td>Martes:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("martes")' name='martes' id='martes' value='<?php echo $mart;?>'/></td></tr>

<tr><td>Mi&eacute;rcoles:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("miercoles")' name='miercoles' id='miercoles' value='<?php echo $mier;?>'/></td></tr>

<tr><td>Jueves:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("jueves")' name='jueves' id='jueves' value='<?php echo $juev;?>'/></td></tr>

<tr><td>Viernes:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("viernes")' name='viernes' id='viernes' value='<?php echo $vier;?>'/></td></tr>

<tr><td>S&aacute;bados:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("sabados")' name='sabados' id='sabados' value='<?php echo $saba;?>'/></td></tr>

<tr><td>Domingos:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("domingos")' name='domingos' id='domingos' value='<?php echo $domi;?>'/></td></tr>

<tr><td>Feriados:</td><td><input size='2' maxlength='2' type='text' onblur='valida_decimal("feriados")' name='feriados' id='feriados' value='<?php echo $feri;?>'/></td></tr>

<input type='hidden' name='iid' value='<?php echo $id;?>'/>

<input type='hidden' name='accion' value='<?php echo $acc;?>'/>

</table>
</div>
<input type='submit' name='Form' value='Aceptar'></td></tr>

</form>

<script language=JavaScript>
document.getElementById( "descripcion" ).focus()
</script>
</div>
</body>
</html>