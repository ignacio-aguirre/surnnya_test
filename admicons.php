<?php
include("Funciones.php");
session_start();
include("encabezado-test.php");
if (!isset($_SESSION['gldispo'])) header ("Location: salir");
registre();
$opci=str_replace("Completar","Todas",$_SESSION["Opc_Hoga_Cate"]);
$cate="";
if(isset($_GET["icate"])){$cate=$_GET["icate"];};
$situ="";
if(isset($_GET["sshab"])){$situ=$_GET["sshab"];};
$edde="0";
if(isset($_GET["edde"])){$edde=$_GET["edde"];};
$edha="99";
if(isset($_GET["edha"])){$edha=$_GET["edha"];};
?>
<hr>
<div class="container">
<form class="form-inline">
 <div class='form-group has-warning'>
  <label class='label-form' for='categoria'>Categor&iacute;as</label>
  <select class='form-control' name="icate" id="categoria"><?php echo $opci;?></select>&nbsp;&nbsp;&nbsp;
 </div>

 <div class='form-group has-warning'>
  <label class='label-form' for='sshab'>Sit.Socio Habitacional</label>
  <select class='form-control' name="sshab" id="sshab"><?php echo $_SESSION['Opc_Hoga_Proc'];?></select>
  <br><br>
 </div>
 
 <div class='form-group has-warning'>
  <label class='label-form' for='edde'>Edad desde</label>
  <input class='form-control' name="edde" id="edde" value="<?php echo $edde;?>" size="2" maxlength="2">
 </div>

 <div class='form-group has-warning'>
  <label class='label-form' for='edha'>Edad hasta</label>
  <input class='form-control' name="edha" id="edha" value="<?php echo $edha;?>" size="2" maxlength="2">
 </div>



<input name="submit" type="submit" value="Consultar" />

</form>
<button class="btn btn-success" onclick="navega('admicons_excel')">Excel</button>
<hr>
<script type="text/javascript">enfoca("categoria");seleccionar('categoria','<?php echo $cate;?>');
seleccionar('sshab','<?php echo $situ;?>');</script> 



<strong>Pedidos a Asignar</strong>

<div class='table-responsive'>

<table class='table table-striped table-bordered'>

<tr>

<th align="left">Acciones</th><th style='font-size:.8em'>Pedido</th><th style='font-size:.8em'>Categor&iacute;a</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th style='font-size:.8em'>Solicitante</th>
<th style='font-size:.8em'>Sit.Socio Hab.</th><th style='font-size:.8em'>Estado</th><th style='font-size:.8em'>Actualizar</th></tr>

<?php

if(isset($_GET['mensaje'])) {echo $_GET['mensaje'];alerte($_GET['mensaje']);}; 

if (isset($_GET["icate"]))

{

 $cate=$_GET["icate"];

 

 echo "<script type='text/javascript'>seleccionar('i_cate','".$cate."');</script>";

 if($_GET["icate"]=="4"||$_GET["icate"]=="6") {

  $sql="select hogares_admision.*, datediff(curdate(),admi_fped) as dife, sujetos.legajo , sujetos.apellidos as apel, Nombres, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,sujetosmeses,hogares_ca.deno as dcate, 
 case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else 
   concat(hogares_dz.deno,
    case when hogares_dz.info>'' then concat('-',hogares_dz.info) 
        else '' 
    end,
    case when admi_deriv_cual >'' 
     then concat('-',admi_deriv_cual)  
    else '' end) 
  end as deriv ,  
  concat(hogares_proc.deno,' ',admi_proc_cual) as proc,  grupos.apellidos as grup, grupo,
  etapas.deno as eta, fecha_etapa from hogares_admision  

   left join sujetos on admi_legajo=sujetos.legajo 

   left join grupos_legajos on grupos_legajos.grupo_legajo=admi_legajo
   left join grupos on grupo=idgrupos
   left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
   left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 

   left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
   left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH'  
   left join tablas etapas on etapa=etapas.valo and etapas.tipo='ADEV'  
   left join dispositivos on admi_hogar=dispositivos.id

   where admi_cate=".$_GET["icate"]." and admi_fderiv is null and admi_fped is not null and admi_alta is null and admi_susp is null ";
   $sql=$sql." and edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) between ".$edde." and ".$edha;
   if($situ<>"") $sql=$sql." and admi_proc=".$situ." ";
   $sql=$sql." order by  grup,apel, nombres";

   $conn =registros($sql);

   $conta=0;

   while ($da = mysqli_fetch_assoc($conn)) {

      $conta=$conta+1;

      $lega=$da['legajo'];

      $apel=$da["apel"];

      $nomb= $da["Nombres"];

      $falt=$da["admi_falt"];

      if(gettype($falt)!="NULL") $falt=ffec($falt);
     
     $oficio=un_campo("select count(*) from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where tipo='S' and identificador=".$lega." and  as_tipo=186 and datediff(curdate(),as_fecha)<180");
      if($oficio>"0") {echo "<tr class='bg-warning'><td>";}    
      else{echo "<tr><td>";};
      if(($da['dife']<180 && $_SESSION['gl_acciones']==1)||($da['dife']<30 && $_SESSION['glusua']==$da['admi_usuario'])) echo " <a href='recuborra?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";

      if(($_SESSION['gl_acciones']==1||$_SESSION['glusua']==$da['admi_usuario'])) echo " <a href='admiedita?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/editar.png'></a>";

      if(gettype($da["admi_susp"])=="NULL") {
        echo "<a href='admigest?iid=".$da["idhogares_admision"]."'>Ges</a> ";
        echo "<a href='admiasig?iid=".$da["idhogares_admision"]."'>Asi</a> ";
      };
      echo "<a href='admisusp?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/pausa.png'></a>";
      echo "</td>";
      echo "<td style='font-size:.8em'>".ffec($da["admi_fped"])."</td>";	
      echo "<td style='font-size:.8em'>".$da["grup"]." <a href='admigestgrup?igru=".$da["grupo"]."'>GGRU</a> </td>";
      echo "<td><a href='suje_cons_duros?legajo=".$da["admi_legajo"]."' target='_blank'".$apel." , ".$nomb."</a>".$apel.", ".$nomb."</td>";
      echo "<td>".$da["edad_calc"]."</td>";
      echo "<td style='font-size:.8em'>".strtolower($da["deriv"])."</td>";
      echo "<td style='font-size:.8em'>".strtolower($da["proc"])."</td>";
      echo "<td style='font-size:.8em'>".$da["eta"]." ".$da["nombre"]." ".ffec($da["fecha_etapa"])."</td><td><a href='admision_estado?id=".$da["idhogares_admision"]."'><img src='imagenes/ok.png' height='15' width='15'></a></td>";
      echo "</tr>";

   };   

  }

 else 

  {

    $sql="select hogares_admision.*, datediff(curdate(),admi_fped) as dife, sujetos.legajo , sujetos.apellidos as apel, Nombres, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) as edad_calc,sujetosmeses,hogares_ca.deno as cate, 
 case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else 
   concat(hogares_dz.deno,
    case when hogares_dz.info>'' then concat('-',hogares_dz.info) 
        else '' 
    end,
    case when admi_deriv_cual >'' 
     then concat('-',admi_deriv_cual)  
    else '' end) 
  end as deriv ,  
   
 concat(hogares_proc.deno,' ',admi_proc_cual) as proc, 
    etapas.deno as eta, nombre, fecha_etapa from hogares_admision

    left join sujetos on admi_legajo=sujetos.legajo 

    left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
    left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 
	
    left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 

    left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' 

    left join tablas etapas on etapa=etapas.valo and etapas.tipo='ADEV'  
    left join dispositivos on admi_hogar=dispositivos.id 
    where admi_fderiv is null and admi_fped is not null and admi_alta is null and admi_susp is null ";
    $sql=$sql." and edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,curdate()) between ".$edde." and ".$edha;

    if($situ<>"") $sql=$sql." and admi_proc=".$situ." ";




    $sql=$sql." order by  apel, Nombres";

    $conn = registros($sql);

    $conta=0;

    while ($da = mysqli_fetch_assoc($conn)) {

     if ($cate==""||$da['admi_cate']==$cate) {

      $conta=$conta+1;

      $lega=$da['legajo'];

      $apel=$da["apel"];

      $nomb= $da["Nombres"];

      $falt=$da["admi_falt"];

      if(gettype($falt)!="NULL") $falt=ffec($falt);
     $oficio=un_campo("select count(*) from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos where tipo='S' and identificador=".$lega." and  as_tipo=186 and datediff(curdate(),as_fecha)<180");
      if($oficio>"0") {echo "<tr class='bg-warning'><td>";}    
      else{echo "<tr><td>";};

      if(($da['dife']<180 && $_SESSION['gl_acciones']==1)||($da['dife']<30 && $_SESSION['glusua']==$da['admi_usuario'])) echo " <a href='recuborra?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";

      if(($_SESSION['gl_acciones']==1||$_SESSION['glusua']==$da['admi_usuario'])) echo " <a href='admiedita?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/editar.png'></a>";

      echo "<a href='admigest?iid=".$da["idhogares_admision"]."'>Ges</a> ";

      echo "<a href='admiasig?iid=".$da["idhogares_admision"]."'>Asi</a> ";

      echo "<a href='admisusp?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/pausa.png'></a>";

      echo "</td>";

      echo "<td style='font-size:.8em'>".ffec($da["admi_fped"])."</td>";	

      echo "<td style='font-size:.8em'>".strtolower($da["cate"])."</td>";

      echo "<td><a href='suje_cons_duros?legajo=".$da["admi_legajo"]."' target='_blank'".$apel.", ".$nomb."</a>".$apel." , ".$nomb."</td>";
      echo "<td>".$da["edad_calc"]."</td>";

      echo "<td style='font-size:.8em'>".strtolower($da["deriv"])."</td>";

      echo "<td style='font-size:.8em'>".strtolower($da["proc"])."</td>";

      echo "<td style='font-size:.8em'>".$da["eta"]." ".$da["nombre"]." ".ffec($da["fecha_etapa"])."</td><td><a href='admision_estado?id=".$da["idhogares_admision"]."'><img src='imagenes/ok.png' height='15' width='15'></a></td>";
      echo "</tr>";

     };

    };   

  };

	

		

};



?>

</table>

</div>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};?>

<br><br><strong>Pedidos Asignados Sin Alta Efectiva</strong>

<div class="table-responsive">

<table class="table table-striped table-borderer">

<tr><th align="left">Acciones</th><th>Hogar</th><th>Apellido y Nombre</th><th>Edad (hoy)</th><th>Fecha Asign.</th><th>Categor&iacute;a</th><th>Sit.Socio Hab.</th>

<?php

if (isset($_GET["icate"]))

{

	$sql="select hogares_admision.*, datediff(curdate(),admi_fderiv) as dife, sujetos.legajo , Apellidos, Nombres, edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,SujetosActEdad,curdate()) as edad_calc,hogares_ca.deno as cate, hogares_de.deno as deriv ,  hogares_proc.deno as proc, 
 case when tipo_dispositivo=1 then concat('AF: ',af_familias.denominacion) else nombre end as hogar from hogares_admision ";

	$sql=$sql." left join sujetos on admi_legajo=sujetos.legajo ";

	$sql=$sql." left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' ";

	$sql=$sql." left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' ";

	$sql=$sql." left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH'  ";

	$sql=$sql." left join dispositivos on admi_hogar=dispositivos.id ";

	$sql=$sql." left join af_familias on admi_fami=idaf_familias ";



	$sql=$sql." where admi_fderiv is not null and admi_alta is null and admi_susp is null";

	$sql=$sql." order by  admi_fderiv desc,Apellidos,Nombres ";

	$conn = registros($sql);

	$conta=0;

	while ($da = mysqli_fetch_assoc($conn)) {

         if ($cate==""||$da['admi_cate']==$cate) {

         $conta=$conta+1;

         $apel=$da["Apellidos"];

	 $nomb= $da["Nombres"];

	 echo "<tr><td>";

         if(($_SESSION['gl_acciones']==1||$_SESSION['glusua']==$da['admi_usuario'])) echo "<a href='admiedita?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/editar.png'></a>";

              echo "<a href='admialta?iid=".$da["idhogares_admision"]."'>ALTA</a>*";

              if(gettype($da["admi_susp"])=="NULL") echo "<a href='admisusp?iid=".$da["idhogares_admision"]."'><img height='15' width='15' src='imagenes/pausa.png'></a>";

              echo "*<a href='admigest?iid=".$da["idhogares_admision"]."'>GES</a>";

              echo "</td>";

	      echo "<td>".$da["hogar"]."</td>";

      	      echo "<td>".$apel." , ".$nomb."</td>";

      	      echo "<td>".$da["edad_calc"]."</td>";              	

	      echo "<td>".ffec($da["admi_fderiv"])."</td>";	

	      echo "<td>".$da["cate"]."</td>";

	      echo "<td>".$da["proc"]."</td>";

      	      echo "</tr>";};};	

};



?>

</table>

<?php if(isset($conta)){ echo 'Total ';echo $conta;echo ' registros ';};?>

</div>



</body>

</html>