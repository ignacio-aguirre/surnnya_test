<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Ajustes Stock";
include("encabezado.php"); 
$status="";
if(isset($_GET['status'])) $status=$_GET['status'];
echo $status;?>
</div>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered table-condensed">
<tr class="bg-primary"><th>Desde</th><th>Hasta</th><th>Acciones</th></tr>
<tr><td><input class="form-control" id='desde' size='8' maxlength='10' onblur='valida_fecha(this.id)'></td><td><input class="form-control" id='hasta' size='8' maxlength='10' onblur='valida_fecha(this.id)'></td><td><button class='btn-primary' onclick='despliega_ajustes()'>Consultar</button></td></tr>
</table>
</div>
<div class="table-responsive" id="tabla">
</div> 
</div> 
</div>
</div>
<script src='js/particulares.js'></script>
<script>
function despliega_ajustes(){
    valida_fecha("desde");
    valida_fecha("hasta");
    dde=document.getElementById("desde").value;
    hta=document.getElementById("hasta").value;
    if(fsql(dde)>fsql(hta)) {alert("Fecha desde debe ser menor o igual que fecha hasta"); return false;}
    document.getElementById("tabla").innerHTML=ejec("browser_stock","AJUSTES","&desde="+dde+"&hasta="+hta);	
    return true;
}



function ver(id){
 navega("ajuste_ver?id="+id);
};

function eliminar(id){
if(confirm("Está seguro de eliminar este ajuste?"))
 if(confirm("Seguro ?")) {
  ejec("ej_stock","AJUSTES_ELIMINAR","&comprobante="+id);
  despliega_ajustes();
 };

};

</script>

</body>