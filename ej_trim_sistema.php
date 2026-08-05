<?php
include('Funciones.php');
session_start();
$tipo=$_GET['tipo'];
// Ver estas dos
if($tipo=="PASSWORD"){
 $id=$_SESSION['usuario'];
 echo un_campo("select password from usuarios_semestrales where idusuarios=".$id);
};
if($tipo=="PASSWORD_CAMBIA"){
 $id=$_SESSION['usuario'];
 $nueva=tget('nueva');
 ejecute("update usuarios_semestrales set password=".$nueva." where idusuarios=".$id);
};
if($tipo=='DICCIONARIO_UNO'){
  $id=$_GET['id'];
  $r=un_registro('select * from diccionario_tablas where iddiccionario_tablas='. nulea($id));
  $r["codigo"]=utf8_encode($r["codigo"]);
  $r["descripcion"]=utf8_encode($r["descripcion"]);
  echo json_encode($r);
  exit();	
};
if($tipo=='TABLAS_UNA'){
  $id=$_GET['id'];
  $r=un_registro('select * from tablas_semestrales where idtablas_semestrales='. nulea($id));
  $r["descripcion"]=utf8_encode($r["descripcion"]);
  echo json_encode($r);
  exit();	
};

if($tipo=='DICCIONARIO_AGREGAR'){
 $id=nget("id");
 $codigo=tget("codigo");
 $descripcion=tget("descripcion");
 if($id=="0"){$id=inserte("insert into diccionario_tablas(codigo) values(".$codigo.")");};
 ejecute("update diccionario_tablas set codigo=".$codigo.", descripcion=".$descripcion." where iddiccionario_tablas=".$id);
 echo $id;
};

if($tipo=='TABLAS_AGREGAR'){
 $id=nget("id");
 $tipot=tget("tipot");
 $valor=nget("valor");
 $descripcion=tget("descripcion");
 if($id=="0"){$id=inserte("insert into tablas_semestrales(tipo,valor,descripcion) values(".$tipot.",".$valor.",'')");};
 ejecute("update tablas_semestrales set valor=".$valor.", tipo=".$tipot.", descripcion=".$descripcion." where idtablas_semestrales=".$id);
 echo $id;
};

if($tipo=='DICCIONARIO_BAJA'){
 $id=nget("id");
 ejecute("update diccionario_tablas set baja=curdate() where iddiccionario_tablas=".$id);
 echo $id;
};

if($tipo=='TABLAS_BAJA'){
 $id=nget("id");
 ejecute("update tablas_semestrales set baja=curdate() where idtablas_semestrales=".$id);
 echo $id;
};

if($tipo=='TABLA_VALOR'){
$id=nget("id");
$tipot=tget("tipot");
$valor=nget("valor");
echo un_campo("select case when idtablas_semestrales>0 then 1 else 0 end from tablas_semestrales where tipo=".$tipot." and valor=".$valor." and baja is null and idtablas_semestrales<>".$id);
};


?>