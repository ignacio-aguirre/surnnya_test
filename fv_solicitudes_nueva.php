<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Nueva Solicitud de Intervenci&oacute;n";
include("encabezado.php");
$legajo=nget("legajo");
if($legajo=="null"){$legajo="";};
$cant=un_campo("select count(*) from fv_participaciones where legajo<0 and usuario=".tsql($_SESSION["glusua"]));
if($cant>0){
ejecute("delete from fv_participaciones where legajo<0 and usuario=".tsql($_SESSION["glusua"]));
echo "Se han borrado ".$cant." solicitudes cargadas de forma incompleta.";
};
?>
</div>
<div class="container">
<form class="form-inline" method="GET"  onsubmit="return valida()">
        <div class="form-group has-warning">
   	  <label class="label-form">Legajo del Grupo Familiar por el que se solicita la Intervenci&oacute;n</label>
          <input class="form-control" id="legajo" name="legajo" size="6" maxlenght="6" required autofocus value="<?php echo $legajo?>">
	</div>
 
       
<button class="btn-sm btn-primary" type="submit">Buscar Grupo Familiar</button>
</form>
<div class="table-responsive">
 <table class="table-condensed">
  <tr class="bg-primary"><th>Id</th><th>Descripci&oacute;n</th><th>Domicilio</th><th>NNYA</th><th>Seleccionar</th></tr>
  <?php if(isset($_GET["legajo"])){
   $reg=registros("select * from fv_familias where legajomanual=".nget("legajo"));
   while($r=mysqli_fetch_assoc($reg)){
    $esta=un_campo("select estado_sol(20200101,curdate(),fecha_articulacion,fecha_rechazo,fecha_asignacion,fv_participaciones.fecha_baja,fecha_ingreso,fecha_cancelacion) as estado 
  from fv_participaciones where familia=".$r["idfv_familias"]);
    $nnya=un_campo("select count(*) as cosa from fv_familias_miembros where familia=".$r["idfv_familias"]." and fecha_baja is null");
    if($esta!="EVALUACION" && $nnya>0){	
    echo "<tr><td>".$r["idfv_familias"]."</td><td>".$r["descripcion"]."</td><td>".$r["domicilio"]."</td><td>".$nnya."</td><td>";
    echo "<button class=btn-sm btn-warning onclick='elige(".$r["idfv_familias"].")'>Seleccionar</button></td></tr>";
     };
  }
  };
 ?>
 </table>
</div>
</div>
<script>
function valida(){
 valida_entero("legajo"); 
 return (document.getElementById("legajo").value>0);
}
function elige(id){
 navega("fv_solicitud_crea?familia="+id);
}
</script>

</body>
</html>