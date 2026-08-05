<?php 
session_start();
include("funciones.php");
$pass=tpost("pass");
$email=tpost("email");
$u = un_registro("select * from usuarios where baja is null and email=".$email." and password=".$pass);
if($u["id"]==""){  salidas("no encontro usuario");}; 
$_SESSION["usuario"]=$u["id"];
$_SESSION["nusuario"]=$u["apellido"].", ".$u["nombre"];
$perfil=substr(un_campo("select denominacion from perfiles where id=".$u["perfil"]),-3);
$bloquear=registros("select * from movil_procesos where fecha_hoy<curdate() and b1_6=1 and b2_6=0 order by fecha_hoy asc");
while($blo=mysqli_fetch_assoc($bloquear)){
   bloquear($blo["id"]);
}


$idproceso=apertura();
$_SESSION["idproceso"]=$idproceso;
$_SESSION["hoy_c"]=un_campo("select fecha_hoy from movil_procesos where id=".$idproceso);   
$_SESSION["hoy_v"]=ffec($_SESSION["hoy_c"]);
$_SESSION["hoy_s"]=fsql($_SESSION["hoy_v"]);
$bandeja="";
if($perfil=="B13"){
   $_SESSION["supervisa"]=$perfil;
   $_SESSION["perfil_moviles"]="2";
   $_SESSION["sector"]="0";
   $_SESSION["hogar"]="0";
   $_SESSION['bandeja']="6";
   $_SESSION["menu"]="menu_adm_dg";    
 }
else{
   $_SESSION["perfil_moviles"]="1";
   $_SESSION["menu"]="menu";
   $_SESSION["supervisa"]="nada";
   $dispo=un_campo("select hogar from sectores where id=".$u['sector']);
   $es_dispo=false;
   if($dispo>"0"){
      $bandeja=un_campo("select bandeja from dispositivos where id=".$dispo);
      if($bandeja>"0"){
         $es_dispo=true;
         $_SESSION['hogar']=$dispo;
         $_SESSION["sector"]="0";
      }
   }
   if(!$es_dispo){
     if($perfil=="DAT") {
       $bandeja="1";  
       $_SESSION["menu"]="menu_data";
     }
     else{
     $bandeja=un_campo("select bandeja from sectores where id=".$u["sector"]);
     if(!$bandeja>"0"){salidas("No se encuentra habilitaci&oacute;n para m&oacute;viles");}
     $_SESSION["sector"]=$u["sector"];
     $_SESSION["hogar"]="0";
   }
   };
   
   $_SESSION["bandeja"]=$bandeja;    
};   

$autenticar=0;
if($u["f_autenticado"]==""){
   $autenticar=1;
}
else{
   $dias=intval(un_campo("select datediff(curdate(),f_autenticado) from usuarios where id=".$u["id"]));
   if($dias>30){ $autenticar=1;}
};
if($autenticar==1){
   Redirect("autenticar");
}
Redirect($_SESSION['menu']);
?>
