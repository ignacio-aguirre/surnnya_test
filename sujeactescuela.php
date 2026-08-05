<?php
include("Funciones.php");
session_start();
?>

<script type="text/javascript">
function valida_esc() {
var nome=document.getElementById("i_nome");
if(nome.value=="") return false;
return true;
}
</script>
<?php
$_SESSION["prestacion"]="Datos Escolares/Educativos";
if (!isset($_SESSION['gldispo'])) header ("Location: index.php");
if($_SESSION["gl_editar_sujeto"]==0) header("Location: ".$_SESSION["menu"]);
include("encabezado-test.php");
$lega= $_GET["legajo"];
include("mnu_superior.php");
$sinn="<option value=''>S/D</option><option value='1'>Si</option><option value='0'>No</option>";
$opci = $_SESSION['loc_gene'];
$snsd="<OPTION VALUE='1'>SI</OPTION><OPTION VALUE='0'>NO</OPTION><OPTION VALUE=''>S/D</OPTION>";
$snts="<OPTION VALUE='1'>SI</OPTION><OPTION VALUE='0'>NO</OPTION><OPTION VALUE='2'>En Tr&aacute;mite</OPTION><OPTION VALUE=''>S/D</OPTION>";
?>
</div>
<div class='container'>
Escolaridad
<div class="table-responsive">
<table class="table-condensed">
<td>Acc</td><td>Escuela</td><td>Localidad</td><td>Cuando</td><td>Ult.Nivel Cursado</td><td>Referente y Turno</td><td>Obs.</td>
<?php 
  $conn=registros("select * from sujetos_escuela inner join localidades on esco_loca=idlocalidades where baja is null and esco_legajo=".$lega);
  $conta=1;
  while ($da = mysqli_fetch_assoc($conn)) {
   $conta=$conta+1;
   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else {echo "<tr bgcolor='#E6E6E6'>";};

   echo "<td><a href='escuelaedita?id=".$da['idsujetos_escuela']."'><img height='15' width='15' src='imagenes/editar.png'></a><a href='escuelaborra.php?id=".$da['idsujetos_escuela']."&legajo=".$lega."'><img height='15' width='15' src='imagenes/eliminar.png'></a></td><td>".$da['esco_nomb']."</td><td>".$da['descripcion']."</td><td>".$da['esco_cuan']."</td><td>".$da['esco_nive']."</td><td>".$da['esco_refe']."</td><td>".$da['esco_obse']."</td>";
   echo "</td></tr>";
  };
?>
 </table>
 </div>
 <h4>Agregar Tramo Educativo</h4>
<form class="form-inline"method='get' action='agregaescuela' onsubmit='return valida_esc()'>
 <div class="form-group has-warning"> 
  <label class="label-form">Nombre Escuela</label> 
  <input class="form-control" size='30' maxlength='45' name="inome" id="i_nome" onblur='valida_0("i_nome")'>
 </div>
 <div class="form-group has-warning">
  <label class="label-form">Localidad</label> 
  <select  class="form-control" name='iloce' id='i_loce'><?php echo $opci;?></select>
 </div>
 <br><br>
 <div class="form-group has-warning">
  <label class="label-form">Cuando</label> 
  <input class="form-control" size='20' maxlength='45' name="icuae" id="i_cuae" onblur='valida_0("i_cuae")' >
 </div>
 <div class="form-group has-warning">
  <label class="label-form">Ult.Nivel Cursado</label> 
  <input class="form-control" size='20' maxlength='45' name="inive" id="inive" onblur='valida_0("inive")' >
 </div>
 <br><br>
 <div class="form-group has-warning">
  <label class="label-form">Referente y turno</label> 
  <input class="form-control" size='30' maxlength='45' name="irefe" id="i_refe" onblur='valida_0("i_refe")' >
 </div>
 
 <div class="form-group has-warning">
  <label class="label-form">Observaciones</label> 
  <input class="form-control" size='30' maxlength='45' name="iobse" id="i_obse" onblur='valida_0("i_obse")' >
 </div>
 <br><br>
 <input name="legajo" type="hidden" value="<?php echo $lega;?>" />    
<?php if($_SESSION['glcons']!=1) echo '<input type="submit" name="ienviare" value="Agregar Escuela">'; ?>
</form>
<a href='suje_cons_familiaescuela?legajo=<?php echo $lega;?>'>Volver a Consulta</a>
</div>	 	
</body>
</html>