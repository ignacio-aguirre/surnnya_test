<?php

include("Funciones.php"); 

session_start();

if (!isset($_SESSION['gldispo'])) header ("Location: salir");

if ($_SESSION['menu']!='mnu_dipp' && $_SESSION['menu']!='mnu_usua') header ("Location: salir");

$idmenu=24;
$_SESSION['menu']='mnu_usua';
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

           

           echo '<li'.si($r["orden"]==$orden,' class="active"','').'><a href="'.$_SESSION["menu"].'?id='.$r["orden"].'">'.$r["titulo"].'</a></li>';

          

           

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

      <h2>Bienvenidos a SURNNYA</h2>

      <h3>Men&uacute; <?php echo $titulo;?></h3>

      <p>Eleg&iacute; entre las opciones del men&uacute; a la izquierda</p>
	<br><br>
      <p>O seleccion&aacute; un rol para navegar m&aacute;s opciones</p>

      <a href="roles" class="btn btn-success">Seleccion&aacute; un Rol</a><br> 	  
     
</div>

    

  </div>

</div>

</div>





</div>

<footer class="container-fluid text-center">

  <p>CDNNYA - DIPP</p>

</footer>





</body>

</html>







<script type='text/javascript'>

var ocurre=1800;

var myVar=setInterval(function(){myTimer()},1000);



</script>



<div id='fechahora' style="position:absolute;left:1100px;top:400px;max-width:400px;max-height:500px">
</div>
</body>
</html>

