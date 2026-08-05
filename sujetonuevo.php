<?php 
include("Funciones.php");
session_start();  
if($_SESSION["gl_nuevo_sujeto"]==0) Redirect("error_noautorizado");
$_SESSION["prestacion"]="Ingresar Nuevo Sujeto";
include("encabezado-test.php");
$ap="";
$no="";
$ed="";
$se="";
if(isset($_GET["apellidos"])){
 $ap=$_GET["apellidos"];
 $no=$_GET["nombres"];
 
 $se=$_GET["sexo"];
};
if(isset($_GET["edad"])){$ed=$_GET["edad"];};
$td="";
$nd="";
$documento="";
$rib="";
$nacimiento="";
if(isset($_GET["documento"])){$documento=$_GET["documento"];};
if(isset($_GET["rib"])){$rib=$_GET["rib"];};
if(isset($_GET["nacimiento"])){$nacimiento=$_GET["nacimiento"];};
if(isset($_GET["td"])){
  $td=$_GET["td"];
  $nd=$_GET["nd"];
};
$fn="";
if(isset($_GET["f_nacimiento"])){
  $fn=$_GET["f_nacimiento"];
};
$ra="";
$rn="";
$rr="";
if(isset($_GET["rib_anio"])){
 $ra=$_GET["rib_anio"];
 $rn=$_GET["rib_numero"];
 $rr=$_GET["rib_reparticion"];
};

?>
</div>
<div class="container">
<form class="form-inline" enctype='multipart/form-data'>
 <div class="form-group has-warning">
  <label class="label-form" for="documento">Se conoce tipo y n&uacute;mero de documento?</label>
  <select class="form-control" name="documento" id="documento" onblur="habilita_documento()" required autofocus>
  <option value=""></option>
  <option value="1">SI</option>
  <option value="0">NO</option>
  </select>
  <script>seleccionar("documento","<?php echo $documento?>");</script>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="td">Tipo de documento</label>
  <select class="form-control" id="td" name="td" disabled required autofocus>
  <option value=""></option>
  <?php echo opc_tabla('TD');?></select>
  <script>seleccionar("td","<?php echo $td?>");</script>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="nd">N&uacute;mero de documento</label>
  <input class="form-control" size="10" maxlength="8" onblur='bl_nd()' id="nd" name="nd" value="<?php echo $nd?>" disabled required>
 </div>
 <br><br><div class="form-group has-warning">
  <label class="label-form" for="apellidos">Apellidos</label>
  <input class="form-control" id="apellidos" name="apellidos" size="30" maxlength="30" onblur="valida_0(this.id)" value="<?php echo $ap?>" required>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="nombres">Nombres</label>
  <input class="form-control" id="nombres" name="nombres" size="30" maxlength="30" onblur="valida_0(this.id)" value="<?php echo $no?>" required>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="sexo">Sexo (DNI)</label>
  <select class="form-control" id="sexo" name="sexo" required>
  <option value="">S/D</option><option value="M">Masculino</option><option value="F">Femenino</option><option value="X">X Otros</option>
  </select>
  <script>seleccionar("sexo","<?php echo $se?>");</script>
 </div> <br><br>
 
 
 <div class="form-group has-warning">
  <label class="label-form" for="td">Se conoce su RIB?</label>
  <select class="form-control" name="rib" id="rib" required onblur="habilita_rib()">
  <option value=""></option>
  <option value="1">SI</option>
  <option value="0">NO</option>
  </select>
  <script>seleccionar("rib","<?php echo $rib?>");</script>
 </div>

 <div class="form-group has-warning">
  <label class="label-form" for="rib_anio">RIB A&ntilde;o</label>
  <input class="form-control" id="rib_anio" name="rib_anio" size="4" maxlength="4" onblur="valida_entero(this.id)" value="<?php echo $ra?>" required disabled>
 </div> 
 <div class="form-group has-warning">
  <label class="label-form" for="rib_numero">N&uacute;mero de RIB</label>
  <input class="form-control" size="10" maxlength="10" onblur='valida_entero(this.id)' id="rib_numero" name="rib_numero"  value="<?php echo $rn?>" required disabled>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="rib_reparticion">RIB Repartici&oacute;n</label>
  <input class="form-control" size="15" maxlength="15" onblur='valida_0(this.id)' id="rib_reparticion" name="rib_reparticion"  value="<?php echo $rr?>" required disabled>
 </div><br><br>
 
 <div class="form-group has-warning">
  <label class="label-form" for="td">Se conoce Fecha de Nacimiento?</label>
  <select class="form-control" name="nacimiento" id="nacimiento" onblur="habilita_nacimiento()" required>
  <option value=""></option>
  <option value="1">SI</option>
  <option value="0">NO</option>
  </select>
  <script>seleccionar("nacimiento","<?php echo $nacimiento?>");</script>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="f_nacimiento">Fecha nacimiento</label>
  <input class="form-control" size="10" maxlength="10" onblur='valida_fecha(this.id,1)' id="f_nacimiento" name="f_nacimiento" value="<?php echo $fn?>" required disabled>
 </div>
 <div class="form-group has-warning">
  <label class="label-form" for="edad">Edad Aproximada hoy</label>
  <input class="form-control" size="2" maxlength="2" onblur='valida_entero(this.id)' id="edad" name="edad" value="<?php echo $ed?>" required>
 </div><br><br>
 
 <button class="btn-success">Validar</button>
</form>

<div class="table_responsive" id="resultado">
<table class="table">
<tr><th>Tipo de B&uacute;squeda</th><th>Apellidos y Nombres</th><th>Tipo y Nro Doc</th><th>RIB</th><th>Edad</th></tr>
  <?php
    $haydni=false;
    $hayrib=false;
    if(isset($_GET["apellidos"])){
      $sql1=buscador_pibes($_GET["apellidos"]." ".$_GET["nombres"],false,false); 
      $sql2="";
      $sql3="";
      if(isset($_GET["nd"])){
       $sql2=buscador_pibes(nget("nd"),false,false);
      };
      if(isset($_GET["rib_numero"])){
        $sql3=buscador_pibes($_GET["rib_numero"],false,false);
      };
      $tipo="APYNOMB";
      $reg=registros($sql1);
      while($r=mysqli_fetch_assoc($reg)){
        echo "<tr><td>".$tipo."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["TDNI"]." ".$r["SujetosDni"]."</td><td>".rib2($r)."</td><td>".$r["edad_c"]."</td></tr>";
      };
      if($sql2!=""){
         $tipo="NDOC";
         $reg=registros($sql2);
         while($r=mysqli_fetch_assoc($reg)){
          if($r["SujetosDni"]==$nd){$haydni=true;};
          echo "<tr><td>".$tipo."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["TDNI"]." ".$r["SujetosDni"]."</td><td>".rib2($r)."</td><td>".$r["edad_c"]."</td></tr>";
         };
      };
      if($sql3!=""){
         $tipo="NRIB";
         $reg=registros($sql3);
         while($r=mysqli_fetch_assoc($reg)){
          if($r["rib_numero"]==$rn){$hayrib=true;};
          echo "<tr><td>".$tipo."</td><td>".$r["apellidos"].", ".$r["nombres"]."</td><td>".$r["TDNI"]." ".$r["SujetosDni"]."</td><td>".rib2($r)."</td><td>".$r["edad_c"]."</td></tr>";
         };
      };
   };
  ?>
</table>
</div>
<?php 
  if($haydni){echo "No se puede crear nuevo legajo habiendo otro NNYA con el mismo DNI<br>";}
  else{
    if($hayrib){echo "No se puede crear nuevo legajo habiendo otro NNYA con el mismo RIB<br>";}
    else{
      if(isset($_GET["apellidos"])){echo "<button class='btn-primary' onclick='guarda()'>Crear nuevo legajo</button>";};
    };
  }; 
?>
</div>
<script>
function habilita_documento(){
 documento=document.getElementById("documento").value;
 if(documento=="1"){
  document.getElementById("td").disabled=false;
  document.getElementById("nd").disabled=false;
  document.getElementById("td").focus();
 }
 else{
  document.getElementById("td").value="";
  document.getElementById("td").disabled=true;
  document.getElementById("nd").value="";
  document.getElementById("nd").disabled=true;
 };
}
function habilita_rib(){
 rib=document.getElementById("rib").value;
 if(rib==1){
  document.getElementById("rib_anio").disabled=false;
  document.getElementById("rib_numero").disabled=false;
  document.getElementById("rib_reparticion").disabled=false;
  document.getElementById("td").focus();
 }
 else{
  document.getElementById("rib_anio").value="";
  document.getElementById("rib_numero").value="";
  document.getElementById("rib_reparticion").value="";
  document.getElementById("rib_anio").disabled=true;
  document.getElementById("rib_numero").disabled=true;
  document.getElementById("rib_reparticion").disabled=true;
 };
}
function habilita_nacimiento(){
 nacimiento=document.getElementById("nacimiento").value;
 if(nacimiento==1){
  document.getElementById("f_nacimiento").disabled=false;
  document.getElementById("edad").value="";
  document.getElementById("edad").disabled=true;
  document.getElementById("f_nacimiento").focus();
 }
 else{
  document.getElementById("f_nacimiento").value="";
  document.getElementById("f_nacimiento").disabled=true;
  document.getElementById("edad").disabled=false;
 };
}
function bl_nd(){
  valida_entero("nd");
  nd=document.getElementById("nd").value;
  td=document.getElementById("td").value;
	
  if(nd!="" && td=="1"){
	resp=ejec_sq("otrosnnya?dni="+nd);
	if(resp!="null"){
	datos=JSON.parse(resp);	
        document.getElementById("apellidos").value=datos.apellidos;
        document.getElementById("nombres").value=datos.nombres;
        document.getElementById("f_nacimiento").value=ffec(datos.nacimiento);
	seleccionar("nacimiento","1");
	habilita_nacimiento();
	seleccionar("sexo",datos.sexo);
        }
  }
  return true;	
}

function guarda(){
  apel=document.getElementById("apellidos").value;
  nomb=document.getElementById("nombres").value;
  sexo=document.getElementById("sexo").value;
  url="sujetonuevo_do?apellidos="+apel+"&nombres="+nomb+"&sexo="+sexo;
  documento=document.getElementById("documento").value;
  if(documento=="1"){
   td=document.getElementById("td").value;
   nd=document.getElementById("nd").value;
   url=url+"&td="+td+"&nd="+nd;
  };
  if(rib=="1"){
   ra=document.getElementById("rib_anio").value;
   rn=document.getElementById("rib_numero").value;
   rr=document.getElementById("rib_reparticion").value;
   url=url+"&ra="+ra+"&rn="+rn+"&rr="+rr;
  };
  if(nacimiento=="1"){
     fn=document.getElementById("f_nacimiento").value;
     url=url+"&fn="+fn;
  }
  else{
     ed=document.getElementById("edad").value;
     url=url+"&ed="+ed;
  };
 navega(url); 
}; 
habilita_documento();
habilita_rib();
habilita_nacimiento();
</script>
</body>
</html>