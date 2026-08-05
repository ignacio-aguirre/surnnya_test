<?php 
session_start();
include("funciones.php");
$usua=tpost("usua");
$pass=tpost("pass");

if($usua=="''" || $pass=="''"){salidas('sin datos');};

$u = un_registro  ("select * from movil_usuarios where baja is null and acronimo=".$usua."  and password=".$pass);

if(is_null($u)){  salidas("no encontro usuario");};
if($u["email"]==""){ die("Usuario sin email registrado");};
$_SESSION["usuario"]=$u["id"];
$_SESSION["nusuario"]=$u["apellidos"].", ".$u["nombres"];
$_SESSION["supervisa"]="nada";
$_SESSION["perfil_moviles"]="1";
$_SESSION["menu"]="menu";

if($u["dispositivo"]=="0"){
   salidas("sin dispositivo");
}

$bloquear=registros("select * from movil_procesos where fecha_hoy<curdate() and b1_6=1 and b2_6=0 order by fecha_hoy asc");
while($blo=mysqli_fetch_assoc($bloquear)){
   bloquear($blo["id"]);
};


$idproceso=apertura();

$_SESSION["idproceso"]=$idproceso;
$_SESSION["hoy_c"]=un_campo("select fecha_hoy from movil_procesos where id=".$idproceso);   
$_SESSION["hoy_v"]=ffec($_SESSION["hoy_c"]);
$_SESSION["hoy_s"]=fsql($_SESSION["hoy_v"]);
$bandeja="";
if($u["dispositivo"]>"0"){
   $_SESSION["hogar"]=$u["dispositivo"];
   $bandeja=un_campo("select bandeja from dispositivos where id=".$u["dispositivo"]);
   if(!$bandeja>"0"){salidas("sin bandeja");};
   $_SESSION["bandeja"]=$bandeja;
}   

$autenticar=0;
if($u["f_autenticado"]==""){
   $autenticar=1;
}
else{
   $dias=intval(un_campo("select datediff(curdate(),f_autenticado) from movil_usuarios where id=".$u["id"]));
   if($dias>30){ 
      $autenticar=1;
   }
};
if($autenticar==1){
   Redirect("autenticar_dispo");
};

Redirect($_SESSION['menu']);

?>
