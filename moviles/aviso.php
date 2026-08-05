<?php
session_start();
require("funciones.php"); 
$_SESSION["prestacion"]="Aviso";
include("encabezado.php");
$retorno=$_SESSION["retorno"];
$texto=$_SESSION["msg"];
$_SESSION["msg"]="";
$_SESSION["retorno"]="";
$cierre=false;
if(isset($_GET["cierre"])){
   $cierre=true;
}
$validar=false;
$idviaje=0;
if(isset($_GET["validar"])){
   $idviaje=nget("validar");
   $validar=true;
   
}
?>
</div>
<div class="container">
 <div class="row">
    <h4 class="col-md-12">Aviso del sistema</h4>
    <p class="text-primary"><?php echo $texto?></p><br>    <var id="revision"></var>  
 </div>
<br>
<?php if($validar){
   echo "<script>id=".$idviaje.";
   document.getElementById('revision').innerHTML='revisado '+eje('val_revisar?id='+id);</script>";
}?>
<div class="row">
   <?php if(!$cierre){?>

	<button class="btn-sm btn-success" onclick="navega('<?php echo $retorno?>')">Continuar</button>
   <?php } else {
      echo "<button class='btn-sm btn-success' onclick='window.close()'>Cerrar</button>";
   };?>			
</div>

</body>