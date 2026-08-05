
<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Consulta Datos Adicionales PAE del Sujeto";
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])|!isset($_GET['legajo'])) header ("Location: salir");
registre();
$lega= $_GET["legajo"];
if ($lega=="" ) ("Location: consultasujetos");
if(un_campo("select id from sujetos_pae where legajo=".$lega)=="") {inserte("insert into sujetos_pae(legajo) values(".$lega.")");};
$r=un_registro("select sujetos.apellidos, sujetos.nombres,sujetos_pae.* from sujetos_pae left join sujetos on sujetos_pae.legajo=sujetos.legajo where sujetos.legajo=".$lega);
$_SESSION["posicion"]="11";
$usuarios="<option></option>";
$usu=registros("select id, concat(apellido,', ',nombre) as nya from usuarios where perfil=47 and baja is null order by nombre");
while($u=mysqli_fetch_assoc($usu)){
  $usuarios=$usuarios."<option value='".$u["id"]."'>".$u["nya"]."</option>";
};
$usuarios=$usuarios."<option value='-1'>Grupal</option>";
$tmot="<option></option>";
$mot=registros("select deno from tablas where tipo='MMEX' order by deno");
while($m=mysqli_fetch_assoc($mot)){
 $tmot=$tmot."<option value='".$m["deno"]."'>".$m["deno"]."</option>";
};
$proy="<option value='0'>Completar</option>";
$pro=registros("select valo,deno from tablas where baja is null and tipo='PAEP' order by valo");
while($p=mysqli_fetch_assoc($pro)){
 $proy=$proy."<option value='".$p["valo"]."'>".$p["deno"]."</option>";
};
$phij="<option value='0'>No</option>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>+ de 3</option>";

include("mnu_superior.php");
?>
</div>
<div class="container">
<script>
function valida(){
  if(document.getElementById("cobro_otras").checked==false && document.getElementById("cobro_especificar").value!=""){
    status("no puede completar especificar cobro otras si no est&aacute; chequeado el campo anterior");
    return false;
  };
  if(document.getElementById("cobro_otras").checked==true &&  document.getElementById("cobro_especificar").value==""){
    status("debe especificar si selecciona otros cobros");
    return false;
  };
  if(document.getElementById("referente_1").value!="" && document.getElementById("referente_2").value!="" && document.getElementById("referente_1").value==document.getElementById("referente_2").value){	
    status("los referentes deben ser diferentes si son dos");
    return false;
  };

  status("");
  return true;
}  
</script>
<form class="form-inline" method="post" action="actualizapae" onsubmit="return valida()">
   <div class="form-group has-warning">
	<label class="label-form">Documentaci&oacute;n</label>
        <select class="form-control" id="documentacion" name="documentacion" required>
	<option></option>
 	<?php 
          echo "<option value='DNI'>DNI</option><option value='LC'>LC</option><option value='LE'>LE</option>
          <option value='PAS'>PAS</option><option value='C.BOL'>C.BOL</option><option value='C.BRA'>C.BRA</option>
	  <option value='C.CHI'>C.CHI</option><option value='C.PAR'>C.PAR</option><option value='C.URU'>C.URU</option>";
        ?>        
        </select>
	<script>seleccionar("documentacion","<?php echo $r['documentacion']?>")</script>

   </div>	
   <div class="form-group has-warning">
	<label class="label-form">Provincia Nacimiento</label>
	 <select class="form-control" name="provincia_nacimiento" id="provincia_nacimiento">
	 </select>
  </div>
 
  <div class="form-group has-warning">
	<label class="label-form" for="nivel_educativo">Nivel Educativo</label>
	<select class="form-control" name="nivel_educativo" id="nivel_educativo" autofocus>
	<option></option><?php echo opc_tabla("NIVES");?></select>
	<script>seleccionar("nivel_educativo","<?php echo $r['nivel_educativo']?>")</script>
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="discapacidad">Discapacidad</label>
	<input type="checkbox" class="form-control" id="discapacidad" name="discapacidad" <?php if($r["discapacidad"]=="1") {echo "checked";}?>>
  </div>
  &nbsp;&nbsp;
  <div class="form-group has-warning">
	<label class="label-form" for="cobro_pension">Cobra Pensi&oacute;n por Discapacidad</label>
	<input type="checkbox" class="form-control" id="cobro_pension" name="cobro_pension" <?php if($r["cobro_pension"]=="1") {echo "checked";}?>>
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="cobro_auh">Cobra AUH</label>
	<input type="checkbox" class="form-control" id="cobro_auh" name="cobro_auh" <?php if($r["cobro_auh"]=="1") {echo "checked";}?>>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="cobro_otras">Cobra Otras Asignaciones</label>
	<input type="checkbox" class="form-control" id="cobro_otras" name="cobro_otras" <?php if($r["cobro_otras"]=="1") {echo "checked";}?>>
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="cobro_especificar">Otras As.Especificar</label>
	<input class="form-control" size="50" maxlength="60" id="cobro_especificar" name="cobro_especificar" value="<?php echo $r["cobro_especificar"];?>" onblur="valida_0(this.id)">
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form">Proyecto</label>
	<select  class="form-control" id="proyecto" name="proyecto">
		<?php echo $proy?>
        </select>
	<script>seleccionar("proyecto","<?php echo $r["proyecto"]?>")</script>
  </div>
  <div class="form-group has-warning">
	<label class="label-form">Autovalimiento</label>
	<select  class="form-control" id="autovalimiento" name="autovalimiento">
		<?php echo opc_tabla("AUVA");?>
        </select>
	<script>seleccionar("autovalimiento","<?php echo $r["autovalimiento"]?>")</script>
  </div>

  <br><br>

  <div class="form-group has-warning">
	<label class="label-form">Fecha aplicaci&oacute;n &uacute;ltima MEX</label>
	<input  class="form-control" id="ultmex_fecha" name="ultmex_fecha" size="10" maxlength="10" value="<?php echo ffec($r["ultmex_fecha"])?>" onblur="valida_fecha(this.id,1)">
  </div>	
  <div class="form-group has-warning">
	<label class="label-form">Nro.Acto administrativo &uacute;ltima MEX</label>
	<input  class="form-control" id="ultmex_nro" name="ultmex_nro" size="10" maxlength="10" value="<?php echo $r["ultmex_nro"]?>" onblur="valida_0(this.id)">
  </div>	
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form">Motivo &uacute;ltima MEX</label>
	<select  class="form-control" id="ultmex_motivo" name="ultmex_motivo">
		<?php echo $tmot?>
        </select>
	<script>seleccionar("ultmex_motivo","<?php echo $r["ultmex_motivo"]?>")</script>
  </div>	

   <br><br>	
  <div class="form-group has-warning">
	<label class="label-form" for="trabaja">Trabaja</label>
	<input type="checkbox" class="form-control" id="trabaja" name="trabaja" <?php if($r["trabaja"]=="1") {echo "checked";}?>>
  </div>	
  <div class="form-group has-warning">
	<label class="label-form" for="laboral_condiciones">Condici&oacute;n Laboral</label>
	<select class="form-control" name="laboral_condiciones" id="laboral_condiciones">
	<option>Completar</option><?php 

	  $lc=registros("select deno from tablas where baja is null and tipo='LABO' order by deno");
	  while($l=mysqli_fetch_assoc($lc)){
	     echo "<option value='".$l["deno"]."'>".$l["deno"]."</option>";
          };
?>
        </select>
	<script>seleccionar("laboral_condiciones","<?php echo $r['laboral_condiciones']?>")</script>
  </div>
  &nbsp;
  <div class="form-group has-warning">
	<label class="label-form" for="laboral_especificar">Laboral Especificar</label>
	<input class="form-control" size="50" maxlength="50" id="laboral_especificar" name="laboral_especificar" value="<?php echo $r["laboral_especificar"];?>" onblur="valida_0(this.id)">
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="laboral_dinero">Ingreso por Trabajo</label>
	<input class="form-control" size="8" maxlength="8" id="laboral_dinero" name="laboral_dinero" value="<?php echo $r["laboral_dinero"];?>" onblur="valida_entero(this.id)">
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="laboral_dinero_obs">Observaciones I x T</label>
	<input class="form-control" size="50" maxlength="50" id="laboral_dinero_obs" name="laboral_dinero_obs" value="<?php echo $r["laboral_dinero_obs"];?>" onblur="valida_0(this.id)">
  </div>
  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="dinero_vivienda">Dinero destinado a Vivienda</label>
	<input class="form-control" size="8" maxlength="8" id="dinero_vivienda" name="dinero_vivienda" value="<?php echo $r["dinero_vivienda"];?>" onblur="valida_entero(this.id)">
  </div>
  <div class="form-group has-warning">
	<label class="label-form" for="hijos">Hijos/as</label>
	<select class="form-control" id="hijos" name="hijos">
	<?php echo $phij;?>
	</select>
	<script>seleccionar("hijos","<?php echo $r['hijos']?>")</script>

  </div>

  <br><br>
  <div class="form-group has-warning">
	<label class="label-form" for="referente_1">Referente</label>
	<select class="form-control" name="referente_1" id="referente_1">
	<option></option><?php echo $usuarios;?></select>
	<script>seleccionar("referente_1","<?php echo $r['referente_1']?>")</script>
  </div>
  &nbsp;&nbsp;&nbsp;
  <!--div class="form-group has-warning">
	<label class="label-form" for="referente_2">Dupla 2</label>
	<select class="form-control" name="referente_2" id="referente_2">
	<option></option><?php echo $usuarios;?></select>
	<script>seleccionar("referente_2","<?php echo $r['referente_2']?>")</script>
  </div-->
  <br><br>
  <h5>Datos RUA</h5>
   <div class="form-group has-warning" >
    <label class="label-form" for="intereses">Intereses</label>
    <input class="form-control" name="intereses" id="intereses" value="<?php echo $r['intereses']?>" maxlength="100">
  </div> 
   <div class="form-group has-warning" >
    <label class="label-form" for="competencias">Competencias</label>
    <input class="form-control" name="competencias" id="competencias"  value="<?php echo $r['competencias']?>" maxlength="100">
  </div> 
  
  <input hidden name="legajo" value="<?php echo $lega?>">
  <button class="btn btn-success">Actualizar</button>
</form>
<script>
contprov=ejec_sq("sq_loc?tipo=Provincias");
document.getElementById("provincia_nacimiento").innerHTML=contprov;
seleccionar("provincia_nacimiento","<?php echo $r["provincia_nacimiento"]?>");




function selenuevo(id,valor){
valor=trim(valor.toUpperCase());
seleccionar(id,valor);
if (document.getElementById(id).value!=valor){
  var c = document.createElement("option");
  c.text=valor;
  c.value=valor;
  document.getElementById(id).options.add(c);
  seleccionar(id,valor);
}
}
</script>
</div>
</body>
</html>