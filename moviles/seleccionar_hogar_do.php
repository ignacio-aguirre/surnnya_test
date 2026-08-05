<?php
session_start();
include("funciones.php");
$_SESSION["hogar"]=$_GET["hogar"];
if($_SESSION["bandeja"]==""){
$_SESSION["bandeja"]=un_campo("select bandeja from dispositivos where id=".$_GET["hogar"]);};
$_SESSION["menu"]="menu";
$autenticar=0;
$u=un_registro("select * from usuarios_hogares where id=".$_SESSION["usuario"]);
if($u["f_autenticado"]==""){
   $autenticar=1;
}
else{
   $dias=intval(un_campo("select datediff(curdate(),f_autenticado) from usuarios_hogares where id=".$u["id"]));
   if($dias>10){ 
      $autenticar=1;
   }
};
if($autenticar==1){
   Redirect("autenticar_dispo");
}
Redirect($_SESSION['menu']);

?>
