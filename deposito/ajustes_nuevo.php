<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Ajuste de Stock BIENES DE CONSUMO";
include("encabezado.php");
if(isset($_SESSION["arch_temp"])){Redirect("ajuste_acciones");};
?>
<div class="container">
<input id='fecha' name='fecha' size='8' maxlength='10' hidden value='<?php echo $_SESSION["hoy"];?>'>
<h4>Nuevo Ajuste</h4>
<h4>Opci&oacute;n A. Subir documento excel con el contendido del ajuste o con un inventario</h4>
<form class="form-inline"  method="post" enctype="multipart/form-data" onsubmit="return valida_arch()" action="ajustes_subir">
<div class="form-group has-warning">
<label class="control-label" for="archivo">Seleccionar archivo</label>   
<input type="file" class="form-control" name="archivo" id="archivo">
<button class='btn btn-success'>Subir Excel</button>
</div>
</form>
<h4>Opci&oacute;n B. Carga Manual</h4>
<p class="text-warning">Recuerda que si la cantidad es positiva, suma al stock, y si es negativa resta al stock</p>
<hr>
<form class="form-inline" onsubmit='return false'  action="">
<div class="form-group has-warning">
<label class="control-label" for="motivo">Motivo del Ajuste</label>
<input class="form-control" id='motivo' size='40' maxlength='45' onblur='valida_0(this.id)'>
</div>
<div class="form-group has-warning">
<label class="control-label" for="rubro">Rubro</label>   
<select class='form-control' id='rubro' onchange='traeart()' >
<?php echo opciones("articulos_rubros");?></select>
</div>
</form>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Id #</th><th>Art&iacute;culo</th><th>Stock</th><th>Ajustar</th></tr>
<tbody id="articulos">
</tbody>
</table>
</div>
<button class='btn-primary' onclick='aceptar()'>Finalizar</button><br><br>
</div>
<script>
document.getElementById('motivo').focus();
function traeart(){ 
 rubr=document.getElementById('rubro').value;
 if(rubr>0) document.getElementById('articulos').innerHTML = ejec_sq("sq_arti_traetodos?rubro="+rubr);    
}

function valida_cantidad(id){
 valida_entero(id);
 cant=document.getElementById(id).value;
 arti=id.substr(1,10);
 stoc=ejec_sq("sq_arti_stock?articulo="+arti);
 if(parseInt(stoc)+parseInt(cant)<0){status("ajuste no puede ser mayor a cantidad");document.getElementById(id).value="";return false;};
 status("");
 document.getElementById(id).value=ejec_sq("sq_ajuste_cantidad?articulo="+arti+"&cantidad="+cant);
 return true;
}

function aceptar(){
valida_0("motivo");
fecha=document.getElementById("fecha").value;
moti=document.getElementById("motivo").value;
if(moti.length<4) {alert("debe indicar motivo");return false;};
navega("ej_stock?tipo=AJUSTES_NUEVO&motivo="+moti+"&fecha="+fecha);
return true;
}



function elimina(arti){

tabla=document.getElementById('articulos');

filas=tabla.rows.length;

for(i=1;i<filas;i++) {

  renglon=i;

  articulo=tabla.rows[i].cells[0].innerHTML;

  if(parseInt(articulo)==arti){tabla.deleteRow(i);return true;};

};

}



function edita(arti){    

    resp = ejec("ej","ARTICULO_RUBRO","&articulo="+arti);

    seleccionar('rubro', resp);

    traeart();

    seleccionar('articulo',arti);

    tabla=document.getElementById('articulos');

    filas=tabla.rows.length;

    for(i=1;i<filas;i++) {

    renglon=i;

    articulo=tabla.rows[i].cells[0].innerHTML;

    if(parseInt(articulo)==arti){

      document.getElementById('stock').value=tabla.rows[i].cells[2].innerHTML;

      document.getElementById("cantidad").value=tabla.rows[i].cells[3].innerHTML;

      document.getElementById("vencimiento").value=tabla.rows[i].cells[4].innerHTML;

      tabla.deleteRow(i);return true;};

  };

}	
function valida_arch(){
  if(document.getElementById("archivo").value==""){
    status("no se indico archivo");
    return false;
  };
  inicia_timer();
  return true;
}
ocurre=10;
function inicia_timer(){
  var myVar=setInterval(function(){myTimer()},1000);
}

function myTimer(){
ocurre=ocurre-1;
if(ocurre<1) {navega("ajustes_nuevo");};
};
</script>

</body>