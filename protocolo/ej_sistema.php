<?php
include('funciones.php');
session_start();
$tipo=$_GET['tipo'];
if($tipo=='SEMA_PONE') echo inserte("insert into semaforo(intentos) values(0)");
if($tipo=='SEMA_SACA'){
 $id=$_GET['id'];
 ejecute("delete from semaforo where idsemaforo=".$id);
};

if($tipo=='SEMA_CONSULTA'){

 $id=$_GET['id'];

 $id_tope=un_campo("select idsemaforo from semaforo order by idsemaforo limit 1");

 ejecute("update semaforo set intentos=intentos+1 where idsemaforo=".$id_tope);

 $intentos=un_campo("select intentos from semaforo where idsemaforo=".$id_tope);

 if($intentos>100 and id_tope!=$id){

   ejecute("delete from semaforo where idsemaforo=".$id_tope);

   $id_tope=un_campo("select idsemaforo from semaforo order by idsemaforo limit 1");

 };

 echo $id_tope;

};



if($tipo=='SEMA_VIGENTE'){

 $id=$_GET['id'];

 echo un_campo("select idsemaforo from semaforo where idsemaforo=".$id);

};

if($tipo=='ESTADO_SESION'){

 echo si(isset($_SESSION['usuario']),"1","0");

};



?>