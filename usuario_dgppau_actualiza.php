<?php 
session_start();
include("Funciones.php");
if (!isset($_SESSION['gldispo'])||!isset($_POST["id"])) header ("Location: index.php");
$idusua=$_POST["id"];
$apusua=$_POST["apellido"];
$nousua=$_POST["nombre"];
$cuil=$_POST["cuil"];
$pwusua=$_POST["password"];
$emusua=$_POST["email"]; 
$seusua=$_POST["sector"];
$perfil=$_POST["perfil"];
if ($apusua <>"" and $nousua<> "" and $seusua<>0 and $pwusua<>"INCORRECTO") 
  {
   $sql="update usuarios set nombre='".$nousua."', apellido='".$apusua."', cuil=".tsql($cuil).", password='".$pwusua."', sector=".$seusua.
      ", email='".$emusua."', perfil=".$perfil.
      " where id=".$idusua;
    ejecute($sql);
    $texto="Usuario Modificado ".$apusua.", ".$nousua;
    registro_rapido($texto);
	if ($idusua==$_SESSION['glidusua']) {
   		$_SESSION['gldispo'] = $seusua;
   		$_SESSION['glusua'] = $apusua.", ".$nousua;
		$dump=un_registro("select denominacion from sectores where id=".$_SESSION['gldispo']); 
		$_SESSION['glnombdispo']=$dump['denominacion'];
		$dump=un_registro("select denominacion, menu from perfiles where id=".$perfil);
		$_SESSION['glperfil']=$dump['denominacion'];
		$_SESSION['menu']=$dump['menu'];
		Redirect($_SESSION['menu']);
    };
	Redirect ("usuarios_dgppau"); 
   };

?>
