<?php 
include("funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Remitos de Entrega";
include("encabezado.php"); 
?>

<div class="container">
<form class="form-inline" onsubmit='return false'>
 <div class="form-group has-warning">
  <label class="label-form" for="desde">Desde</label>
  <input class="form-control" size='8' maxlength='10' id='desde'  value='<?php echo "01".substr($_SESSION["hoy"],2)?>' onblur='valida_fecha(this.id)'>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="hasta">Hasta</label>
  <input class="form-control" size='8' maxlength='10' id='hasta' value='<?php echo $_SESSION["hoy"]?>' onblur='valida_fecha(this.id)'>
 </div>
 <button class='btn-primary' onclick='despliega_remitos()'>Consultar</button>
</form>

<div class="table-responsive pre-scrollable" id="tabla">

</div> 

</div> 

<script>

function despliega_remitos(){
    valida_fecha("desde");
    valida_fecha("hasta");
    dde=document.getElementById("desde").value;
    hta=document.getElementById("hasta").value;
    if(fsql(dde)>fsql(hta)) {alert("Fecha Hasta debe ser mayor o igual que Desde"); return false;};
    document.getElementById("tabla").innerHTML=ejec("browser_remitos","REMITOS","&dde="+dde+"&hta="+hta);	
    return true;
}

document.getElementById("desde").focus();

function imprime(numero){

navega("remito_imprimir?numero="+numero);

}
function cierra(id){
 resp=ejec_sq("ej_remitos?tipo=CERRAR&id="+id);
 if(resp!="1"){navega("aviso_sin_stock?lista=faltantes: "+resp);};
 despliega_remitos();
}
function edita(numero){
  navega("remitos_editar?numero="+numero);
}

function anula(numero){
  if(confirm("Confirmas la Anulación?")){
  navega("remitos_anular?numero="+numero);}
}
function replica(numero){
  if(confirm("Confirmas la Replicación?")){
  navega("remitos_replicar?numero="+numero);}
}

function ver(id){

navega("remito_ver?id="+id);

}

function recibe(id){

navega("remito_ver?id="+id+"&recibir=1");

};

</script>

</div>

</div>

<script src="bootstrap-3.3.6-dist/js/jquery.js"></script>

<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

</body>