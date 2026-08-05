<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Grupos de Hermanos / Grupos Maternos";
include("encabezado.php");
noconsulta();
if($_SESSION['gl_editar_sujeto']==0) Redirect($_SESSION["menu"]);
?>
<form class="form" action="" onsubmit="return false">
<div class="form-group has-warning">
<label class="control-label" for="frase">Frase a Buscar</label>
<input class="form-control" size='35' maxlength='45' id="frase" onblur='valida_0(this.id)'>
</div>
<button class="btn-primary" onclick="consultar()">Consultar</button>&nbsp;<button class="btn-warning" onclick="nuevo()">Nuevo</button>
</form>
<script type="text/javascript">
function consultar(){
 frase=document.getElementById("frase").value;
 if(frase=="") return false;
 document.getElementById("tabla").innerHTML=ejec("grupos_go","","&frase="+frase);
 return true;
}
</script>
<div class="table-responsive pre-scrollable">
<table class="table">
<thead><tr><th>Id</th><th>Apellidos del grupo</th><th>Categor&iacute;a</th><th>Acciones</th></tr></thead>
<tbody id="tabla">
</tbody>
</table>

</div>



<script type="text/javascript">

function elimina(id){

if(confirm("Confirmas?")) navega("grupo_elimina?id="+id);

}

function edita(id){

navega("grupo_editar?id="+id);

}

function nuevo(){

navega("grupo_nuevo");

}

</script>



</body>

</html>