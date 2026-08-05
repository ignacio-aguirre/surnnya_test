<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Editar Remito";
include("encabezado.php"); 
ejecute("delete from temporal_pedidos where usuario=".$_SESSION["usuario"]);
$rto=un_registro("select * from remitos where numero=".nget("numero"));
if($rto["impreso"]=="1") die("error");
$opc_efe=str_replace("'0'","''",opciones('efectores'));
?>
<div class="container">
<script>
function traeart(){
 rubr=document.getElementById('rubro').value;
 if(rubr>0) document.getElementById('articulo').innerHTML = ejec_sq("sq_arti_selectstock?rubro="+rubr); 
}

function traedispo(){
 arti=document.getElementById('articulo').value;
 if(arti>0) {
	 tbien=ejec_sq("sq_arti_tbien?articulo="+arti);
  document.getElementById('disponible').value = ejec_sq("sq_ped_artdispo?articulo="+arti);
	   
	
 }
}
</script>

<form class="form-inline" onsubmit="return false">
 <div class="form-group has-warning">
	<label class="label-form" for="efector">Efector</label>
	<select class="form-control" id="efector" required autofocus>
        <?php echo $opc_efe;?></select>
	<script>seleccionar("efector",'<?php echo $rto["efector"]?>')</script>
 </div> 	
 <div class="form-group has-warning">
	<label class="label-form" for="fecha">Fecha</label>
	<input class="form-control" readonly id='fecha' name='fecha' size="10" value='<?php echo ffec($rto["fecha"])?>'>
 </div>
 <br><br>
 <div class="form-group has-warning">
	<label class="label-form" for="rubro">Rubro</label>
	<select class="form-control" id="rubro" name="rubro" onblur='traeart()'>
	<?php echo opciones("articulos_rubros")?></select>
 </div>
 <br><br>
 <div class="form-group has-warning">
	<label class="label-form" for="articulo">Art&iacute;culo</label>
	<select class="form-control" id="articulo" name="articulo" onblur='traedispo()'></select>
 </div>
 <div class="form-group has-warning ">
	<label class="label-form" for="cantidad">Cantidad</label>
	<input class="form-control" id='cantidad' name='cantidad' size='4' maxlength='6' onblur='valida_cantidad()'>
 </div>
 <div class="form-group has-warning ">
		<button class='btn-primary' onclick='agregar()'>Agregar</button>
 </div>
 <input type='hidden' id='disponible'>

</form>
<div class="table-responsive">
<table id="articulos" class="table table-bordered  table-condensed">
<tr class='bg-primary'><th>Id #</th><th>Art&iacuteculo</th><th>Cantidad</th><th>Acciones</th></tr>

</table>
</div>

<script>

function valida_cantidad(){
 valida_entero("cantidad");
 cant=document.getElementById('cantidad').value;
 if(parseInt(cant)<=0){alert("cantidad no puede ser menor o igual a cero");return false;};
 dispo=document.getElementById('disponible').value;
 if(parseInt(cant)>parseInt(dispo)){
  alert("no hay stock disponible");
  document.getElementById('cantidad').value="";return false;};
 return true;

}



function agregar(){
arti=document.getElementById('articulo').value;
if(arti>0){
   if(valida_cantidad()){
    cant=document.getElementById('cantidad').value;
    tabla=document.getElementById('articulos');
    filas=tabla.rows.length;
    for(i=1;i<filas;i++) {
     articulo=tabla.rows[i].cells[0].innerHTML;
     if(parseInt(articulo)==arti){alert("articulo repetido");return false;};
    };
    fila=tabla.insertRow(-1);
    celda=fila.insertCell(0);
    celda.innerHTML=arti;
    var x = document.getElementById("articulo").selectedIndex;
    var y = document.getElementById("articulo").options;
    desc=y[x].text;
    celda=fila.insertCell(1);
    celda.innerHTML=desc;
    celda=fila.insertCell(2);
    celda.innerHTML=cant;
    celda=fila.insertCell(3);
    celda.innerHTML="<img src='imagenes/eliminar.png' height='17' width='17' onclick='elimina("+arti+")'>&nbsp;";
    ejec_sq("sq_remi_agrega?articulo="+arti+"&cantidad="+cant);
    document.getElementById('cantidad').value="";			
    document.getElementById('disponible').value="";
    document.getElementById("articulo").focus();			
   };	

} else alert("debe seleccionar artículo");

}



</script>
<?php

$reg=registros("select articulo,articulos.descripcion,rubro, cantidad from remitos_articulos left join articulos on articulo=idarticulos 
where remito=".$rto["idremitos"]);

while($r=mysqli_fetch_assoc($reg)){
  echo "<script>";
  echo "seleccionar('rubro','".$r["rubro"]."');";
  echo "traeart();";
  echo "seleccionar('articulo',".$r["articulo"].");";
  echo "traedispo();";
  echo "document.getElementById('cantidad').value=".$r["cantidad"].";";	
  echo "agregar();";
  echo "</script>";
};

?>
<button class='btn-primary' onclick='aceptar()'>Guardar</button>
</div>
<script>
function aceptar(){
if(confirm("Genera Remito ?")){
 valida_fecha('fecha');
 fech=document.getElementById("fecha").value;
 efec=document.getElementById("efector").value;
 id="<?php echo $rto['idremitos']?>";
 if(efec<"1"){alert("debe seleccionar efector");return false;};
 inicia_timer();
 resp=ejec_sq("ej_remitos?tipo=EDITAR&id="+id+"&fecha="+fech+"&efector="+efec);
 if(resp!="1"){
   navega("aviso_sin_stock?lista=faltantes: "+resp);
 }else{
  navega("aviso?id="+id+"&tipo=REMITO&nro=<?php echo $rto["numero"]?>&acc=editado en estado borrador");
 };
};
return true;
}

function elimina(arti){
tabla=document.getElementById('articulos');
filas=tabla.rows.length;
for(i=1;i<filas;i++) {
  renglon=i;
  articulo=tabla.rows[i].cells[0].innerHTML;
  if(parseInt(articulo)==arti){tabla.deleteRow(i);ejec_sq("sq_remi_elimina?articulo="+articulo);return true;};
};
}


ocurre=10;
function inicia_timer(){
  var myVar=setInterval(function(){myTimer()},1000);
}

function myTimer(){
ocurre=ocurre-1;
if(ocurre<1) {navega("menu");};
};


</script>
  
</body>