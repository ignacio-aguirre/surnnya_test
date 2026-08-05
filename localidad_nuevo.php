<?php 
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Registrar nueva localidad";
include("encabezado.php");
?>
</div>
<div class="container">

<form class="form-inline" action="localidad_nuevo_do" method="post" >
        <div class="row">
	<div class="form-group has-warning col-md-4">
	  <label class="label-form">Pa&iacute;s</label>
	   <select class="form-control" id="pais" name="pais"  onblur="sale_pais()" tabindex="1">
	<?php 
        $pai=registros("select idpaises,descripcion from paises order by descripcion");
        $opc="";
	while($p=mysqli_fetch_assoc($pai)){
         $opc=$opc."<option value='".$p["idpaises"]."'>".$p["descripcion"]."</option>";
	};
	echo $opc;
        ?></select>
	</div>
	<div class="form-group has-warning col-md-3">
	  <label class="label-form">Provincia</label>
	   <select class="form-control" id="provincia" name="provincia"  tabindex="2" onblur="sale_prov()" disabled autofocus>
	<?php 
        $pro=registros("select id,descripcion from provincias order by id");
        $opc="<option></option>";
	while($p=mysqli_fetch_assoc($pro)){
         $opc=$opc."<option value='".$p["id"]."'>".$p["descripcion"]."</option>";
	};
	echo $opc;
        ?></select>
	</div>
	</div>
        <div class="row">
	<br>
	</div>
        <div class="row">
	  <div class="form-group has-warning col-md-3">
	    <label class="label-form">Nombre de la localidad</label>
	       <input class="form-control" name="nombre" id="nombre" maxlength="70" tabindex="3" onblur="valida_0(this.id)" required>
	</div>	
	<div class="form-group has-warning col-md-3">
	  <label class="label-form">Partido</label>
	   <select class="form-control" id="partido" name="partido" tabindex="4" >
	<?php 
        $par=registros("select id,nombre from partidos order by nombre");
        $opc="<option></option>";
	while($p=mysqli_fetch_assoc($par)){
         $opc=$opc."<option value='".$p["id"]."'>".$p["nombre"]."</option>";
	};
	echo $opc;

         ?></select>
	</div>
	
      </div>
      <div class="row">	
	<hr class="md-col-12">	
       </div>		
      <div class="row">	
	<div class="form-group has-warning col-md-6">
      		<button class="btn btn-primary">Crear</button>
        </div>
      </div> 		
</form>
</div>
<script>
  seleccionar("pais","9");

  sale_pais();
  function sale_pais(){
    pais=document.getElementById("pais").value;
    document.getElementById("nombre").disabled=false;
    if(pais=="9"){
      document.getElementById("provincia").disabled=false;
      seleccionar("provincia","2");
      sale_prov();
	}	
    else{
      document.getElementById("provincia").disabled=false;
      seleccionar("provincia","");				
      document.getElementById("provincia").disabled=true;
      document.getElementById("partido").disabled=false;
      seleccionar("partido","");		
      document.getElementById("partido").disabled=true;
      if(document.getElementById("nombre").value=="CABA") document.getElementById("nombre").value="";
   };
		
  }
  function sale_prov(){
    prov=document.getElementById("provincia").value;
    if(prov==1){
      document.getElementById("nombre").disabled=false;
      document.getElementById("nombre").value="CABA";
      document.getElementById("partido").disabled=false;		
      seleccionar("partido","");		
      document.getElementById("partido").disabled=true;		
     }
    else{
     document.getElementById("nombre").disabled=false;
     document.getElementById("partido").disabled=false;		
     if(document.getElementById("nombre").value=="CABA") {document.getElementById("nombre").value="";};
     if(prov!=2)  {seleccionar("partido","");  document.getElementById("partido").disabled=true;};
    };
   return true;
} 
		
</script>
</div>