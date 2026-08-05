<?php 
include("Funciones.php");
session_start();
registre();
$_SESSION["prestacion"]="Unificar legajos de un mismo Nnya";
//if($_SESSION["glidperfil"]!=7) Redirect($_SESSION["menu"]);
$leg1="";
$leg2="";
include("encabezado-test.php");
?>
</div>
<div class="container">

Para unificar dos legajos tienen que tener un nombre en comun y un apellido en comun y un mismo nro. de documento<br>

Antes de hacerlo, ver cual de los dos tiene datos mas completos en la primera pantalla y elegir luego que quede ese<br>

<form method="POST" onsubmit="return valida_datos();">
<div class="form-group has-warning">
<label class="label-form" for="apellido">Apellido</label>
<input class="form-control" size="30" maxlenght="45" id="apellido" name="apellido" onblur="valida_0('apellido')">
</div>
<div class="form-group has-warning">
<label class="label-form" for="nombre">Nombre</label>
<input class="form-control" size="30" maxlenght="45" id="nombre" name="nombre" onblur="valida_0('nombre')">
</div>
<div class="form-group has-warning">
<label class="label-form" for="dni">DNI</label>
<input class="form-control" id="dni" name="dni" maxlenght="8" size="6" onblur="valida_entero('dni')">
</div>
<input class="form-control" type="submit" value="Unificar">
</form>



<script type="text/javascript">

function valida_datos(){

 ape=document.getElementById("apellido").value;

 nom=document.getElementById("nombre").value;

 dni=document.getElementById("dni").value;

 if(ape==""||nom==""||dni=="") {status("completar todos los campos");return false;};

 status("");

 return true;

}

</script>



<div class="table-responsive">

<table class="table">

<tr class="bg-primary"><th>Legajo</th><th>Apellidos</th><th>Nombres</th><th>Fnac</th><th>Nro.Doc</th></tr>

<?php   
$leg1="";
$leg2="";

 if(isset($_GET["leg1"])) {

    if($_GET["leg1"]!=""&&$_GET["leg2"]!="") {
     unificar($_GET["leg1"],$_GET["leg2"]);
     registro_rapido("Unifica legajo ".$_GET["leg1"]." con ".$_GET["leg2"]);	
    };
    Redirect($_SESSION["menu"]);

 };

 if(isset($_POST["apellido"])) {

   $sql="select * from sujetos where apellidos like '%".$_POST["apellido"]."%' and nombres like '%".$_POST["nombre"]."%'";

   if($_POST["dni"]!="") $sql=$sql." and sujetosdni =".$_POST["dni"];

   $sql=$sql." limit 2";

   $reg=registros($sql);



   while ($r=mysqli_fetch_assoc($reg)){

     echo colorfila()."<td>".$r["Legajo"]."</td><td>".$r["Apellidos"]."</td><td>".$r["Nombres"]."</td><td>".ffec($r["f_nacimiento"])."</td><td>".$r["sujetosDNI"];

     echo "</td></tr>";

     if($leg1=="") $leg1=$r["Legajo"];

     if($leg1!="") $leg2=$r["Legajo"];

   };

 };
function unificar($viejo,$nuevo){
  ejecute("update hogares_admision set admi_legajo=".$nuevo." where admi_legajo=".$viejo);
 ejecute("update altasybajas set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update altasybajas_log set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update archivos_vinculos set identificador=".$nuevo." where tipo='S' and identificador=".$viejo);
 ejecute("update sujetos_medidas set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update intervenciones set inter_legajo=".$nuevo." where inter_legajo=".$viejo);
 ejecute("update sujetos set apellidos='UNIFICADO', nombres=concat('CON LEGAJO ',".$nuevo."), cerrado=1, sujetosdni=null where legajo=".$viejo);
 ejecute("update sujetos_escuela set esco_legajo=".$nuevo." where esco_legajo=".$viejo);
 ejecute("update sujetos_familia set fami_legajo=".$nuevo." where fami_legajo=".$viejo);
 ejecute("update sujetos_pae set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update grupos_legajos set grupo_legajo=".$nuevo." where grupo_legajo=".$viejo);
 ejecute("update legajos set legajounico=".$nuevo." where legajounico=".$viejo);
 ejecute("update pae_nomina set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update pae_supervisiones set legajo=".$nuevo." where legajo=".$viejo);
 ejecute("update fv_familias_miembros set legajo=".$nuevo." where legajo=".$viejo);

return true;
}
?>

</table>
</div>


<button class="btn-primary" onclick="navega('unificar?leg1=<?php echo $leg1?>&leg2=<?php echo $leg2?>')">Unificar queda legajo <?php echo $leg2;?></button><br>

<button class="btn-warning" onclick="navega('unificar?leg1=<?php echo $leg2?>&leg2=<?php echo $leg1?>')">Unificar queda legajo <?php echo $leg1;?></button><br>



</div>



</body>

</html>

