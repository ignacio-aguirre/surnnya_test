<?php 
include("funciones.php");
session_start();
$tabla=$_GET["tipo"];
echo "<table id='brow' class='table table-bordered table-condensed'>";
if($tabla=="ARTICULOS_BUSQUEDA"){
 $frase=$_GET["frase"];
 $rubro=$_GET["rubro"];
 echo "<tr class='bg-primary'><th>Descripci&oacuten</th><th>Rubro</th><th>Tipo de Bien</th><th>Vto.</th><th>Acciones</th></tr>";
 $reg=registros("select idarticulos,articulos.descripcion,articulos_rubros.descripcion as rub, tipo_bien,vencimiento from articulos left join articulos_rubros on rubro=idarticulos_rubros where articulos.descripcion like '%".$frase."%' and articulos.baja is null ".si($rubro!="0"," and rubro=".$rubro,"")." order by articulos_rubros.descripcion,articulos.descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["descripcion"]."</td><td>".$r["rub"]."</td><td>".si($r["tipo_bien"]==1,"Bien de Consumo","Bien de Uso")."</td><td>".si($r["vencimiento"]==1,"Si","No")."</td><td>";
  echo "<button class='btn-sm btn-primary' onclick=navega('articulos_editar?id=".$r["idarticulos"]."')>Editar</button>&nbsp;";
  $stk=un_campo("select cantidad from existencias where articulo=".$r["idarticulos"]);
  if(!$stk>"0"){
  echo "<button class='btn-sm btn-danger' onclick=navega('articulos_editar?baja=1&id=".$r["idarticulos"]."')>Baja</button>";
  };
  echo "</td></tr>";
 };

echo "</table>";
};

if($tabla=="RUBROS"){
 $frase=$_GET["frase"];
 echo "<tr class='bg-primary'><th>Descripci&oacuten</th><th>Acciones</th></tr>";
 $reg=registros("select * from articulos_rubros where baja is null and  articulos_rubros.descripcion like '%".$frase."%' order by descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["descripcion"]."</td><td>";
  echo "<button class='btn-sm btn-primary' onclick=navega('rubros_editar?id=".$r["idarticulos_rubros"]."')>Editar</button>&nbsp;";
  echo "</td></tr>";
 };
echo "</table>";
};

if($tabla=="EFECTORES"){
 echo "<tr class='bg-primary'><th>Descripci&oacute;n</th><th>Domicilio</th><th>Tel&eacutefonos</th><th>Acciones</th></tr>";
 $reg=registros("select idefectores, efectores.descripcion,domicilio,telefonos  from efectores 
 where efectores.baja is null order by  efectores.descripcion");
 while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["descripcion"]."</td><td>".$r["domicilio"]."</td><td>".$r["telefonos"].
   "</td><td><button class='btn-sm btn-primary' onclick=navega('efectores_editar?id=".$r["idefectores"]."')>Editar</a></button>&nbsp";
  if(un_campo("select count(*) from remitos where efector=".$r["idefectores"])=="0"){
    echo "<button class='btn-sm btn-danger' onclick=navega('efectores_editar?baja=1&id=".$r["idefectores"]."')>Baja</a></button>";
  };
  echo "</tr>";
 };
echo "</table>";
};


if($tabla=="USUARIOS"){
 echo "<tr class='bg-primary'><th>Apellido</th><th>Nombre</th><th>CUIL</th><th>Rol</th><th>Acciones</th></tr>";
 $reg=registros("select idusuarios, apellido, usuarios.nombre, cuil, roles.nombre as perf from usuarios  
  left join roles on rol=roles.id where usuarios.baja is null order by apellido, nombre");
while($r=mysqli_fetch_assoc($reg)){
  echo "<tr><td>".$r["apellido"]."</td><td>".$r["nombre"]."</td><td>".$r["cuil"]."</td><td>".$r["perf"].
"</td><td><button class='btn-sm btn-primary' onclick=navega('usuarios_editar?id=".$r["idusuarios"]."')>Editar</button>&nbsp;
<button class='btn-sm btn-danger' onclick=navega('usuarios_editar?baja=1&id=".$r["idusuarios"]."')>Eliminar</button>
</td></tr>";
 };
echo "</table>";
};

?>



