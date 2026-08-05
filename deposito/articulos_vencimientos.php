<?php 
include("funciones.php");
session_start();
$articulo=$_GET["articulo"];
$descripcion=un_campo("select descripcion from articulos where idarticulos=".$articulo);

$_SESSION["prestacion"]="Vencimientos de art&iacute;culos en  Stock";
include("encabezado.php"); 
?>
</div>
<div class="container" align="center">
Descripci&oacute;n:<?php echo $descripcion;?><br>
Stock Total:<input id='stock' size='8' value='<?php echo un_campo("select sum(cantidad) from stock where articulo=".$articulo);?>' disabled>&nbsp;Control:<input id='control' size='8' disabled><br><br>
<div class="table-responsive">
<table id="tabla" class="table table-striped table-bordered">

<th>Vencimiento</th><th style='text-align:center'>Cantidad</th><th>Acciones</th>
<?php  $reg=registros("select f_vencimiento, cantidad from stock_vencimientos where articulo=".$articulo." order by f_vencimiento");
$reng=1;
while($r=mysqli_fetch_assoc($reg)){
 echo "<tr><td>".ffec($r["f_vencimiento"])."</td><td align='center'>".$r["cantidad"]."</td><td><img src='imagenes/editar.png' width='20' height='20' onclick='editar(".$reng.")'></td></tr>";
 $reng=$reng+1;
};
echo "<tr><td><input id='f_vencimiento' size='10' maxlength='8' onblur='valida_fecha(this.id)'></td><td align='center'><input id='cantidad' size='6' maxlength='6' onblur='valida_0(this.id)'></td><td><button class='btn-primary' onclick='agregar()'>Agregar</button></td></tr>";
?>
</table>
</div>
<button class='btn-primary' id='aceptar' onclick='aceptar()'>Terminar</button>
</div>

<script>
controla();
function controla(){
tabla=document.getElementById("tabla");
cont=0;
for(i=1;i<tabla.rows.length-1;i++) {
 cant=tabla.rows[i].cells[1].innerHTML;
 cont=cont+parseInt(cant);
};
document.getElementById("control").value=cont;
document.getElementById('aceptar').disabled=(cont!=document.getElementById("stock").value);
}
function editar(renglon){
tabla=document.getElementById("tabla");
fila=tabla.rows[renglon];
document.getElementById('vencimiento').value=fila.cells[0].innerHTML;
document.getElementById('cantidad').value=fila.cells[1].innerHTML;
tabla.deleteRow(renglon);
}
function agregar(){
valida_fecha('f_vencimiento');
valida_entero('cantidad');
vencimiento=document.getElementById('f_vencimiento').value;
cantidad=document.getElementById('cantidad').value;
if(cantidad=="") {document.getElementById('cantidad').value="0";cantidad="0";}
if(vencimiento==""){return false;};
tabla=document.getElementById("tabla");
for(i=1;i<tabla.rows.length-1;i++){
 if(vencimiento==tabla.rows[i].cells[0].innerHTML){alert("fecha duplicada");return false;};
};
fila=tabla.insertRow(tabla.rows.length-1);
cv=fila.insertCell(0);
cc=fila.insertCell(1);
ca=fila.insertCell(2);
cv.innerHTML=vencimiento;
cc.innerHTML=cantidad;
cc.style.textAlign="center";
ca.innerHTML="<img src='imagenes/editar.png' width='20' height='20' onclick='editar("+(tabla.rows.length-2)+")'>";
document.getElementById('f_vencimiento').value="";
document.getElementById('cantidad').value="";
controla();
}
function aceptar(){
arti="<?php echo $articulo;?>";
ejec("ej_stock","VENCIMIENTOS_ELIMINA","&articulo="+arti);
tabla=document.getElementById("tabla");
for(i=1;i<tabla.rows.length-1;i++){
 fila=tabla.rows[i];
 venc=fila.cells[0].innerHTML;
 cant=fila.cells[1].innerHTML;
 ejec("ej_stock","VENCIMIENTOS_AGREGA","&articulo="+arti+"&f_vencimiento="+venc+"&cantidad="+cant);
};
navega("mn_stock");
}
</script>
</body>
</html>
