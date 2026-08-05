<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Borrar Acciones"; 
registre();
$id=$_GET["iid"];
$reto=$_GET["retorno"];
if (isset($_GET["borrar"])) {
ejecute("delete from intervenciones where idintervenciones=".$id);
Redirect($reto);
}
else
{
include("encabezado.php");
$sql="select *, date_format(inter_fecha,'%d/%m/%Y') as fecha, sectores.denominacion as dispo, tablas.deno as tipo from intervenciones
 left join sectores on inter_dispo=sectores.id
 left join tablas on tablas.tipo='TINT' and inter_tipo=valo 
 left join sujetos on inter_legajo=sujetos.legajo  
where idintervenciones=".$id;
$da = un_registro($sql);
$apyn=$da["Apellidos"]." , ".$da["Nombres"];
$fecha=$da["fecha"];
$dispo=$da["inter_dispo"];
$oper=$da["inter_oper"];};
?>
</div>
<div class="container">
 <p class="text-warning">Est&aacute;s a punto de eliminar la siguiente acci&oacute;n:</p>
 <div class="table-responsive">
  <table class="table">
  <tr class="bg-primary"><th>Efector</th><th>Fecha</th><th>Operador</th><th>Sujeto</th><th>Tipo</th></tr>
  <tr><td><?php echo $da['dispo'];?></td><td><?php echo $fecha;?></td><td><?php echo $oper;?></td><td><?php echo $apyn;?></td><td><?php echo $da['tipo'];?></td></tr>
  </table>

  <table class="table">
  <tr class="bg-primary"><th>Observaciones</th></tr>
  <tr><td><?php echo $da['inter_obse'];?></td></tr>

<script type="text/javascript">

window.clipboardData.setData("Text", "<?php echo $da['inter_obse'];?>"); 

</script>

   </table>
  </div> 
<p class="text-warning">El texto de las observaciones se ha copiado en el portapapeles.<br>
Esta operaci&oacuten no puede deshacerse.<br>
Volv&eacute; atr&aacute;s con el navegador o presiona el bot&oacute;n Borrar para eliminar la acci&oacute;n</p>

<button class="btn-primary" onclick='navega("interborra?iid=<?php echo $id;?>&borrar=1&retorno=<?php echo $reto;?>")'>Borrar la Intervenci&oacute;n</button>

</div>

</body>

</html>