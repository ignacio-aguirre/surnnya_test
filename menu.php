<?php
include("Funciones.php"); 
session_start();
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
if (!isset($_SESSION['Opc_Hoga'])) tablas_hogares();
$idmenu=nget("mnu");
if($_SESSION['mnu']!=$idmenu){Redirect("salir?mensaje=Menu no autorizado");};
$orden="1";
if(isset($_GET["id"])){$orden=$_GET["id"];$_SESSION["posicion"]=$orden;}
else{if(isset($_SESSION["posicion"])){$orden=$_SESSION["posicion"];}};
$titulo=un_campo("select titulo from menues_superiores where menu=".$idmenu." and orden=".$orden);
$_SESSION["prestacion"]=$titulo;
include("encabezado.php");
registre();
?>

<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

        <?php

         $reg=registros("select * from menues_superiores where menu=".$idmenu."  order by orden");

         while($r=mysqli_fetch_assoc($reg)){

           

           echo '<li'.si($r["orden"]==$orden,' class="active"','').'><a href="menu?mnu='.$idmenu.'&id='.$r["orden"].'">'.$r["titulo"].'</a></li>';

          

           

         };

        ?>

      </ul>

    </div>

  </div>

</nav>

  

<div class="container-fluid text-center">    

  <div class="row content">

    <div class="col-sm-2 sidenav">

 	<?php
	include("mnu_izq.php");
        ?>   

   </div>

    <div class="col-sm-10 text-left"> 

      <h3>Men&uacute; <?php echo un_campo("select nombre from menues where idmenues=".$idmenu)?></h3>

      <h4>Submen&uacute; <?php echo $titulo;?></h4>
      <p>Eleg&iacute; entre las opciones del men&uacute; a la izquierda</p>
	<br><br>
     <?php if($idmenu==25){echo "<p>O seleccion&aacute; un rol para navegar m&aacute;s opciones</p>";
      echo '<a href="roles" class="btn btn-success">Seleccion&aacute; un Rol</a><br>';}; 	  
     if($idmenu=="8"){include("pantalla_admision.php");};?>
</div>

    

 </div>
<?php include('footer.php')?>




</body>

</html>










