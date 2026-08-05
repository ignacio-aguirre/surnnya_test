<?php
session_start();
session_destroy();
session_start();
session_destroy();
session_start();
include("funciones.php");
$_SESSION['prestacion']="Ingreso a Móviles AGENTES GCABA";
$_SESSION["ul"]="1";
include("encabezado.php");
?>
<div class="container">
<form class="form" action="validaingreso" onsubmit="valida_formulario()" method="post">
<div class="row">
	<div class="form-group has-primary col-md-8" >
	 <label form='label-form'>Email</label>
     <input class="form-control"  id="email"  name="email" size="30" maxlength="50"  value="" autocomplete="off" autofocus onblur="salemail(this.id)" placeholder="Email Surnnya">  
   </div>
</div>
 <div class="row">  
  <div class="form-group has-primary col-md-8" >
	<label class="label-form">Contrase&ntilde;a</label>
	<input class="form-control" id="pass" name="pass" type ="password" size="30" maxlength="50" required value="" autocomplete="off"> 
</div>
</div>
<br><br>
 <div class="row">  
<div class="form-group has-success col-md-8"  align="center">
			<button class="btn-sm btn-success">Ingresar</button>
</div>
</div>
<script>
	function valida_formulario(){
		valida_mail("email");
		if(document.getElementById("pass").value==""){
			status("contraseña");
			return false;
		};
		if(document.getElementById("email").value==""  ){status("mail");return false;};
		status("");
		return true;
	}
	
	</script>
</form>
<?php include("footer.php");?>
</div>
