<?php
include("Funciones.php");
session_start();
//noconsulta();
$_SESSION["prestacion"]="Subida de Archivos";
$tipo=""; 
$lega="";
$grup="";
$hogar="";
$familia="";
$dispositivo="";
$visita="";
$altabaja="";
$ong="";
$ret="";
if(isset($_GET["ret"])) $ret=$_GET["ret"]; 
if(isset($_GET["tipo"])) $tipo=$_GET["tipo"];
if(isset($_GET["legajo"])) $lega=$_GET["legajo"];
if(isset($_GET["grupo"])) $grup=$_GET["grupo"];
if(isset($_GET["hogar"])) $hogar=$_GET["hogar"];
if(isset($_GET["familia"])) $familia=$_GET["familia"];
if(isset($_GET["dispositivo"])) $dispositivo=$_GET["dispositivo"];
if(isset($_GET["altabaja"])) {if($tipo=="") {$tipo="23";};$altabaja=$_GET["altabaja"];};
if(isset($_GET["visita"])) $visita=$_GET["visita"];
if(isset($_GET["ong"])) $ong=$_GET["ong"];
include("encabezado.php");
?>

</div>

<div class="container">

<form class="form" action="uploadarch" method="post" enctype="multipart/form-data" onsubmit="return valida_arch()">

<div class="form-group has-warning">

<div class="table-responsive">

<table class="table">

<tr>

<td><label class="label-form" for="archivo">Seleccion&aacute; archivo a subir</label></td><td><input name="archivo" id="archivo" type="file" size="35" /></td>

</tr>
<tr><td><label class="label-form" for="tipoarchivo">Tipo de Archivo</label></td><td><select class="form-control" name="tipoarchivo" id="tipoarchivo" <?php if($tipo!="") echo "'READONLY'"?>><?php echo tbla("tipoarchivo");?></select></td></tr>
<tr><td><label class="label-form" for="descr">Breve descripci&oacute;n del Documento</label></td><td><input class="form-control" name="descripcion" type="text" size="45" maxlength="95" id='descr' onblur='valida_0(this.id)'/></td></tr>
<tr><td><label class="label-form" for="fecha">Fecha del Documento</label></td><td><input class="form-control" name="fecha" id="fecha" onblur="valida_fecha(this.id,'1')" size="10" maxlength="10"></td></tr>
<tr><td><label class="label-form" for="legajo"> Sujeto</label></td><td><input class="form-control" type="text" id="legajo" name="legajo" size="5" readonly maxlength="6" value='<?php echo $lega;?>'></td>
<td><label class="label-form" for="grupo"> Grupo</label></td><td><input class="form-control" type="text" id="grupo" name="grupo" size="5" readonly maxlength="6" value='<?php echo $grup;?>'></td>
<td><label class="label-form" for="familia"> Familia</label></td><td><input  class="form-control"type="text" id="familia" name="familia" size="5" readonly maxlength="6" value='<?php echo $familia;?>'></td></tr>

<tr><td><label class="label-form" for="ong"> ONG</label></td><td><input class="form-control" type="text" id="ong" name="ong" size="6" readonly maxlength="6" value='<?php echo $ong;?>'></td></tr>
<td><label class="label-form" for="hogar"> Dispositivo</label></td><td><input  class="form-control"type="text" id="hogar" name="hogar" size="5" readonly maxlength="6" value='<?php echo $hogar;?>'></td>
<td><label class="label-form" for="dispositivo"> Sector</label></td><td><input  class="form-control"type="text" id="dispositivo" name="dispositivo" size="5" readonly maxlength="6" value='<?php echo $dispositivo;?>'></td></tr>
<tr><td><label class="label-form" for="altabaja"> Alta/Baja</label></td><td><input  class="form-control"type="text" id="altabaja" name="altabaja" size="5" readonly maxlength="6" value='<?php echo $altabaja;?>'></td>
<td><label class="label-form" for="visita"> Visita</label></td><td><input  class="form-control" type="text" id="visita" name="visita" size="5" readonly maxlength="6" value='<?php echo $visita;?>'></td>
</tr>
<input name="ret" type="hidden" value="<?php echo $ret?>" /> 
<input name="action" type="hidden" value="upload" /> 
</table>

</div>

<?php if($_SESSION['glcons']!="1") echo "<button class='form-control bg-primary' name='enviar' type='submit'>Subir Archivo</button>"?>

</div>

</form>

<script type="text/javascript">

seleccionar("tipoarchivo","<?php echo $tipo;?>");



function valida_arch(){

 valida_0("descr");

 nombrearch=document.getElementById("archivo").value; 

 if(nombrearch=="") {alert("archivo");return false;};
 if(nombrearch.length>100) {alert("renombrar el archivo por un nombre mas corto y volver a intentar");return false;}; 

 if(document.getElementById("tipoarchivo").value==-1) {alert("tipo de archivo");return false;};

 if(document.getElementById("descr").value=="") {alert("descr. de archivo");return false;};

 if(fecha.value==""){alert("fecha del documento");return false;};

 return true;

}





</script>



</div>

</body>

</html>