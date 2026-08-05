<?php
include("Funciones.php");
session_start();?>

<script type="text/javascript">
function valida_fam() {
var apel=document.getElementById("i_apef");
var nomb=document.getElementById("i_nomf");
if(apel.value==""||nomb.value=="") return false;
return true;
}


function valida_apyn() {
valida_0("i_apef");
valida_0("i_nomf");
var apel=document.getElementById("i_apef").value;
var nomb=document.getElementById("i_nomf").value;
if(apel!=""&&nomb!="") {} else {return false;};
}

</script>

<?php
$_SESSION["prestacion"]="Actualizacion de Datos Familiares";
include("encabezado.php");
if($_SESSION["gl_editar_sujeto"]==0) header("Location: ".$_SESSION["menu"]);
$_SESSION["posicion"]="3";
$lega= $_GET["legajo"];
include("mnu_superior.php");
$enca=un_registro("select concat(apellidos,',',nombres) as nomb from sujetos where legajo=".$lega);
$sinn="<option value=''>S/D</option><option value='1'>Si</option><option value='0'>No</option>";
$snsd="<OPTION VALUE='1'>SI</OPTION><OPTION VALUE='0'>NO</OPTION><OPTION VALUE=''>S/D</OPTION>";
$opci = $_SESSION['loc_gene'];
?>
</div>
<div class="container">
 <h3><?php echo $enca["nomb"];?> Grupo Familiar</h3>
 <div class="table-responsive">
  <table class="table-condensed">
	<tr class="bg-primary"><th>Acc</th><th>Parentesco</th><th>Apellidos</th><th>Nombres</th><th>Legajo</th><th>Edad</th><th>F.Act.</th><th>Vive</th><th>Ocupaci&oacute;n</th><th>Obs</th><th>Domicilio</th><th>Tel&eacute;fonos</th></tr>

<?php 
  $conn=registros("select *, date_format(fami_actedad,'%d/%m/%Y') as actu from sujetos_familia where baja is null and fami_legajo=".$lega); 
  $conta=1;
  while ($da = mysqli_fetch_assoc($conn)) {
   $conta=$conta+1;
   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};
   echo "<td><a href='familiaredita?id=".$da['idsujetos_familia']."'><img height='15' width='15' src='imagenes/editar.png'></a><a href='familiarborra?id=".$da['idsujetos_familia']."&legajo=".$lega."'><img height='15' width='15' src='imagenes/eliminar.png'></a></td><td>".
   parentesco($da['fami_paren'])."</td><td>".$da['fami_apellidos']."</td><td>".$da['fami_nombres']."</td><td><a href='suje_cons_familiaescuela.php?legajo=".$da["fami_lega"]."'>".$da["fami_lega"]."</a></td><td>".$da['fami_edad']."</td><td>".$da['actu']."</td><td>";
if(gettype($da['fami_vive'])=="NULL")  {echo "S/D";} elseif ($da['fami_vive']==1) {echo"Si";} elseif($da['fami_vive']==0) {echo "No";}  ;
echo "</td><td>".$da['fami_ocup']."</td><td>".$da['fami_obse']."</td><td>".$da['fami_domi']."</td><td>".$da['fami_tele'];
   echo "</td></tr>";
  };
?>
  </table>
 </div>
 <h4>Agregar nuevo familiar</h4>
 <form class="form-inline" method='get' action='agregafamiliar' onsubmit='return valida_fam()'>
  <div class="form-group has-warning">
   <label class="label-form" for="i_paren">Parentesco</label>	
    <select class="form-control" name='iparen' id='i_paren'>
     <option value="M">Madre</option><option value="P">Padre</option><option value="H">Hermano/a</option>
     <option value="T">Tio/a</option><option value="A">Abuelo/a</option><option value="N">Pareja</option>
     <option value="I">Hijo/a</option><option value="B">Pareja Madre</option><option value="C">Pareja Padre</option>
     <option value="O">Otros</option><option value="">S/D</option>
    </select>
  </div>

  <div class="form-group has-warning">
   <label class="label-form" for="i_apef">Apellidos</label>	
   <input class="form-control" size='20' maxlength='45' name="iapef" id="i_apef" onblur='valida_apyn()'>
  </div>

  <div class="form-group has-warning">
   <label class="label-form" for="i_nomf">Nombres</label>	
   <input class="form-control" size='20' maxlength='45'  name="inomf" id="i_nomf" onblur='valida_apyn()'>
  </div>

  <div class="form-group has-warning">
   <label class="label-form" for="ilega">Legajo</label>	
   <input class="form-control" size='6'  maxlength='6' name="ilega" readonly id="i_lega">
  </div>
  <br><br>

  <div class="form-group has-warning">
   <label class="label-form" for="i_edaf">Edad</label>	
   <input class="form-control" size='3'  maxlength='3' name="iedaf" id="i_edaf" onblur='valida_entero("i_edaf")'>
  </div>

  <div class="form-group has-warning">
   <label class="label-form" for="i_actf">Fecha Actualizaci&oacute;n</label>	
   <input class="form-control" size='8'  maxlength='10' name="iactf" id="i_actf" onblur='valida_fecha("i_actf")'>
  </div>

  <div class="form-group has-warning">
   <label class="label-form" for="ivivf">Vive?</label>	
   <select class="form-control" name='i_vivf' id='ivivf'><?php echo $sinn;?></select>
  </div>
 
  <div class="form-group has-warning">
   <label class="label-form" for="iocuf">Ocupaci&oacute;n</label>	
   <input class="form-control" size='20' maxlength='45' name="i_ocuf" id="iocuf" onblur='valida_0("iocuf")'>
  </div>
 <br><br>
  <div class="form-group has-warning">
   <label class="label-form" for="iobsf">Observaciones</label>	
   <input class="form-control" size='20' maxlength='100'name="i_obsf" id="iobsf" onblur='valida_0("iobsf")'>
  </div>

 <div class="form-group has-warning">
   <label class="label-form" for="idomf">Domicilio</label>	
   <input class="form-control" size='30' maxlength='60'name="i_domf" id="idomf" onblur='valida_0("idomf")'>
 </div>

 <div class="form-group has-warning">
   <label class="label-form" for="itelf">Tel&eacute;fono</label>	
   <input class="form-control" size='15' maxlength='45'name="i_telf" id="itelf" onblur='valida_0("itelf")'>
 </div>
 <input name="legajo" type="hidden" value="<?php echo $lega;?>" />
 <br><br>    
 <?php if($_SESSION['glcons']!=1) echo "<input class='btn-primary' type='submit' name='ienviarf' value='Agregar Familiar'>";?>

</form>

</body>

<html>
