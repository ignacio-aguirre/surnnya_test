<?php
include("Funciones.php");
session_start(); 
if (!isset($_SESSION["gldispo"])) header ("Location: salir");
$hogar=$_GET["hogar"];
$familia="0";
if(isset($_GET["familia"])) $familia=$_GET["familia"];
$_SESSION["prestacion"]="Nueva Acci&oacute;n - Hogar/Dispositivo ".un_campo("select nombre from dispositivos where dispositivos.id=".$hogar);
include("encabezado-test.php");
if(isset($_GET["tipo"])) {ejecute("insert into hogares_intervenciones(fecha,hogar,familia,supervisores,texto,usuario,tipo) values(".fsql($_GET["fecha"]).",".$hogar.",".$familia.",'".$_GET["super"]."',".tsql($_GET["detalle"]).",'".$_SESSION["glusua"]."',".$_GET["tipo"].")");

  Redirect(si($familia!="0","af_familias?id=".$familia,"consultahogar?id=".$hogar));};

registre();

$opc=tbla("TINTH");

?>
</div>
<div class="container">

<form method='get' onsubmit='return valida_datos()'>

<fieldset>

<label>Fecha</label><input size="8" maxlength="10" id="fecha" name="fecha" onfocus="valida_fecha(this.id)" onblur="valida_fecha(this.id)"><br>

<label>Tipo de Acci&oacute;n</label><select id="tipo" name="tipo"><?php echo $opc;?></select><br>

<label>Supervisores</label><input name="super" id="super" onblur="valida_0(this.id)" size="30" maxlength="35"><br>

<label>Detalle</label><textarea id="detalle" name="detalle" cols="150" rows="30" maxlength="10000"></textarea><br>

<input type="hidden"value="<?php echo $hogar;?>" name="hogar">

<input type="hidden"value="<?php echo $familia;?>" name="familia">

<input type="submit">

</fieldset>

</form>



<script type="text/javascript">enfoca("fecha");

function valida_datos(){

valida_fecha("fecha");

fecha=document.getElementById("fecha").value;

tipo=document.getElementById("tipo").value;

supe=document.getElementById("super").value;

deta=encodeURI(document.getElementById("detalle").value);

if(fecha!=""&&tipo!=""&&supe!=""&&deta!=""){ return true;

} else { return false;};

}

</script>

</div>