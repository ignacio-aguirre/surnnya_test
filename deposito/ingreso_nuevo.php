<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Nuevo Ingreso de Bienes";
include("encabezado.php"); 
ejecute("delete from temporal_rprov where usuario=".$_SESSION["usuario"]);
?>
<script src='js/compras.js?v=1.4'></script>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Origen</th><th>Observaciones</th><th>Fecha</th></tr>
<tr><td><select class="form-control" id="origen" name="origen" required>
<option value=""></option>
<option value="P">Proveedor</option>
<option value="D">Otro Dep&oacute;sito</option>
<option value="E">Devoluci&oacute;n Efector</option>
</select></td>
<td><input class="form-control" id='observaciones' name='observaciones' size='30' maxlength='50' required></td>
<td><input class="form-control" id='fecha' name='fecha' size='8' maxlength='10' onblur='valida_fecha(this.id)'></td>
</tr>
</table>
</div>
</div>

<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Rubro</th><th>Art&iacuteculo</th><th>Cantidad</th><th>Acci&oacute;n</th></tr>
<tr style="font-size:.8em;"><td><select class="form-control" id='rubro' onblur='traeart()' ><?php echo opciones('articulos_rubros')?></select></td>
<td><select class="form-control" id='articulo' name='articulo'></select></td>
<td><input class="form-control" id='cantidad' name='cantidad' size='4' maxlength='6' onblur='valida_cantidad(this.id)'></td>
<td><button class='btn-primary' onclick='agregar()'>Agregar</button></td>
</tr>
</table>
</div>
</div>
<div class="container">
<div class="table-responsive pre-scrollable">
<table id='articulos' class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Id #</th><th>Art&iacute;culo</th><th>Cantidad</th><th>Acciones</th></tr>
</table>
</div>
<button class='btn-primary' onclick='aceptar()'>Finalizar</button>
</div>
<script>
function valida_cantidad(){
cant=document.getElementById("cantidad").value;
if(cant<=0){
alert("la cantidad no puede ser menor o igual a cero");
document.getElementById("cantidad").value="";
return false;
};
return true;
}

function agregar(){
arti=document.getElementById('articulo').value;
if(arti>0){
   if(valida_cantidad()){
    cant=document.getElementById('cantidad').value;
    tabla=document.getElementById('articulos');
    filas=tabla.rows.length;
    hasta=filas;
    for(i=1;i<filas;i++) {
     articulo=tabla.rows[i].cells[0].innerHTML;
     if(parseInt(articulo)==arti){alert("articulo repetido");return false;};
    };
    fila=tabla.insertRow(-1);
    fila.style.fontSize=".8em";
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
    celda.innerHTML="<img src='imagenes/eliminar.png' height='20' width='20' onclick='elimina("+arti+")'>&nbsp;<img src='imagenes/editar.png' height='20' width='20' onclick='edita("+arti+")'>";
    document.getElementById('cantidad').value="";			
    ejec_sq("sq_rprov_agrega?articulo="+arti+"&cantidad="+cant);
 };	
} else alert("debe seleccionar artículo");
}

function aceptar(){
origen=document.getElementById("origen").value;
if(origen==""){status("debe indicar el origen");return false;};
observaciones=document.getElementById("observaciones").value;
valida_fecha('fecha');
fecha=document.getElementById("fecha").value;
if(fecha==""){alert("debe indicar una fecha reciente");return false;};
id=navega("ej_ingresos?tipo=NUEVO&fecha="+fecha+"&origen="+origen+"&observaciones="+observaciones);
return true;
}


function elimina(arti){
tabla=document.getElementById('articulos');
filas=tabla.rows.length;
for(i=1;i<filas;i++) {
 renglon=i;
  articulo=tabla.rows[i].cells[0].innerHTML;
  if(parseInt(articulo)==arti){
     tabla.deleteRow(i);
     ejec_sq("sq_rprov_elimina?articulo="+arti); 
     return true;
  };
};
}



function edita(arti){
    seleccionar('rubro', ejec_sq("sq_arti_rubro&articulo="+arti));
    traeart();
    seleccionar('articulo',arti);
    tabla=document.getElementById('articulos');
    filas=tabla.rows.length;
    for(i=1;i<filas;i++) {
     renglon=i;
     articulo=tabla.rows[i].cells[0].innerHTML;
     if(parseInt(articulo)==arti){
       document.getElementById("cantidad").value=tabla.rows[i].cells[2].innerHTML;
       tabla.deleteRow(i);
       ejec_sq("sq_rprov_elimina?articulo="+arti); 
       return true;};
    };
}
function traeart(){ 
 rubr=document.getElementById('rubro').value;
 if(rubr>0) document.getElementById('articulo').innerHTML = ejec_sq("sq_arti_select?rubro="+rubr);    
}

</script>
</body>