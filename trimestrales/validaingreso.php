<?php 
include("funciones.php");
session_start();
$usua=$_GET["user"];
$pass=$_GET["password"];
if ($usua<> "" and $pass<>"") {
 $usuario = un_registro("select * from usuarios_hogares where baja is null and descripcion=".tsql($usua)." and password=".tsql($pass));

  $_SESSION["usuario"]=$usuario["id"];
    $_SESSION["hogar"]=$usuario["hogar"];
  $_SESSION["hoy"]=ffec(un_campo("select curdate() from dual"));
  $par=un_registro("select * from parametros limit 1");
  $_SESSION["trimestre"]=$par["trimestre"];
  $_SESSION["anio"]=$par["trimestre_anio"];
      
  if ($usuario['apellidos']!="") {
      
      if($usuario["email"]=="") die("Sin mail registrado");
      $autenticar=0;
      if($usuario["f_autenticado"]==""){
        $autenticar=1;
      }
      else{
        $dias=intval(un_campo("select datediff(curdate(),f_autenticado) from usuarios_hogares where id=".$usuario["id"]));
          if($dias>40){ $autenticar=1;}
      };
      if($autenticar==1){
        Redirect("autenticar_dispo");
      };
      if($usuario["es_multihogar"]=="1"){Redirect("seleccionar_hogar");}
      else{Redirect("menu");};
  }
else {Redirect("login_failure");};


}
else{Redirect("login_empty");};


$_SESSION["usuario"]=-1;
Redirect("index");
?>



</body>


</html>