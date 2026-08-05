<?php
include("Funciones.php");
session_start(); 

?>
<script type="text/javascript">
function valida_campos() {
var ante=document.getElementById("ante");
var actu=document.getElementById("actu");
if(!robusta(actu.value)){return false;};
var conf=document.getElementById("conf");
var control=document.getElementById("control");
ante.value=trim(ante.value.toUpperCase());
actu.value=trim(actu.value.toUpperCase());
conf.value=trim(conf.value.toUpperCase());
control.value=trim(control.value.toUpperCase());
if (ante.value==""||actu.value==""||conf.value=="") {
alert("Completar los tres campos");
enfoca("ante");
return false
};
if (ante.value!=control.value) {
alert("La contraseña actual es incorrecta");
navega('salir');
return false
};

if (ante.value==actu.value){
alert("No ha cambiado la contraseña");
enfoca("actu");
return false
};
if (actu.value!=conf.value){
alert("No coinciden los dos ingresos de nueva contraseña");
enfoca("conf");
return false
};
return true;
}
function robusta(t){
	if(t.length<8){
		status("longitud de nueva password es menor a 8");
		return false;
	}
	alert(t.length+"tl");
	cnt_min=0;
	cnt_may=0;
	cnt_dig=0;
	cnt_esp=0;
	for(i=0;i<t.length;i++){
		
		;

		if("ABCDEFGHIJKLMNOPQRSTUVWXYZ".indexOf(c)!=-1){cnt_may++;};
		if("abcdefghijklmnopqrstuvwxyz".indexOf(c)!=-1){cnt_min++;};
		if("#$().,;@-_".indexOf(c)!=-1){cnt_esp++;};
		if("0123456789".strpos(c)!=-1){cnt_dig++;};
	};
	if(cnt_min==0){status("sin min&uacute;sculas");return false;};
	if(cnt_may==0){status("sin mayu&uacute;sculas");return false;};
	if(cnt_dig==0){status("sin n&uacute;meros");return false;};
	if(cnt_esp==0){status("sin caracteres especiales permitidos");return false;};
	status("");
	return true;
}
</script>
<?php
$_SESSION["prestacion"]="Cambiar Contrase&ntilde;a Propia";
$_SESSION["sinmenu"]="1";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");

$actual=un_registro("select password as contra from usuarios where id=".$_SESSION['glidusua']);
?>
</div>
<div class="container">
	<p class="text-primary">La nueva contrase&ntilde;a debe tener 8 caracteres m&iacute;nimo, contener al menos una letra may&uacute;scula, otra min&uacute;scula m&iacute;nimo, un d&iacute;gito num&eacute;rico y alg&uacute;un caracter especial entre #$().,;@-_	</p>
<form class="form-inline" action='contrasena_do' method='POST' onsubmit='return valida_campos()'>

<div class="form-group has-warning">
<label class="label-form" for="ante">Contrase&ntilde;a Actual</label>
<input class="form-control" type='password' name='iante' id='ante' size="10" autofocus>
</div>
<div class="form-group has-warning">
<label class="label-form" for="actu">Nueva Contrase&ntilde;a</label>
<input class="form-control" type='password' name='iactu' id='actu' size=10>
</div>
<div class="form-group has-warning">
<label class="label-form" for="conf">Reingresar Nueva Contrase&ntilde;a</label>
<input class="form-control" type='password'  name='iconf' id='conf' size=10>
<input type='hidden' name='icontrol' id='control' value='<?php echo $actual['contra'];?>'>
</div>
<input class="form-control" type='Submit' value='Enviar datos'>
</form>
</div>
<script type="text/javascript">
</script>
</body>
</html>