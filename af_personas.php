<?php
require("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registro de Personas";
include("encabezado.php");
if(isset($_GET["identificador"])) {
 $identificador=$_GET["identificador"];
 $apellidos=tsql($_GET["apellidos"]);
 $nombres=tsql($_GET["nombres"]);
 $tipodoc=nulea($_GET["tipodoc"]);
 $nrodoc=nulea($_GET["nrodoc"]); 
 $fecha_nacimiento=fsql($_GET["fecha_nacimiento"]);
 $edad=nulea($_GET["edad"]);
 $nacionalidad=nulea($_GET["nacionalidad"]);
 $genero=tsql($_GET["genero"]);
 $estadocivil=nulea($_GET["estadocivil"]);
 $fecha_actualizacion=fsql($_GET["fecha_actualizacion"]);
 $caba=nulea($_GET["caba"]);
 $barrio=tsql($_GET["barrio"]);
 $comuna=nulea($_GET["comuna"]);
 $localidad=tsql($_GET["localidad"]);
 $partido=tsql($_GET["partido"]);
 $calle=tsql($_GET["calle"]);
 $otras=tsql($_GET["otras"]);
 $email=tsql($_GET["email"]);
 $telefonos=tsql($_GET["telefonos"]);
 $ocupacion=tsql($_GET["ocupacion"]);
 $familia_pertenencia=nget("familia_pertenencia");
 $vinculo=nget("vinculo");
 $conviviente=nget("conviviente");
 if($identificador==0) {
	 $identificador=inserte("insert into personas(apellidos) values(".$apellidos.")");
 }	 
 ejecute("update personas set apellidos=".$apellidos.", nombres=".$nombres.", tipodoc=".$tipodoc.", nrodoc=".$nrodoc.", fecha_nacimiento=".$fecha_nacimiento." where idpersonas=".$identificador);
 ejecute("update personas set edad=".$edad.", nacionalidad=".$nacionalidad.", genero=".$genero.", estadocivil=".$estadocivil.", fecha_actualizacion=".$fecha_actualizacion." where idpersonas=".$identificador);
 ejecute("update personas set caba=".$caba.", barrio=".$barrio.", comuna=".$comuna.", localidad=".$localidad.", partido=".$partido.", callenro=".$calle.", otros_domicilio=".$otras.", email=".$email.", telefonos=".$telefonos.", ocupacion=".$ocupacion." where idpersonas=".$identificador);
 ejecute("update personas set familia_pertenencia=".$familia_pertenencia.", vinculo=".$vinculo.", conviviente=".$conviviente." where idpersonas=".$identificador);
 Redirect("consultapersonas");
};
$id="";
if(isset($_GET["id"])) $id=$_GET["id"];
$r=un_registro("select *, edc(fecha_nacimiento,edad,null,fecha_actualizacion,null) as eda from personas where idpersonas=".$id);
?>
<div class="container">
<form method="GET" onsubmit="return valida_datos()">
<div class="table-responsive">
<table class="table">
<input type="hidden" id="identificador" name="identificador" size="6" maxlength="8"  value='<?php echo $id; ?>'>
<tr><td>Apellidos</td><td><input type="text" id="apellidos" name="apellidos" size="30" maxlength="45"  onblur='valida_0(this.id)' value='<?php echo $r["apellidos"];?>'></td>
<td>Nombres</td><td><input type="text" id="nombres" name="nombres" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["nombres"];?>'></td></tr>
<tr><td>Tipo de Documento</td><td><select id="tipodoc" name="tipodoc"><?php echo tbla("tipodoc");?></select></td>
<td>Nro. de Documento</td><td><input type="text" id="nrodoc" name="nrodoc" size="6" maxlength="10" onfocus='solosino("tipodoc",0,"fecha_nacimiento")' onblur='sale_nrodoc()'  value='<?php echo $r["nrodoc"];?>'></td></tr>
<tr><td>Fecha de Nacimiento</td><td><input type="text" id="fecha_nacimiento" name="fecha_nacimiento" size="8" maxlength="10" onblur='valida_fecha(this.id,"1")'  value='<?php echo ffec($r["fecha_nacimiento"]);?>'></td>
<td>Edad</td><td><input type="text" id="edad" name="edad" size="12"  onfocus='solosi("fecha_nacimiento","","nacionalidad")' value='<?php echo $r["eda"];?>'></td></tr>
<tr><td>Nacionalidad</td><td><select id="nacionalidad" name="nacionalidad"><?php echo tbla("nacionalidad");?></select></td>
<td>G&eacute;nero</td><td><select id="genero" name="genero"><option value='F'>Femenino</option><option value='M'>Masculino</option></select></td>
<td>Estado Civil</td><td><select id="estadocivil" name="estadocivil"><?php echo tbla("estadocivil");?></select></td></tr>
<tr>
<td>Domicilio Caba/GBA/Otros</td>
<td><select id="caba" name="caba" onchange="sale_caba()"><?php echo tbla("caba");?></select></td>
<tr><td>Domicilio Calle y Nro.</td>
<td><select id='sugerencias' disabled onblur='copiadom()'></select>
<input type="text" id="calle" name="calle" size="30" maxlength="100"   value='<?php echo $r["callenro"];?>'></td>
<td>Piso, depto, casa, manzana, etc.</td><td><input type="text" id="otras" name="otras" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["otros_domicilio"];?>'></td>
</tr>
<tr><td>Caba:Barrio</td>
<td><input type="text" id="barrio" name="barrio" size="30" maxlength="45" onfocus='solosi("caba",1,"localidad")' onblur='valida_0(this.id)'  value='<?php echo $r["barrio"];?>'></td>
<td>Caba:Comuna</td>
<td><input id="comuna" name="comuna" type="number" min="0" max="15" value="<?php echo $r['comuna']?>"></td></tr>
<tr><td>Localidad</td>
<td><input type="text" id="localidad" name="localidad" size="30" maxlength="45" onfocus='solosino("caba",1,"calle")' onblur='valida_0(this.id)' value='<?php echo $r["localidad"];?>'></td>
<td>Partido</td><td><input type="text" id="partido" name="partido" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["partido"];?>'></td></tr>
</table>
</div>

<div class="table-responsive">
<table class="table">
<tr><td>Email</td><td><input type="text" id="email" name="email" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["email"];?>'></td>
<td>Tel&eacute;fonos</td><td><input type="text" id="telefonos" name="telefonos" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["telefonos"];?>'></td></tr>
<tr><td>Ocupaci&oacute;n</td><td><input type="text" id="ocupacion" name="ocupacion" size="30" maxlength="45" onblur='valida_0(this.id)' value='<?php echo $r["ocupacion"];?>'></td>
<td>Familia</td><td><select id="familia_pertenencia" name="familia_pertenencia" required><option value=""></option><?php echo familias()?></select></td></tr>
<tr><td>V&iacute;nculo</td><td><select id="vinculo" name="vinculo" required><option value=""></option><?php echo opc_tabla("AFVIN")?></select></td>
<td>Conviviente</td><td><select id="conviviente" name="conviviente" required><option value=""></option><option value="1">SI</option><option value="0">NO</option></td><tr>
<tr><td>Fecha de Actualizaci&oacute;n</td><td><input type="text" id="fecha_actualizacion" name="fecha_actualizacion" size="6" maxlength="10" onblur='valida_fecha(this.id)' value='<?php echo ffec($r["fecha_actualizacion"]);?>'></td></tr>
</table>
</div>
<input class="btn-primary" type="submit" value="Actualizar" >
</form>
</div>
</body>
<script type="text/javascript">
enfoca('apellidos');
seleccionar("tipodoc",'<?php echo $r["tipodoc"];?>');
seleccionar("nacionalidad",'<?php echo $r["nacionalidad"];?>');
seleccionar("estadocivil",'<?php echo $r["estadocivil"];?>');
seleccionar("caba",'<?php echo $r["caba"];?>');
seleccionar("vinculo",'<?php echo $r["vinculo"];?>');
seleccionar("familia_pertenencia",'<?php echo $r["familia_pertenencia"];?>');
seleccionar("conviviente",'<?php echo $r["conviviente"];?>');


function normaliza_calle(){
 valida_0("calle");
 valida_0("localidad");
 calle=document.getElementById("calle").value;
 caba=document.getElementById("caba").value;
 if(calle!=""&&(caba==1||caba==2)){
 calle=calle.replace("�","N").replace("�","n");
 loca=document.getElementById("localidad").value;
  var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
        if(typeof objeto.errorMessage!="undefined"){alert(objeto.errorMessage);document.getElementById("calle").value="";};
        document.getElementById("sugerencias").options.length=0;
        if(objeto.direccionesNormalizadas.length==1){
        document.getElementById("calle").value=objeto.direccionesNormalizadas[0].nombre_calle+", "+objeto.direccionesNormalizadas[0].altura;
        document.getElementById("localidad").value=objeto.direccionesNormalizadas[0].nombre_localidad;
        document.getElementById("partido").value=objeto.direccionesNormalizadas[0].nombre_partido;
        document.getElementById("sugerencias").disabled=true;
        document.getElementById("sugerencias").options=[];

        };
        if(objeto.direccionesNormalizadas.length>1){
         document.getElementById("sugerencias").disabled=false;
         for(i=0;i<objeto.direccionesNormalizadas.length;i++){
	  var c = document.createElement("option");
	  c.text = objeto.direccionesNormalizadas[i].direccion;
          document.getElementById("sugerencias").options.add(c,i);
         };
        };
       };
    };
  xhttp.open("GET", "https://servicios.usig.buenosaires.gob.ar/normalizar/?direccion="+calle+","+loca, true);
  xhttp.send();
 };  
return true; 
}

function copiadom(){
  sele=document.getElementById("sugerencias");
  valor=sele.options[sele.selectedIndex].value;
 if(confirm("Aceptas "+valor+" como domicilio")){ 
  sele.options.length=0;
  posi=valor.indexOf(",");
  loca=valor.substr(posi+1);
  call=valor.substr(0,posi+1);
  document.getElementById("calle").value=call;
  document.getElementById("calle").focus();
}
else{
document.getElementById("localidad").focus();
};	
};

function sale_nrodoc(){
valida_entero("nrodoc");
nume=document.getElementById("nrodoc").value;
iden=document.getElementById("identificador").value;
if(nume!=""){
 if(document.getElementById("tipodoc").value==-1)  seleccionar("tipodoc",1);
 url="ej?tipo=PERSONA_CONS&id="+nume;
 pet = new XMLHttpRequest();
 pet.open('GET', url, false);
 pet.send(null);
 var resp = pet.responseText;
 if(resp>"0") {
  if(iden=="0") {alert("El n�mero de documento ingresado ya est� en la base de datos."); document.getElementById("nrodoc").value="";seleccionar("tipodoc",-1); return false;};
 }; 
};
}



function valida_identificador(){

valida_entero("identificador");

id=document.getElementById("identificador");

if(id.value!="") {

    url="ej?tipo=PERSONA_CONS&id="+id.value;

    pet = new XMLHttpRequest();

    pet.open('GET', url, false);

    pet.send(null);

    var resp = pet.responseText;

    if(resp=="0") {navega("af_personas");} else {

    url="ej?tipo=PERSONA_UNREGISTRO&id="+id.value; 

    pet = new XMLHttpRequest();

    pet.open('GET', url, false);

    pet.send(null);

    var resp = pet.responseText;

    vxml=parsear(resp);

    document.getElementById("identificador").value=vxml.getElementsByTagName('c0')[0].childNodes[0].nodeValue.trim();

    document.getElementById("apellidos").value=vxml.getElementsByTagName('c1')[0].childNodes[0].nodeValue.trim();

    document.getElementById("nombres").value=vxml.getElementsByTagName('c2')[0].childNodes[0].nodeValue.trim();

    document.getElementById("nrodoc").value=vxml.getElementsByTagName('c4')[0].childNodes[0].nodeValue.trim();

    document.getElementById("fecha_nacimiento").value=ffec(vxml.getElementsByTagName('c5')[0].childNodes[0].nodeValue.trim());

    document.getElementById("edad").value=vxml.getElementsByTagName('c6')[0].childNodes[0].nodeValue.trim();

    document.getElementById("genero").value=vxml.getElementsByTagName('c8')[0].childNodes[0].nodeValue.trim();

    document.getElementById("barrio").value=vxml.getElementsByTagName('c16')[0].childNodes[0].nodeValue.trim();

    document.getElementById("localidad").value=vxml.getElementsByTagName('c17')[0].childNodes[0].nodeValue.trim();

    document.getElementById("partido").value=vxml.getElementsByTagName('c18')[0].childNodes[0].nodeValue.trim();

    document.getElementById("calle").value=vxml.getElementsByTagName('c19')[0].childNodes[0].nodeValue.trim();

    document.getElementById("otras").value=vxml.getElementsByTagName('c20')[0].childNodes[0].nodeValue.trim();

    document.getElementById("email").value=vxml.getElementsByTagName('c21')[0].childNodes[0].nodeValue.trim();

    document.getElementById("telefonos").value=vxml.getElementsByTagName('c22')[0].childNodes[0].nodeValue.trim();

    document.getElementById("ocupacion").value=vxml.getElementsByTagName('c23')[0].childNodes[0].nodeValue.trim();

    document.getElementById("fecha_actualizacion").value=ffec(vxml.getElementsByTagName('c24')[0].childNodes[0].nodeValue.trim());

         };

    } else {id.value="0";if(document.getElementById("apellidos").value!="") navega("af_personas");}



}







function pega(texto,campo){

 document.getElementById(campo).value=texto.toUpperCase();

 document.getElementById("suggestions").innerHTML="";document.getElementById("barrio").focus();

 }





function valida_datos() {
if(document.getElementById("apellidos").value=="") {status("apellidos");return false;};
if(document.getElementById("nombres").value=="") {status("nombres");return false;};
if(document.getElementById("tipodoc").value>="1" && document.getElementById("tipodoc").value<="4" && 
 document.getElementById("nrodoc").value==""){status("nrodoc");return false;};
if(document.getElementById("tipodoc").value==0 && document.getElementById("nrodoc").value!="") {document.getElementById("nrodoc").value="";};
if(document.getElementById("fecha_nacimiento").value!="" && document.getElementById("edad").value!="") {alert("se calculara edad en base a fecha nacimiento");document.getElementById("edad").value="";};
if(document.getElementById("fecha_actualizacion").value==""){status("fecha_actualizacion");return false;};
if(document.getElementById("fecha_nacimiento").value=="" && document.getElementById("edad").value=="") {status("fecha_nacimiento o edad");return false;};
if(document.getElementById("caba").value!="1" && document.getElementById("comuna").value!="0") {document.getElementById("comuna").value="0";};
if(document.getElementById("comuna").value=="0" && document.getElementById("barrio").value!="") {status("completar comuna");return false;};
if(document.getElementById("caba").value=="1" && document.getElementById("localidad").value!="") {document.getElementById("localidad").value="";status("localidad no para caba");return false;};
if(document.getElementById("caba").value=="1" && document.getElementById("partido").value!="") {document.getElementById("partido").value="";status("partido no para caba");return false;};
status("");
return true;
};

function sale_caba(){
caba=document.getElementById("caba").value;
if(caba==1){
  document.getElementById("localidad").value="CABA";
  document.getElementById("localidad").disabled=true;
  document.getElementById("barrio").disabled=false;
  document.getElementById("comuna").disabled=false;

}
else {
 if(document.getElementById("localidad").value=="CABA"){document.getElementById("localidad").value="";};
  document.getElementById("localidad").disabled=false;
  document.getElementById("barrio").value="";
  document.getElementById("comuna").value="";
  document.getElementById("barrio").disabled=true;
  document.getElementById("comuna").disabled=true;

};
}


function solosi(control,valor,proximo){

if(document.getElementById(control).value!=valor) document.getElementById(proximo).focus();

}



function solosino(control,valor,proximo){

if(document.getElementById(control).value==valor) document.getElementById(proximo).focus();

}





</script>

<?php
function familias(){
$t="";
$fam=registros("select idaf_familias,denominacion from af_familias order by denominacion");
while($f=mysqli_fetch_assoc($fam)){
 $t=$t."<option value='".$f["idaf_familias"]."'>".$f["denominacion"]."</option>";
};
return $t;
}
?>



</html>

