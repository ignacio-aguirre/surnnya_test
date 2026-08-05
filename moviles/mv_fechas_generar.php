<?php
include("funciones.php");
session_start();
$f_desde=fsql(ffec(un_campo("select max(date_add(fecha,interval 1 day)) from fechas")));
$f=$f_desde;
while(substr($f,0,6)==substr($f_desde,0,6)){
	inserte("insert into fechas (fecha,ds,laborable) values(".$f.",date_format(".$f.",'%a'),100)");
	$f=fsql(ffec(un_campo("select date_add(".$f.",interval 1 day) from dual")));
};

ejecute("update fechas set ds='lun', laborable=1 where laborable=100 and ds='Mon'");
ejecute("update fechas set ds='mar', laborable=1 where laborable=100 and ds='Tue'");
ejecute("update fechas set ds='mié', laborable=1 where laborable=100 and ds='Wed'");
ejecute("update fechas set ds='jue', laborable=1 where laborable=100 and ds='Thu'");
ejecute("update fechas set ds='vie', laborable=1 where laborable=100 and ds='Fri'");
ejecute("update fechas set ds='sáb', laborable=0 where laborable=100 and ds='Sat'");
ejecute("update fechas set ds='dom', laborable=0 where laborable=100 and ds='Sun'");
$_SESSION["msg"]="Se generaron 30 fechas más";
$_SESSION["retorno"]="mv_fechas";
Redirect("aviso");
?>