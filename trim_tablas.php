<?php 
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Valores de Tablas";
include("encabezado.php"); 
$tipo=$_GET["tipo"];
?>
</div>
<div class="container" align="center">
Tabla <?php echo un_campo("select descripcion from diccionario_tablas where codigo=".tsql($tipo));?>
<div class="table-responsive pre-scrollable" id='tabla'>
</div> 
</div> 
<div class="container">
<form class="form-inline" onsubmit="return false">
<div class="form-group has-warning">
 <input id='xid' name='xid' type='hidden'>
 <label class='label-form' for='valor'>Valor</label>
 <input class='form-control' id='valor' size='4' maxlenght='4' onblur='verifica()' >
</div>
<div class="form-group has-warning">
 <label class='label-form' for='descripcion'>Descripci&oacute;n</label>
 <input class='form-control' id='descripcion' size='55' maxlenght='60'>
</div>
</form>
<button class="btn-primary" id="agregar" onclick='agregar()' disabled>Agregar/Modificar</button>
<button class="btn-primary" id="cancelar" onclick='cancelar()'>Cancelar</button>
<button class="btn-primary" id="nuevo" onclick='nuevo()'>Nuevo</button>

</div>
<script>
tipo="<?php echo $tipo?>";
muestra_tablas();
function muestra_tablas(){
document.getElementById("tabla").innerHTML=ejec("browser_tablas","TABLAS","&tipot="+tipo);
}
function verifica(){
valida_entero("valor");
if(valor.value==""){status("valor obligatorio");return false;};
id=xid.value;
valo=valor.value;
if(ejec("ej_trim_sistema","TABLA_VALOR","&id="+id+"&tipot="+tipo+"&valor="+valo)=="1"){
status("existe ese valor en la tabla"); 
valor.value="";
return false;
};
return true;
}	
function editar(sid){
 document.getElementById('nuevo').disabled=true;
 document.getElementById('agregar').disabled=false;
    var resp = JSON.parse(ejec("ej_trim_sistema","TABLAS_UNA","&id="+sid));
    document.getElementById('xid').value=resp.idtablas_semestrales;
    document.getElementById('valor').value=resp.valor;
    document.getElementById('descripcion').value=resp.descripcion;
    document.getElementById('valor').focus();
 return true;	
}
function blanquea(){
    xid.value="";
    valor.value="";
    descripcion.value="";
return true;
}
function nuevo(){
document.getElementById('agregar').disabled=false;
document.getElementById('nuevo').disabled=true;
blanquea();
xid.value="0";
valor.focus()
return true;
}

function cancelar(){
blanquea();
 document.getElementById('nuevo').disabled=false;
 document.getElementById('agregar').disabled=true;

};


function eliminar(id){
if(id>0) {
    var resp = JSON.parse(ejec("ej_trim_sistema","TABLAS_UNA","&id="+id));
    xid.value=resp.idtablas_semestrales;
    valo=resp.valor;
    desc=resp.descripcion;
    if(confirm("Estas seguro/a de Dar de Baja este registro?"+valo+", "+desc)){
	ejec("ej_trim_sistema","TABLAS_BAJA","&id="+xid.value);
        xid.value="";
        muestra_tablas();
    };
 };
}
function agregar(){

 valida_entero("valor");
 if(!verifica()) return false;
  if(descripcion.value=="") {status("descripcion es obligatorio");return false;};
 cosa=ejec("ej_trim_sistema","TABLAS_AGREGAR","&id="+xid.value+"&tipot="+tipo+"&valor="+valor.value+"&descripcion="+descripcion.value);
 muestra_tablas();
 document.getElementById('nuevo').disabled=false;
 document.getElementById('agregar').disabled=true;
 blanquea() 
 return true;
}
 
function tablas(cdgo){
navega("tablas?codigo="+cdgo);
}

</script>
</body>
</html>



