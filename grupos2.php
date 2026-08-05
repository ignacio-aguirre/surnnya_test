<?php
include("Funciones.php");
session_start();
$_SESSION["prestacion"]="Grupos de Hermanos / Materno - Composici&oacute;n";
include("encabezado-test.php");
if($_SESSION['gl_editar_sujeto']==0) Redirect("salir");
registre();
$id="";
$apel="";
if(isset($_GET["id"])&& $_GET["id"]!="") 
{$id=$_GET["id"];
$apel=un_campo("select apellidos from grupos where idgrupos=".$id);
};
?>
<div class="container">
<h3>Miembros del grupo <?php echo $apel;?></h3>
<div class="table-responsive pre-scrollable">
<table class="table">
<th>Legajo</th><th>Apellidos</th><th>Nombres</th><th>Documento</th><th>Edad</th><th>Alojamiento</th><th>Madre</th><th>Cambiar</th>
<?php
if($id!=""){

$legs=registros("select sujetos.legajo,apellidos, nombres, sujetosdni, 
  edc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as edadhoy , 
(select nombre from hogares_admision left join dispositivos on admi_hogar=dispositivos.id where admi_alta is not null and admi_baja is null and admi_legajo=sujetos.legajo) as hogar,
 madre from grupos_legajos left join sujetos on legajo=grupo_legajo 
 where grupo=".$id." order by apellidos, nombres");

$conta=1; 

$haymadre="0";

while ($da = mysqli_fetch_assoc($legs)) {

   $conta=$conta+1;

   if($conta % 2==0) {echo "<tr bgcolor='white'>";} else echo "<tr bgcolor='#E6E6E6'>";

   echo "<td><a href='suje_cons_duros?legajo=".$da['legajo']."'>".$da['legajo']."</a> ";

   if($_SESSION['gl_todos_dispo']==1||$_SESSION['gl_admi']==1) echo "<a href='grupo_elimina_miembro?id=".$id."&legajo=".$da["legajo"]."'><img height='15' width='15' src='imagenes/eliminar.png'></a>";

   echo "</td>";

   echo "<td>".$da['apellidos']."</td><td>".$da['nombres']."</td><td>".$da['sujetosdni']."</td><td>".$da['edadhoy']."</td><td>".$da['hogar']."</td><td>".si($da['madre']=="1","S&iacute;","No")."</td>";

   echo "<td><button onclick='cambiar(".$da["legajo"].",".si($da["madre"]=="1","0","1").")'></td>";

   echo "</tr>"; 

   if($da["madre"]=="1") $haymadre="1";

 };



};

?>

</table>

</div>

<h3>Agregar al Grupo</h3>

<form class="form-inline" onsubmit="return false">

<div class="form-group has-warning">

<label class="control-label" for="busqueda">texto a buscar</label>

<input class="form-control" id="busqueda" size="40" maxlength="40" onblur="sale_busqueda(this.id)" placeholder="se recomienda buscar por DNI, RIB o legajo">

</div>

</form>

<form class="form-inline" onsubmit="return false">

<div class="form-group has-warning">

<label class="control-label" for="apynomb">Apellidos y Nombres</label>

<var class="form-control" id="apynomb"></var>

</div>

</form>

<form class="form-inline" onsubmit="return false">

<div class="form-group has-warning">

<label class="control-label" for="madre">Marcar si es la Madre del grupo</label>

<input class="form-control" type="checkbox" id="madre">

</div>

<br>

<button id="aceptar" class="btn-primary" onclick="agregar()"  disabled>Agregar</button>

</form>

<script>

function sale_busqueda(){

tienemadre="<?php echo $haymadre?>";

busqueda=document.getElementById("busqueda").value;

if(busqueda==""){

  document.getElementById("aceptar").disabled=true;

  document.getElementById("apynomb").innerHTML="";

  document.getElementById("madre").checked=false;

}

else{

  respuesta=ejec("grupo_agregar_busqueda","","&busqueda="+busqueda);

  if(respuesta!=""){

    document.getElementById("apynomb").innerHTML=respuesta.substring(7,100);

    document.getElementById("aceptar").disabled=false;

    busqueda=respuesta.substring(1,7);

    document.getElementById("busqueda").value=busqueda;

    sexo=respuesta.substring(0,1);

    if(sexo=="F"&&tienemadre=="0"){document.getElementById("madre").disabled=false;}

    else{document.getElementById("madre").disabled=true; document.getElementById("madre").checked=false;}; 

  }

  else{

  document.getElementById("aceptar").disabled=true;

  document.getElementById("apynomb").innerHTML="";

  document.getElementById("madre").checked=false;

  };

};

}

function agregar(){

valida_entero("busqueda");

busqueda=document.getElementById("busqueda").value;

madre="0";

if(!document.getElementById("madre").disabled&&document.getElementById("madre").checked) madre="1";

if(busqueda==""){return false;};

engrupo=ejec("grupo_agregar_engrupo","","&legajo="+busqueda);

if(engrupo=="1") {alert("ya en un grupo");return false;};

navega("grupo_agrega?grupo=<?php echo $id;?>&legajo="+busqueda+"&madre="+madre);

return true;

}

</script>



<br><button onClick='navega("grupo_familia?id=<?php echo $id;?>");'>Actualizar hnos en grupo familiar</button><br><br>

Subir Nuevo <a href="subir_archivos?grupo=<?php echo $id;?>">Archivo</a><br>



<h2>Archivos Vinculados</h2>

<div class="table-responsive pre-scrollable">

<table class="table">

<th>Tipo</th><th>Descripci&oacute;n</th><th>Efector - Usuario</th><th>Fecha Subida</th><th>Acciones</th>

<?php 

 

  $sql="select deno,restringido,as_descripcion, concat(denominacion,'-',as_usuario) as efector, as_fecha as fecha, as_path,

  as_dispositivo, as_usuario, idarchivos_subidos as id 

  from archivos_vinculos left join archivos_subidos on archivo=idarchivos_subidos left join sectores on sectores.id=as_dispositivo 

  left join tablas on tablas.tipo='TA' and tablas.valo=as_tipo 

  where archivos_vinculos.tipo='G' and identificador=".$id." and as_baja is null 

  order by as_tipo, as_fecha desc";

  $conn = registros($sql);

   while ($da = mysqli_fetch_assoc($conn)) {

    if($da["restringido"]==0||$_SESSION["menu"]=="menusys") {

     echo colorfila()."<td>".$da['deno']."</td><td>".$da['as_descripcion']."</td><td>".$da['efector']."</td><td>".ffec($da['fecha'])."</td><td><a href='descarga?link=".sacamas($da['as_path'])."&nombre=".sacamas_limpia(sacapath($da['as_path']))."'>Descargar</a>";

     if($da['as_dispositivo']==$_SESSION['gldispo']&&$da['as_usuario']==$_SESSION['glusua']) echo "<a href='archdesvincular?id=".$da['id']."&tipo=G&identificador=".$id."'> Desvincular</a>";

     echo "</td></tr>";

    };

   };

 

?>

</table>

</div>

</div>

<script>

function cambiar(legajo,madre){

id="<?php echo $id?>";

haymadre="<?php echo $haymadre?>";

navega("grupo_cambiarmadre?id="+id+"&legajo="+legajo+"&madre="+madre+"&haymadre="+haymadre);

}

</script>

</body>

</html>