<?php 
session_start();
include("funciones.php");
include("static/par-conexion.php");
$usua=$_GET["user"];
$pass=$_GET["password"];
if ($usua<> "" and $pass<>"") {
  $usuario = un_registro("select * from usuarios where email=".tsql($usua));
  if ($usuario['apellidos']!="" and $usuario['intentos']<5 and password_verify($pass,$usuario["password"]) ) {
      $_SESSION["usuario"]=$usuario["idusuarios"];
      $_SESSION["escritura"]=$usuario["supervisa_sector"];
      $_SESSION["sistema"]=$usuario["supervisa_sistema"];
      $_SESSION["simple"]=$usuario["acceso_simple"];
      $_SESSION["DiaHoy"]=ffec(un_campo("select curdate() from dual"));
      inserte("insert into log_acceso(usuario) values('".$usuario["apellidos"].", ".$usuario["nombres"]."')");
      Redirect("menu");
      die(password_hash($pass,PASSWORD_DEFAULT));
    } else  if($usuario['apellidos']!="" and $usuario['intentos']==5) {$a=1;} else{ejecute("update usuarios set intentos=intentos+1 where  email='".$usua."'");};
}
$_SESSION["usuario"]=-1;
Redirect(".");
?>

</body>
</html>