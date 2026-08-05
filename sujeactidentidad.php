<?php
include("Funciones.php");
session_start();
if($_SESSION["gl_editar_sujeto"]==0) Redirect($_SESSION["menu"]);
registre();
$_SESSION["prestacion"]="Actualizacion de Datos de Sujeto";
include("encabezado.php");
$lega= $_GET["legajo"];
if ($lega== "" ) Redirect($_SESSION["menu"]);
$opci = $_SESSION['loc_gene'];
$opci2="<option value=''>---Completar</option>";
$conn = registros("select id, denominacion from sectores order by denominacion");
while ($dt = mysqli_fetch_assoc($conn)) {$opci2=$opci2."<option value='".$dt['id']."'>".$dt['denominacion']."</option>";};
$sql="select apellidos, nombres, apodos, sujetos.legajo, tipodni, sujetosdni, locparada,  lugparada, locvivienda, lugvivienda,  nacionalidad, sujetosedad, sujetosmeses,sujetosactedad,
sexo, genero, legajolocal, legajos.abierto as abi, legajos.cerrado as cer,f_nacimiento, telefonos, chequeado,  cuil,
 rib_anio, rib_numero, rib_reparticion from sujetos left outer join legajos on legajo=legajounico and dispolegajo=".$_SESSION['gldispo'];
$sql=$sql." where sujetos.legajo=".$lega;
$dt = un_registro($sql);
$rib="";
if($dt["chequeado"]==1) $rib="readonly";
$nosi="<option value='0'>No</option><option value='1'>Si</option>";
$sino="<option value='1'>Si</option><option value='0'>No</option>";
$sinn="<option value=''>S/D</option><option value='1'>Si</option><option value='0'>No</option>";
$paises="<option value='0'>S/D</option>";
$pai=registros("select idpaises,descripcion from paises order by descripcion");
while($p=mysqli_fetch_assoc($pai)){
 $paises=$paises."<option value='".$p["idpaises"]."'>".$p["descripcion"]."</option>";
};
?>
<script type="text/javascript">
function valida_rib(){
  valida_0("rib");	
  t=document.getElementById("rib").value;
  if(t!=""){
   if(t.substring(0,4)=="RIB-"){
       anio=t.substring(4,8);
       nanio=parseInt(anio);
       if(isNaN(nanio)){
	  status("ANIO RIB no es numero "+anio);
          document.getElementById("er").innerHTML="ERROR";
          return false;
       };	
       if(nanio<2012 || nanio>2030){
	status("ANIO RIB incorrecto "+nanio);
        document.getElementById("er").innerHTML="ERROR";
        return false;
     };
     t=t.substring(9,30);
   }
   else{	
    anio=t.substring(0,5);
    if(anio.substring(4,5)!="-"){
	status("Formato RIB incorrecto [RIB-]ANIO-NUM...");
        document.getElementById("er").innerHTML="ERROR";
        return false;
    };
    anio=anio.substring(0,4);
    nanio=parseInt(anio);
    if(isNaN(nanio)){
	status("ANIO RIB no es numero "+anio);
        document.getElementById("er").innerHTML="ERROR";
        return false;
    };	
    if(nanio<2012 || nanio>2030){
	status("ANIO RIB incorrecto "+nanio);
        document.getElementById("er").innerHTML="ERROR";
        return false;
    };
    t=t.substring(5,30);
  };
    pg=t.indexOf("-");
    if(pg<1){
	status("Formato RIB incorrecto ...NUM-REPART.");
        document.getElementById("er").innerHTML="ERROR";
        return false;
    };
    nume=t.substring(0,pg);
    if(!esnumerico(nume)){
	status("NUM RIB no es numero");
        document.getElementById("er").innerHTML="ERROR";
        return false;
    };
  		
  };
 status("");
 document.getElementById("er").innerHTML="";
 return true;	
}
function valida_dni(){
  dni=document.getElementById("i_dni").value.replace(".","").replace(".","");
  document.getElementById("i_dni").value=dni;
  valida_entero("i_dni");	
}
function esnumerico(nume){
  for(i=0;i<nume.length;i++){
    di=nume.substring(i,i+1);
    if(di>"9" || di<"0"){ return false;};
  };
  return true;
}

function valida_ide() {
valida_0("i_apel");
valida_0("i_nomb");
valida_fecha("i_aced",1);
valida_fecha("i_fnac",1);
if(!valida_rib()){return false;};
tdoc=document.getElementById("i_tdoc").value;
ndoc=document.getElementById("i_dni").value;
if (tdoc==-1 && ndoc>1000000) {status("Tipo de documento es un campo obligatorio");return false;};
if (tdoc!=-1 && ndoc=="") {status("N&uacute;mero de documento es un campo obligatorio");return false;};
if (document.getElementById("i_apel").value=="") {status("Apellidos es un campo obligatorio");return false;};
if (document.getElementById("i_nomb").value=="") {status("Nombres es un campo obligatorio");return false;};
edad=parseInt(document.getElementById("i_edad").value);
mese=parseInt(document.getElementById("i_mese").value);
actu=document.getElementById("i_aced").value;
if ((!isNaN(edad)||!isNaN(mese))&&actu=="") {status("Fecha de referencia es obligatoria si se indica edad o meses");return false;};
gene=document.getElementById("i_gene").value;
if(i_gene==0){status("identidad de g&eacute;nero es un campo obligatorio");return false;};
if(document.getElementById("cuil").value!="" && vcuil("cuil")==false){
  status("x");
  return false;
}
status("");
return true;
}
</script>
</div>
<div class="container">
<form class="form-inline" method='post' action='actualizaidentidad' onsubmit='return valida_ide()'>
<div class="form-group has-warning">
<div class='table-responsive'>
<table class="table">
<tr class='bg-primary'>
<th>Apellidos</th>
<th>Nombres</th>
<th>Otros Nombres</th>
</tr>
<tr>
<td><input  class="form-control" size='40' maxlength='45' name='iapellidos' id='i_apel' onblur='valida_0("i_apel")' value="<?php echo $dt['apellidos'];?>" <?php echo $rib;?>></td>
<td><input  class="form-control" size='40' maxlength='45' name='inombres' id='i_nomb'  onblur='valida_0("i_nomb")' value="<?php echo $dt['nombres'];?>" <?php echo $rib;?>></td>
<td><input  class="form-control" size='40' maxlength='45' name='iapodos' id='i_apod'  onblur='valida_0("i_apod")' value="<?php echo $dt['apodos'];?>"><input size='4' hidden readonly  name='ilegajo' id='i_leg' value="<?php echo $dt['legajo'];?>"></td>
</tr>
</table>
<table class='table'>
<tr class='bg-primary'>
<th>T.Doc.</th>
<th>Nro.Doc.</th>
<th>Edad</th>
<th>Meses</th>
<th>F.Act.</th>
<th>F. Nacimiento</th>
</tr>
<tr>
<td><select class="form-control" name='itdoc' id='i_tdoc' <?php  echo $rib;?>><?php echo tbla('tipodoc');?></select></td>
<td><input  class="form-control" size='8' name='idni'  maxlength='10'  id='i_dni' onblur='valida_dni()' value="<?php echo $dt['sujetosdni'];?>" <?php echo $rib;?>></td>
<td><input  class="form-control" size='3' name='iedad'   maxlength='3' id='i_edad' onblur='valida_entero("i_edad")' value="<?php echo $dt['sujetosedad'];?>"> </td>
<td><input  class="form-control" size='2' name='imese'   maxlength='2' id='i_mese' onblur='valida_entero("i_mese")' value="<?php echo $dt['sujetosmeses'];?>"> </td>
<td><input  class="form-control" size='10' name='iactedad'  maxlength='10'  id='i_aced' onblur='valida_fecha("i_aced",1)' value="<?php echo ffec($dt['sujetosactedad']);?>"></td>
<td><input  class="form-control" size='10' name='ifnacimiento'   maxlength='10' id='i_fnac' onblur='valida_fecha("i_fnac",1)'  value="<?php echo ffec($dt['f_nacimiento']);?>" <?php echo $rib;?>></td>
</tr>
</table>
<table class='table'>
<tr class='bg-primary'>
<th>Nacionalidad</th>
<th>Sexo s/DNI</th>
<th>Id. de G&eacute;nero</th>
</tr>
<tr>
<td><select class="form-control" name='nacionalidad' id='nacionalidad'><?php echo $paises?></select></td>
<td><select  class="form-control" id='i_sexo' name='isexo' required><option value=''>S/D</option><option value='F'>Femenino</option><option value='M'>Masculino</option><option value='X'>X Otros</option></select></td>
<td><select class="form-control"  name='i_gene' id='i_gene'> 
<?php echo opc_tabla('GENER');?>
</select></td>
</tr>
</table>
<table class='table'>
<tr class='bg-primary'>
<th>RIB A&ntilde;o-N&uacute;mero-Repartici&oacute;n</th>
<th>CUIL</th>
</tr>
<tr>
<td><input class="form-control" size='25' maxlength='35' name='rib' id='rib' onblur='valida_rib()' value='<?php echo rib2($dt); ?>'>&nbsp;<var class="form-control text-warning" id="er"></var></td>
<td><input class="form-control"  name='cuil' id='cuil' size='11' maxlength='11'  onblur='vcuil(this.id)' value='<?php echo $dt["cuil"]?>'></td>
</tr>
</table>

<table class="table">
<tr class="bg-primary">
<th>&Uacute;ltima Residencia Familiar</th>
</tr>
<tr>
<td><select class="form-control"  name='ilocprocedencia' id='i_lopr'><?php echo $opci;?></select></td>
</tr>
</table>


<table class="table">

<tr class='bg-primary'><th>Sit.Calle - Localidad</th>
<th>Lugar</th>
<th>Legajo Interno</th>
<th>Abierto</th>
<th>Cerrado</th>
</tr>
<tr>
<td><select class="form-control"  name='ilocparada' id='i_lopa'><?php echo $opci;?></select></td>
<td><input class="form-control"  size='30' maxlength='45' name='ilugparada' id='i_lupa'  onblur='valida_0("i_lupa")' value="<?php echo $dt['lugparada'];?>"></td>
<td><input class="form-control"  size='4' maxlength='5' name='ilocal' id='i_lloc' onblur='valida_entero("i_lloc")'  value="<?php echo $dt['legajolocal']; ?>"></td>
<td><select class="form-control"  name='iabie' id='iabi'><?php echo $sino?></select></td>
<td><select class="form-control"  name='icerr' id='icer'><?php echo $nosi?></select></td>
</tr>
</table>

</div>

<br>

<input class="form-control"  class='bg-primary' type="submit" name="ienviar" value="Enviar Datos">
</div>
</form>

</div>

<script langtype='text/javascript'>
if("<?php echo $dt['nacionalidad']?>">"0"){seleccionar("nacionalidad","<?php echo $dt['nacionalidad'];?>");}else{seleccionar("nacionalidad","9");};
seleccionar("i_lopa","<?php echo $dt['locparada'];?>");
seleccionar("i_lopr","<?php echo $dt['locvivienda'];?>");
seleccionar("i_sexo","<?php echo $dt['sexo'];?>");
seleccionar("i_gene",<?php echo $dt['genero'];?>);
seleccionar("iabi","<?php echo $dt['abi']; ?>");
disa=document.getElementById("i_tdoc").disabled;
document.getElementById("i_tdoc").disabled=false;
seleccionar("i_tdoc","<?php echo $dt['tipodni'];?>");
document.getElementById("i_tdoc").disabled=disa;
function vcuil(id){
  scuil=document.getElementById(id).value;  

  if( validaCuit(scuil)==false){
    status("digito verificador CUIL incorrecto");
  }
  else{
    status("");
  }
}
</script> 
</body>
</html>