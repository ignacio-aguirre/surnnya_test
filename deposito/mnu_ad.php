<?php 
include("func.php");
session_start();
$_SESSION["prestacion"]="Tablas y otras opciones Sistema";
include("encabezado.php");

?> 
<div class="container">
<br>
<div class="row">
	<div class="col-md-3"><button class="btn btn-primary" onclick="navega('usuarios')">Usuarios</button></div>
	<div class="col-md-3"><button class="btn btn-success" onclick="navega('cons_actividades')">Cons.Actividades</button></div>
</div>
<br>

<div class="row">
  <div class="col-md-3"><button class="btn btn-info" onclick="navega('mnu_dp')">Men&uacute General</button></div>
</div>
<script>
function responder(){
dis=document.getElementById("texto").value;
//$uid=un_campo("select max(id) from surnnya.fechas where fecha<curdate()");



resp=eje("//undato.com.ar/surnnya/tapis/?uid="+3505+"&cns=cant_alojados&dis="+dis,document.getElementById("respuesta"));

}
function eje(sql,obje){
 var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        resp = xhttp.responseText;
        var objeto = JSON.parse(resp);
  
        if(typeof objeto.errorMessage=="undefined"){alert(objeto.errorMessage);return false;};

        if(typeof objeto.alojados!="undefined"){
             obje.value=objeto.alojados;

        };

        };
  };
  xhttp.open("GET", sql, false);
  xhttp.send();
  return true
 }
</script>
</body>