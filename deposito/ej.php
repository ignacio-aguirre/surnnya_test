<?php

include('func.php');

session_start();

$tipo=$_GET['tipo'];

if($tipo=='EFECTOR_SELECT'){
 $direccion=nget('direccion');
 $gerencia=nget('gerencia');
 $efector=nget('efector');
 echo opciones_cond('efectores','direccion='.$direccion.si($gerencia>0,' and gerencia='.$gerencia,'').si($efector>0,' and idefectores='.$efector,''));
};


if($tipo=='RUTA_ARCHIVO'){

  $id=nget('id');

  echo un_campo("select ruta from archivos where idarchivos=".$id);

};
if($tipo=='DISPOSITIVO'){
  $id=nget('id');

  $r=un_registro('select id,nombre,domicilio,localidad,barrio,comuna,telefonos from surnnya.dispositivos where id='.$id);
  echo json_encode($r);
};

?>