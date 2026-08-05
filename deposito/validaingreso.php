<?php 
include("funciones.php");
session_start();
$usua=strtolower($_GET["user"]);
$pass=strtoupper($_GET["password"]);
if ($usua<> "" and $pass<>"") {
 $usuario = un_registro("select * from usuarios where email=".tsql($usua)." and password=".tsql($pass));
  if ($usuario['apellido']!="") {
      $_SESSION["usuario"]=$usuario["idusuarios"];
      $_SESSION["rol"]=$usuario["rol"];
      $rol=un_registro("select * from roles where id=".$usuario["rol"]);
      $_SESSION["perfil"]=$rol["perfil"];
      $perfil=un_registro("select * from perfiles where id=".$rol["perfil"]);
      $_SESSION["menu"]=$perfil["menu"];
 
      $_SESSION["hoy"]=ffec(un_campo("select curdate() from dual"));

      Redirect($_SESSION["menu"]);
  };


};


$_SESSION["usuario"]=-1;
Redirect("index");
?>



</body>


</html>