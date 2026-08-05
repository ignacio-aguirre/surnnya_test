<?php 
include("funciones.php");
session_start();
$usua=$_GET["user"];
if ($usua<> "" ) 
{
  
  $usuario = un_registro("select * from usuarios where email=".tsql($usua));


   if ($usuario['apellidos']!="" ) 

    {
      $_SESSION["usuario"]=$usuario["idusuarios"];

     
      


           Redirect("nuevapassword");

     
      die(password_hash($pass,PASSWORD_DEFAULT));
    

    };
}

   
$_SESSION["usuario"]=-1;


Redirect("index");

?>



</body>
</html>