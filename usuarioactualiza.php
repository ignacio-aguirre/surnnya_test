<?php 
session_start();
include("Funciones.php");
if (!isset($_SESSION['gldispo'])||!isset($_POST["id"])) header ("Location: .");
$idusua=$_POST["id"];
$apusua=$_POST["apellido"];
$nousua=$_POST["nombre"];
$cuil=$_POST["cuil"];
$pwusua=$_POST["password"];
$emusua=$_POST["email"]; 
$tipo_usuario=tpost("tipo_usuario");
if(isset($_POST['dispositivo'])) {$dispositivo=npost("dispositivo");
} else{$dispositivo="0";};
if(isset($_POST['sector'])) {$sector=$_POST["sector"];}
else{$sector="0";};
if(isset($_POST['perfil'])) {$perfil=$_POST["perfil"];}
else{$perfil="0";};
if ($apusua <>"" and $nousua<> "" and $pwusua<>"INCORRECTO") 
  {
   $sql="update usuarios set nombre='".$nousua."', apellido='".$apusua."', cuil=".tsql($cuil).", password='".$pwusua."', sector=".$sector.
      ", email='".$emusua."', perfil=".$perfil.", tipo_usuario=".$tipo_usuario.", dispositivo=".$dispositivo. " where id=".$idusua;
    ejecute($sql);
    $texto="Usuario Modificado ".$apusua.", ".$nousua;
    registro_rapido($texto);
	Redirect ("usuarios"); 
   };

?>
