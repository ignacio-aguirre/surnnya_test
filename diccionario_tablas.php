<?php 
include("Funciones.php");
session_start();
include("encabezado.php"); 
?>
</div>
<div class="container" align="center">
<div class="table-responsive pre-scrollable" id='tabla'>
</div> 
</div> 
<div class="container">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
 <input id='xid' name='xid' type='hidden'>
 <label class='label-form' for='codigo'>C&oacute;digo</label>
 <input class='form-control' id='codigo' size='10' maxlenght='10' onblur='verifica()' >
</div>
<div class="form-group has-warning">
 <label class='label-form' for='descripcion'>Descripci&oacute;n</label>
 <input class='form-control' id='descripcion' size='45' maxlenght='50' onblur='valida_0(this.id)' >
</div>
</form>
<button class="btn-primary" id="agregar" onclick='agregar()' disabled>Agregar/Modificar</button>
<button class="btn-primary" id="cancelar" onclick='cancelar()'>Cancelar</button>
<button class="btn-primary" id="nuevo" onclick='nuevo()'>Nuevo</button>
<hr>
<button class="btn-success" onclick='navega("diccionario_tablas_excel")'>Excel</button>

</div>
<script>
muestra_diccionario();
function muestra_diccionario(){
document.getElementById("tabla").innerHTML=ejec("browser_tablas","DICCIONARIO","");
}
function verifica(){
if(codigo.value==""){status("codigo obligatorio");return false;};
id=xid.value;
cdgo=codigo.value;
if(ejec("ej_trim_sistema","DICCIONARIO_CODIGO","&id="+id+"&codigo="+cdgo)=="1"){
status("existe ese código para otra tabla"); 
codigo.value="";
return false;
};
return true;
}	
function editar(sid){
 document.getElementById('nuevo').disabled=true;
 document.getElementById('agregar').disabled=false;
    var resp = JSON.parse(ejec("ej_trim_sistema","DICCIONARIO_UNO","&id="+sid));
    document.getElementById('xid').value=resp.iddiccionario_tablas;
    document.getElementById('codigo').value=resp.codigo;
    document.getElementById('descripcion').value=resp.descripcion;
    document.getElementById('codigo').focus();
 return true;	
}
function blanquea(){
    xid.value="";
    codigo.value="";
    descripcion.value="";
return true;
}
function nuevo(){
document.getElementById('agregar').disabled=false;
document.getElementById('nuevo').disabled=true;
blanquea();
xid.value="0";
codigo.focus()
return true;
}

function cancelar(){
blanquea();
 document.getElementById('nuevo').disabled=false;
 document.getElementById('agregar').disabled=true;

};


function eliminar(id){
if(id>0) {
    var resp = JSON.parse(ejec("ej_trim_sistema","DICCIONARIO_UNO","&id="+id));
    xid.value=resp.iddiccionario_tablas;
    cdgo=resp.codigo;
    desc=resp.descripcion;
    if(confirm("Estás seguro/a de Dar de Baja este registro?"+cdgo+", "+desc)){
	ejec("ej_trim_sistema","DICCIONARIO_BAJA","&id="+xid.value);
        xid.value="";
        muestra_diccionario();
    };
 };
}
function agregar(){
 valida_0("codigo");
 if(!verifica()) return false;
 valida_0("descripcion");
 if(descripcion.value=="") {status("descripcion es obligatorio");return false;};
 ejec("ej_trim_sistema","DICCIONARIO_AGREGAR","&id="+xid.value+"&codigo="+codigo.value+"&descripcion="+descripcion.value);
 muestra_diccionario();
 document.getElementById('nuevo').disabled=false;
 document.getElementById('agregar').disabled=true;
 blanquea() 
 return true;
}
 
function tablas(cdgo){
navega("trim_tablas?tipo="+cdgo);
}

</script>
</body>
</html>



