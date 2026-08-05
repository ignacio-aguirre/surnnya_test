<?php
error_reporting(E_STRICT);
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();
$desde=fget("desde");
$hasta=fget("hasta");
$spreadsheet = new Spreadsheet();
  $spreadsheet->setActiveSheetIndex(0);
  $spreadsheet->getActiveSheet()->setTitle('NNYA_PIngreso');

  $spreadsheet->createSheet(1);
  $spreadsheet->setActiveSheetIndex(1);
  $spreadsheet->getActiveSheet()->setTitle('NNYA_RHogares');

  $spreadsheet->createSheet(2);
  $spreadsheet->setActiveSheetIndex(2);
  $spreadsheet->getActiveSheet()->setTitle('INGRESOS');

  $spreadsheet->createSheet(3);
  $spreadsheet->setActiveSheetIndex(3);
  $spreadsheet->getActiveSheet()->setTitle('EGRESOS');

  $spreadsheet->createSheet(4);
  $spreadsheet->setActiveSheetIndex(4);
  $spreadsheet->getActiveSheet()->setTitle('GVAC_EN_DISP');

  $spreadsheet->createSheet(5);
  $spreadsheet->setActiveSheetIndex(5);
  $spreadsheet->getActiveSheet()->setTitle('GVAC_NOEN_DISP');

  $spreadsheet->createSheet(6);
  $spreadsheet->setActiveSheetIndex(6);
  $spreadsheet->getActiveSheet()->setTitle('ADM_ASIG');

  $spreadsheet->createSheet(7);
  $spreadsheet->setActiveSheetIndex(7);
  $spreadsheet->getActiveSheet()->setTitle('ADM_SUSP');

  $spreadsheet->createSheet(8);
  $spreadsheet->setActiveSheetIndex(8);
  $spreadsheet->getActiveSheet()->setTitle('DatosEmision');

// NNYA ALOJADOS PREINGRESO
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NNYA Alojados')
            ->setCellValue('B1', 'Pre Ingreso')
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(0)
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Pertenencia')
            ->setCellValue('C2', 'Dir Operativa')
            ->setCellValue('D2', 'Apellido y Nombre')
            ->setCellValue('E2', 'F.Nacimiento')
            ->setCellValue('F2', 'Edad')
            ->setCellValue('G2', 'Ingreso')
            ->setCellValue('H2', 'Permanencia')
            ->setCellValue('I2', 'RIB')
            ->setCellValue('J2', 'DZ o Sector MEX')
;

$sql="select nombre, case when ong>0 then 'CONVENIADO' else 'PROPIO' end as pert,diop.deno as diroper,concat(apellidos,', ',nombres) as apynom, rib_anio, rib_numero, rib_reparticion,
edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,sujetosactedad,".$hasta.") as eda, f_nacimiento,admi_alta, datediff(".$hasta.",admi_alta) as perm, tdz.deno as dz 
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 left join sujetos on admi_legajo=sujetos.legajo
 left join tablas diop on diop.tipo='DIOP' and direccion_operativa=diop.valo 
 left join tablas tdz on tdz.tipo='CM' and tdz.valo=defensoria_zonal

 where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>".$hasta.") and area_gubernamental=1 and tipo_dispositivo=11
 order by nombre, apellidos, nombres ";

$reg=registros($sql);
$fl=2;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["pert"])
            ->setCellValue('C'.ltrim((string)$fl), $r["diroper"])
            ->setCellValue('D'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('E'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('F'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('G'.ltrim((string)$fl), ffec($r["admi_alta"]))
            ->setCellValue('H'.ltrim((string)$fl), $r["perm"])
            ->setCellValue('I'.ltrim((string)$fl), rib2($r))
            ->setCellValue('J'.ltrim((string)$fl), $r["dz"])
;
};

$sql="select count(*) as alojados, sum(case when datediff(".$hasta.",admi_alta)<=90 then 1 else 0 end) as h90,
sum(case when datediff(".$hasta.",admi_alta)>90 and datediff(".$hasta.",admi_alta)<=180 then 1 else 0 end) as h180,
sum(case when datediff(".$hasta.",admi_alta)>180 then 1 else 0 end) as hmas, avg(datediff(".$hasta.",admi_alta)) as prom 
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>".$hasta.") and area_gubernamental=1 and tipo_dispositivo=11";

 $r=un_registro($sql);
 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "PERMANENCIA");

$spreadsheet->setActiveSheetIndex(0)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl),"NNYA alojados")
            ->setCellValue('B'.ltrim((string)$fl),intval($r["alojados"]));

 $fl=$fl+1;

 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "h/90 ds")
  	    ->setCellValue('B'.ltrim((string)$fl),$r["h90"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "91 - 180")
            ->setCellValue('B'.ltrim((string)$fl), $r["h180"]);
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "mas de 180")
            ->setCellValue('B'.ltrim((string)$fl), $r["hmas"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), "PermProm")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["prom"]));

for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:J2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


// NNYA ALOJADOS RED DE HOGARES
$spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A1', 'NNYA Alojados')
            ->setCellValue('B1', 'Red Hogares')
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(1)
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Pertenencia')
            ->setCellValue('C2', 'Dir Operativa')
            ->setCellValue('D2', 'Apellido y Nombre')
            ->setCellValue('E2', 'F.Nacimiento')
            ->setCellValue('F2', 'Edad')
            ->setCellValue('G2', 'Ingreso')
            ->setCellValue('H2', 'Permanencia')
            ->setCellValue('I2', 'RIB')
            ->setCellValue('J2', 'DZ o Sector MEX')
;

$sql="select nombre, case when ong>0 then 'CONVENIADO' else 'PROPIO' end as pert,diop.deno as diroper,concat(apellidos,', ',nombres) as apynom, rib_anio, rib_numero, rib_reparticion,
edadcalc(f_nacimiento,sujetosEdad,sujetosMeses,sujetosactedad,".$hasta.") as eda, admi_alta, datediff(".$hasta.",admi_alta) as perm, f_nacimiento, tdz.deno as dz 
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 left join sujetos on admi_legajo=sujetos.legajo
 left join tablas diop on diop.tipo='DIOP' and direccion_operativa=diop.valo 
 left join tablas tdz on tdz.tipo='CM' and defensoria_zonal=tdz.valo 
 where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>".$hasta.") and area_gubernamental=1 and tipo_dispositivo=2
 order by nombre, apellidos, nombres ";

$reg=registros($sql);
$fl=2;
while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["pert"])
            ->setCellValue('C'.ltrim((string)$fl), $r["diroper"])
            ->setCellValue('D'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('E'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('F'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('G'.ltrim((string)$fl), ffec($r["admi_alta"]))
            ->setCellValue('H'.ltrim((string)$fl), $r["perm"])
            ->setCellValue('I'.ltrim((string)$fl), rib2($r))
            ->setCellValue('J'.ltrim((string)$fl), $r["dz"])

;

};
$sql="select count(*) as alojados, sum(case when datediff(".$hasta.",admi_alta)<=90 then 1 else 0 end) as h90,
sum(case when datediff(".$hasta.",admi_alta)>90 and datediff(".$hasta.",admi_alta)<=180 then 1 else 0 end) as h180,
sum(case when datediff(".$hasta.",admi_alta)>180 then 1 else 0 end) as hmas, avg(datediff(".$hasta.",admi_alta)) as prom 
from hogares_admision 
 left join dispositivos on dispositivos.id=admi_hogar
 where admi_alta<=".$hasta." and (admi_baja is null or admi_baja>".$hasta.") and area_gubernamental=1 and tipo_dispositivo=2";

 $r=un_registro($sql);
 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), "PERMANENCIA");

$spreadsheet->setActiveSheetIndex(1)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl),"NNYA alojados")
            ->setCellValue('B'.ltrim((string)$fl),intval($r["alojados"]));

 $fl=$fl+1;

 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), "h/90 ds")
  	    ->setCellValue('B'.ltrim((string)$fl),$r["h90"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), "91 - 180")
            ->setCellValue('B'.ltrim((string)$fl), $r["h180"]);
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), "mas de 180")
            ->setCellValue('B'.ltrim((string)$fl), $r["hmas"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('A'.ltrim((string)$fl), "PermProm")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["prom"]));

for($col='A'; $col<= 'J'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(1)->getStyle('A1:J2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


// INGRESOS
$spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A1', 'INGRESOS')
            ->setCellValue('B1', 'del '.$_GET["desde"])
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(2)
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Pertenencia')
            ->setCellValue('C2', 'Dir Operativa')
            ->setCellValue('D2', 'Circuito')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'F.Nacimiento')
            ->setCellValue('G2', 'Edad')
            ->setCellValue('H2', 'F.Ingreso')
            ->setCellValue('I2', 'Tipo/Motivo Ingreso')
            ->setCellValue('J2', 'RIB')
            ->setCellValue('K2', 'DZ o Sector MEX')
;

$sql="select *,sujetos.legajo as lega, nombre , ming.deno as moti, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as eda,
case when ong>0 then 'CONVENIADO' else 'PROPIO' end as pert, dire.deno as diroper, concat(apellidos,', ',nombres) as apynom ,
rib_anio, rib_numero, rib_reparticion, case when tipo_dispositivo in (1,2) then 'RED HOGARES' else 'PREINGRESO' end as circuito, f_nacimiento, tdz.deno as dz  
from altasybajas left join hogares_admision on vacante=idhogares_admision
 left join dispositivos on dispositivos.id=altasybajas.hogar 
 left join sujetos on altasybajas.legajo=sujetos.legajo
 left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti 
 left join tablas dire on dire.tipo='DIOP' and dire.valo=direccion_operativa 
 left join tablas tdz on tdz.tipo='CM' and tdz.valo=defensoria_zonal 
 where tipo_dispositivo in (1,2,11) and operacion='A' and fecha_operacion between ".$desde." and ".$hasta." order by nombre,apynom";
 $reg=registros($sql);
 $fl=2;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["pert"])
            ->setCellValue('C'.ltrim((string)$fl), $r["diroper"])
            ->setCellValue('D'.ltrim((string)$fl), $r["circuito"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha_operacion"]))
            ->setCellValue('I'.ltrim((string)$fl), $r["moti"])
            ->setCellValue('J'.ltrim((string)$fl), rib2($r))
            ->setCellValue('K'.ltrim((string)$fl), $r["dz"]);
};
$sql="select count(*) as ingresos, sum(case when tipo_dispositivo in (1,2) then 1 else 0 end) as red_hogares,
sum(case when tipo_dispositivo = 11 then 1 else 0 end) as preingreso,
sum(case when not ong>0 then 1 else 0 end) as propios,
sum(case when ong>0 then 1 else 0 end) as conveniados,
sum(case when not admi_moti in (5,19) then 1 else 0 end) as sistema,
sum(case when admi_moti in (5,19) then 1 else 0 end) as cambios
from altasybajas left join hogares_admision on vacante=idhogares_admision
 left join dispositivos on dispositivos.id=altasybajas.hogar 
 left join sujetos on altasybajas.legajo=sujetos.legajo
 left join tablas ming on ming.tipo='HOMOI' and ming.valo=admi_moti 
 left join tablas dire on dire.tipo='DIOP' and dire.valo=direccion_operativa 
 where tipo_dispositivo in (1,2,11) and operacion='A' and fecha_operacion between ".$desde." and ".$hasta;

 $r=un_registro($sql);
 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");

$spreadsheet->setActiveSheetIndex(2)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl),"Ingresos")
            ->setCellValue('B'.ltrim((string)$fl),intval($r["ingresos"]));

 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Red de Hogares")
  	    ->setCellValue('B'.ltrim((string)$fl),$r["red_hogares"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Pre Ingreso")
            ->setCellValue('B'.ltrim((string)$fl), $r["preingreso"]);
 $fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Propios")
            ->setCellValue('B'.ltrim((string)$fl), $r["propios"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Conveniados")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["conveniados"]));
 $fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Ing/Reing Sistema")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["sistema"]));

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(2)
            ->setCellValue('A'.ltrim((string)$fl), "Cambios Dispositivo")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["cambios"]));


for($col='A'; $col<= 'K'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(2)->getStyle('A1:K2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

// EGRESOS
$spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A1', 'EGRESOS')
            ->setCellValue('B1', 'del '.$_GET["desde"])
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(3)
	    ->setCellValue('A2', 'Dispositivo')
            ->setCellValue('B2', 'Pertenencia')
            ->setCellValue('C2', 'Dir Operativa')
            ->setCellValue('D2', 'Circuito')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'F.Nacimiento')
            ->setCellValue('G2', 'Edad')
            ->setCellValue('H2', 'F.Egreso')
            ->setCellValue('I2', 'Tipo/Motivo Egreso')
            ->setCellValue('J2', 'F.Ingreso')
            ->setCellValue('K2', 'Ds.Perm.')
            ->setCellValue('L2', 'RIB')
            ->setCellValue('M2', 'DZ o Sector MEX')


;

$sql="select *,sujetos.legajo as lega, nombre , hogares_motegreso.deno as mote, edadcalc(f_nacimiento,sujetosedad,sujetosmeses,sujetosactedad,curdate()) as eda,
case when ong>0 then 'CONVENIADO' else 'PROPIO' end as pert, dire.deno as diroper, concat(apellidos,', ',nombres) as apynom , f_nacimiento, tdz.deno as dz,
datediff(fecha_operacion,admi_alta) as dias, admi_alta,  
rib_anio, rib_numero, rib_reparticion, case when tipo_dispositivo in (1,2) then 'RED HOGARES' else 'PREINGRESO' end as circuito 
from altasybajas left join hogares_admision on vacante=idhogares_admision
 left join dispositivos on dispositivos.id=altasybajas.hogar 
 left join sujetos on altasybajas.legajo=sujetos.legajo
 left join tablas hogares_motegreso on hogares_motegreso.valo=admi_mote and hogares_motegreso.tipo='HOMOE'
 left join tablas dire on dire.tipo='DIOP' and dire.valo=direccion_operativa 
 left join tablas tdz on tdz.tipo='CM' and tdz.valo=defensoria_zonal 
 where tipo_dispositivo in (1,2,11) and operacion='B' and fecha_operacion between ".$desde." and ".$hasta." order by nombre,apynom";
 $reg=registros($sql);
 $fl=2;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('B'.ltrim((string)$fl), $r["pert"])
            ->setCellValue('C'.ltrim((string)$fl), $r["diroper"])
            ->setCellValue('D'.ltrim((string)$fl), $r["circuito"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), ffec($r["fecha_operacion"]))
            ->setCellValue('I'.ltrim((string)$fl), $r["mote"])
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["admi_alta"]))
            ->setCellValue('K'.ltrim((string)$fl), $r["dias"])
            ->setCellValue('L'.ltrim((string)$fl), rib2($r))
            ->setCellValue('M'.ltrim((string)$fl), $r["dz"])
;
};
$sql="select count(*) as egresos, sum(case when tipo_dispositivo in (1,2) then 1 else 0 end) as red_hogares,
sum(case when tipo_dispositivo = 11 then 1 else 0 end) as preingreso,
sum(case when not ong>0 then 1 else 0 end) as propios,
sum(case when ong>0 then 1 else 0 end) as conveniados,
sum(case when admi_mote<>4 then 1 else 0 end) as sistema,
sum(case when admi_mote=4 then 1 else 0 end) as cambios
from altasybajas left join hogares_admision on vacante=idhogares_admision
 left join dispositivos on dispositivos.id=altasybajas.hogar 
 left join sujetos on altasybajas.legajo=sujetos.legajo
 where tipo_dispositivo in (1,2,11) and operacion='B' and fecha_operacion between ".$desde." and ".$hasta;

 $r=un_registro($sql);
 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");

$spreadsheet->setActiveSheetIndex(3)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl),"Egresos")
            ->setCellValue('B'.ltrim((string)$fl),intval($r["egresos"]));

 $fl=$fl+2;

 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Red de Hogares")
  	    ->setCellValue('B'.ltrim((string)$fl),$r["red_hogares"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Pre Ingreso")
            ->setCellValue('B'.ltrim((string)$fl), $r["preingreso"]);
 $fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Propios")
            ->setCellValue('B'.ltrim((string)$fl), $r["propios"]);

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Conveniados")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["conveniados"]));
 $fl=$fl+2;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Egr.del Sistema")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["sistema"]));

 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(3)
            ->setCellValue('A'.ltrim((string)$fl), "Cambios Dispositivo")
            ->setCellValue('B'.ltrim((string)$fl), intval($r["cambios"]));


for($col='A'; $col<= 'M'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(3)->getStyle('A1:M2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

// VACANTES EN DISPOSITIVOS
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A1', 'NNYA EN DISPOSITIVOS C/VACANTE EN PROCESO')
            ->setCellValue('B1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A2', 'F.Pedido')
	    ->setCellValue('B2', 'Solicitante')
            ->setCellValue('C2', 'SSHabitacional')
            ->setCellValue('D2', 'SSH Detalle')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'F.Nacimiento')
            ->setCellValue('G2', 'Edad')
            ->setCellValue('H2', 'Equipo ADM')
            ->setCellValue('I2', 'Estado Gest')
            ->setCellValue('J2', 'F.Estado')
            ->setCellValue('K2', 'Dispositivo')
            ->setCellValue('L2', 'RIB')
            ->setCellValue('M2', 'GESTIONES')

;

$sql="select hogares_admision.*, sujetos.legajo , concat(apellidos,', ',nombres) as apynom, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,".$hasta.") as edad_calc,
hogares_ca.deno as dcate, case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end)
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) end end as deriv ,  
  hogares_proc.deno as proc,admi_proc_cual as proc_deta,  etapas.deno as eta, fecha_etapa, rib_anio, rib_numero, rib_reparticion,nombre, f_nacimiento   
   from hogares_admision  
   left join sujetos on admi_legajo=sujetos.legajo 
   left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
   left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 
   left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
   left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH'  
   left join tablas etapas on etapa=etapas.valo and etapas.tipo='ADEV'  
   left join dispositivos on admi_hogar=dispositivos.id 	
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and hogares_proc.deno in ('Preingreso','Hogar') order by apynom";
 $reg=registros($sql);
 $fl=2;
 $vacantes=0;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $vacantes=$vacantes+1;
 $spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["admi_fped"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["deriv"])
            ->setCellValue('C'.ltrim((string)$fl), $r["proc"])
            ->setCellValue('D'.ltrim((string)$fl), $r["proc_deta"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), ffec($r["f_nacimiento"]))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), $r["dcate"])
            ->setCellValue('I'.ltrim((string)$fl), $r["eta"])
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["fecha_etapa"]))
            ->setCellValue('K'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('L'.ltrim((string)$fl), rib2($r));
$ges=registros("select inter_fecha,inter_obse from intervenciones where inter_tipo=29 and inter_fecha between ".$desde." and ".$hasta." and inter_legajo=".$r["admi_legajo"]." order by inter_fecha");
  while($g= mysqli_fetch_assoc($ges)){
    $spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('M'.ltrim((string)$fl), ffec($g["inter_fecha"])." ".$g["inter_obse"]);
    $fl=$fl+1;

  };

};
 
$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");
$spreadsheet->setActiveSheetIndex(4)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), "Vacantes")
            ->setCellValue('B'.ltrim((string)$fl), $vacantes)
;

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), "POR SSH");
$spreadsheet->setActiveSheetIndex(4)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select deno, count(*) as cant from hogares_admision  left join tablas on admi_proc=valo and tipo='HOSSH'  
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and deno in('Hogar','Preingreso') group by deno order by deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), "POR EQUIPO ADMISION");
$spreadsheet->setActiveSheetIndex(4)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select cate.
deno, count(*) as cant from hogares_admision  left join tablas cate on admi_cate=cate.valo and cate.tipo='ADCAT'  
 left join tablas ssh on ssh.tipo='HOSSH' and ssh.valo=admi_proc
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and ssh.deno in ('Preingreso','Hogar') group by cate.deno order by cate.deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), "POR ETAPA");
$spreadsheet->setActiveSheetIndex(4)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select tet.deno, count(*) as cant from hogares_admision  left join tablas tet on etapa=tet.valo and tet.tipo='ADEV'  
 left join tablas ssh on ssh.tipo='HOSSH' and ssh.valo=admi_proc
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and ssh.deno in('Preingreso','Hogar') group by tet.deno order by tet.deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(4)
            ->setCellValue('A'.ltrim((string)$fl), si($r["deno"]=="","SIN DATO",$r["deno"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

for($col='A'; $col<= 'M'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(4)->getStyle('A1:M2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

// VACANTES NO en DISPOSITIVOS
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A1', 'NNYA NO EN DISPOSITIVOS C/VACANTE EN PROCESO')
            ->setCellValue('B1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A2', 'F.Pedido')
	    ->setCellValue('B2', 'Solicitante')
            ->setCellValue('C2', 'SSHabitacional')
            ->setCellValue('D2', 'SSH Detalle')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'F.Nacimiento')
            ->setCellValue('G2', 'Edad a Fecha')
            ->setCellValue('H2', 'Equipo ADM')
            ->setCellValue('I2', 'Estado Gest')
            ->setCellValue('J2', 'F.Estado')
            ->setCellValue('K2', 'Dispositivo')
            ->setCellValue('L2', 'RIB')
	    ->setCellValue('M2', 'GESTIONES')
;

$sql="select hogares_admision.*, sujetos.legajo , concat(apellidos,', ',nombres) as apynom, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,".$hasta.") as edad_calc,
hogares_ca.deno as dcate, case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end)
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) end end as deriv ,  
  hogares_proc.deno as proc,admi_proc_cual as proc_deta,  etapas.deno as eta, fecha_etapa, rib_anio, rib_numero, rib_reparticion,nombre, f_nacimiento   
   from hogares_admision  
   left join sujetos on admi_legajo=sujetos.legajo 
   left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
   left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 
   left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
   left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH'  
   left join tablas etapas on etapa=etapas.valo and etapas.tipo='ADEV'  
   left join dispositivos on admi_hogar=dispositivos.id 	
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and hogares_proc.deno not in ('Preingreso','Hogar') order by apynom";
 $reg=registros($sql);
 $fl=2;
 $vacantes=0;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $vacantes=$vacantes+1;
 $spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["admi_fped"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["deriv"])
            ->setCellValue('C'.ltrim((string)$fl), $r["proc"])
            ->setCellValue('D'.ltrim((string)$fl), $r["proc_deta"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), ffec($r["fecha_nacimiento"]))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), $r["dcate"])
            ->setCellValue('I'.ltrim((string)$fl), $r["eta"])
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["fecha_etapa"]))
            ->setCellValue('K'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('L'.ltrim((string)$fl), rib2($r));
  $ges=registros("select inter_fecha,inter_obse from intervenciones where inter_tipo=29 and inter_fecha between ".$desde." and ".$hasta." and inter_legajo=".$r["admi_legajo"]." order by inter_fecha");
  while($g= mysqli_fetch_assoc($ges)){
    $spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('M'.ltrim((string)$fl), ffec($g["inter_fecha"])." ".$g["inter_obse"]);
    $fl=$fl+1;

  };

};
$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");
$spreadsheet->setActiveSheetIndex(5)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), "Vacantes")
            ->setCellValue('B'.ltrim((string)$fl), $vacantes)
;


$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), "POR SSH");
$spreadsheet->setActiveSheetIndex(5)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select deno, count(*) as cant from hogares_admision  left join tablas on admi_proc=valo and tipo='HOSSH'  
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and deno not in ('Preingreso','Hogar') group by deno order by deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), "POR EQUIPO ADMISION");
$spreadsheet->setActiveSheetIndex(5)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


$sql="select cat.deno, count(*) as cant from hogares_admision  left join tablas cat on admi_cate=cat.valo and cat.tipo='ADCAT'  
 left join tablas ssh on ssh.tipo='HOSSH' and ssh.valo=admi_proc 
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and ssh.deno not in ('Preingreso','Hogar') group by cat.deno order by cat.deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), $r["deno"])
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), "POR ETAPA");
$spreadsheet->setActiveSheetIndex(5)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$sql="select tet.deno, count(*) as cant from hogares_admision  left join tablas tet on etapa=tet.valo and tet.tipo='ADEV' 
  left join tablas ssh on ssh.tipo='HOSSH' and ssh.valo=admi_proc 
   where (admi_fderiv is null or admi_fderiv>".$hasta.") and admi_fped<=".$hasta." and (admi_alta is null or admi_alta>".$hasta.
   ") and (admi_susp is null or admi_susp>".$hasta.") and ssh.deno not in ('Preingreso','Hogar') group by tet.deno order by tet.deno";
 $reg=registros($sql);
 while ($r = mysqli_fetch_assoc($reg)) {
 	$fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(5)
            ->setCellValue('A'.ltrim((string)$fl), si($r["deno"]=="","SIN DATO",$r["deno"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["cant"]);
 };

for($col='A'; $col<= 'M'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(5)->getStyle('A1:M2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


// ADMISION ASIGNADAS
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A1', 'VACANTES ASIGNADAS')
            ->setCellValue('B1', 'del '.$_GET["desde"])
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A2', 'F.Pedido')
	    ->setCellValue('B2', 'Solicitante')
            ->setCellValue('C2', 'SSHabitacional')
            ->setCellValue('D2', 'SSH Detalle')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'RIB')
            ->setCellValue('G2', 'Edad a Fecha')
            ->setCellValue('H2', 'Equipo ADM')
            ->setCellValue('I2', 'Fecha Asign')
            ->setCellValue('J2', 'Fecha Ingreso')
            ->setCellValue('K2', 'Dispositivo')
            ->setCellValue('L2', 'Ds.h/Asign.')
;

$sql="select hogares_admision.*, sujetos.legajo , concat(apellidos,', ',nombres) as apynom, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,".$hasta.") as edad_calc,
hogares_ca.deno as dcate, case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end)
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) end end as deriv ,  
  hogares_proc.deno as proc,admi_proc_cual as proc_deta, rib_anio, rib_numero, rib_reparticion,nombre, datediff(admi_fderiv,admi_fped) as reso    
   from hogares_admision  
   left join sujetos on admi_legajo=sujetos.legajo 
   left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
   left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 
   left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
   left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH'  
   left join dispositivos on admi_hogar=dispositivos.id 	
   where (admi_fderiv between ".$desde." and ".$hasta.")  order by apynom";
 $reg=registros($sql);
 $fl=2;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["admi_fped"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["deriv"])
            ->setCellValue('C'.ltrim((string)$fl), $r["proc"])
            ->setCellValue('D'.ltrim((string)$fl), $r["proc_deta"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), rib2($r))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), $r["dcate"])
            ->setCellValue('I'.ltrim((string)$fl), ffec($r["admi_fderiv"]))
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["admi_alta"]))
            ->setCellValue('K'.ltrim((string)$fl), $r["nombre"])
            ->setCellValue('L'.ltrim((string)$fl), $r["reso"])
;
};
$sql="select count(*) as total, sum(case when datediff(admi_fderiv,admi_fped)<=30 then 1 else 0 end) as h30,
sum(case when datediff(admi_fderiv,admi_fped) between 31 and 90 then 1 else 0 end) as h90,
sum(case when datediff(admi_fderiv,admi_fped) > 90 then 1 else 0 end) as hmas,
sum(case when admi_alta is null or admi_alta>".$hasta." then 1 else 0 end) as sinalta  
   from hogares_admision     where admi_fderiv between ".$desde." and ".$hasta;
 $r=un_registro($sql);
$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");
$spreadsheet->setActiveSheetIndex(6)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "Asignaciones")
            ->setCellValue('B'.ltrim((string)$fl), $r["total"]);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "h/30 ds")
            ->setCellValue('B'.ltrim((string)$fl), $r["h30"]);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "e/31 y 90 ds")
            ->setCellValue('B'.ltrim((string)$fl), $r["h90"]);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "91 ds o +")
            ->setCellValue('B'.ltrim((string)$fl), $r["hmas"]);

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(6)
            ->setCellValue('A'.ltrim((string)$fl), "Sin alta a fecha")
            ->setCellValue('B'.ltrim((string)$fl), $r["sinalta"]);




for($col='A'; $col<= 'L'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(6)->getStyle('A1:L2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

// ADMISION SUSPENDIDAS
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A1', 'PEDIDOS SUSPENDIDOS')
            ->setCellValue('B1', 'del '.$_GET["desde"])
            ->setCellValue('C1', 'al '.$_GET["hasta"]);
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A2', 'F.Pedido')
	    ->setCellValue('B2', 'Solicitante')
            ->setCellValue('C2', 'SSHabitacional')
            ->setCellValue('D2', 'SSH Detalle')
            ->setCellValue('E2', 'Apellido y Nombre')
            ->setCellValue('F2', 'RIB')
            ->setCellValue('G2', 'Edad a Fecha')
            ->setCellValue('H2', 'Equipo ADM')
            ->setCellValue('I2', 'Fecha Asign')
            ->setCellValue('J2', 'Fecha Susp.')
            ->setCellValue('K2', 'Motivo')
            ->setCellValue('L2', 'Mot Detalle')
            ->setCellValue('M2', 'Ds.h/Susp.')
;

$sql="select hogares_admision.*, sujetos.legajo , concat(apellidos,', ',nombres) as apynom, edadcalc(f_nacimiento,sujetosEdad,SujetosMeses,SujetosActEdad,".$hasta.") as edad_calc,
hogares_ca.deno as dcate, case when admi_deriv=1 then concat('JUZGADO ',admi_deriv_cual) else case when admi_deriv=4 and admi_deriv_sector is not null then 
 concat(case when left(hogares_dz.deno,2)='DZ' then concat(hogares_dz.deno,'-') else '' end,hogares_dz.info,'-',case when admi_deriv_cual is null then '' else admi_deriv_cual end)
else  concat(hogares_de.deno,' ',case when admi_deriv_cual is null then '' else admi_deriv_cual end) end end as deriv ,  
  hogares_proc.deno as proc,admi_proc_cual as proc_deta, rib_anio, rib_numero, rib_reparticion,nombre, datediff(admi_susp,admi_fped) as reso,
  motsu.deno as motivo     
   from hogares_admision  
   left join sujetos on admi_legajo=sujetos.legajo 
   left join tablas hogares_de on admi_deriv=hogares_de.valo and hogares_de.tipo='ADDER' 
   left join tablas hogares_dz on admi_deriv_sector=hogares_dz.valo and hogares_dz.tipo='CM' 
   left join tablas hogares_ca on admi_cate=hogares_ca.valo and hogares_ca.tipo='ADCAT' 
   left join tablas hogares_proc on admi_proc=hogares_proc.valo and hogares_proc.tipo='HOSSH' 
   left join tablas motsu on motsu.tipo='ADMSU' and admi_motivo_suspension=motsu.valo 
   left join dispositivos on admi_hogar=dispositivos.id 	
   where (admi_susp between ".$desde." and ".$hasta.")  order by apynom";
 $reg=registros($sql);
 $fl=2;
 while ($r = mysqli_fetch_assoc($reg)) {
 $fl=$fl+1;
 $spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["admi_fped"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["deriv"])
            ->setCellValue('C'.ltrim((string)$fl), $r["proc"])
            ->setCellValue('D'.ltrim((string)$fl), $r["proc_deta"])
            ->setCellValue('E'.ltrim((string)$fl), $r["apynom"])
            ->setCellValue('F'.ltrim((string)$fl), rib2($r))
            ->setCellValue('G'.ltrim((string)$fl), $r["eda"])
            ->setCellValue('H'.ltrim((string)$fl), $r["dcate"])
            ->setCellValue('I'.ltrim((string)$fl), ffec($r["admi_fderiv"]))
            ->setCellValue('J'.ltrim((string)$fl), ffec($r["admi_susp"]))
            ->setCellValue('K'.ltrim((string)$fl), $r["motivo"])
	    ->setCellValue('L'.ltrim((string)$fl), $r["admi_mots"])
            ->setCellValue('M'.ltrim((string)$fl), $r["reso"])
;
};

$sql="select count(*) as total, sum(case when admi_fderiv is null then 1 else 0 end) as sderiv,
sum(case when admi_fderiv is not null then 1 else 0 end) as cderiv 
   from hogares_admision     where admi_susp between ".$desde." and ".$hasta;
 $r=un_registro($sql);
$fl=$fl+2;
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A'.ltrim((string)$fl), "RESUMEN");
$spreadsheet->setActiveSheetIndex(7)->getStyle('A'.ltrim((string)$fl).':'.'A'.ltrim((string)$fl))->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A'.ltrim((string)$fl), "Suspensiones")
            ->setCellValue('B'.ltrim((string)$fl), $r["total"]);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A'.ltrim((string)$fl), "s/derivar")
            ->setCellValue('B'.ltrim((string)$fl), $r["sderiv"]);
$fl=$fl+1;
$spreadsheet->setActiveSheetIndex(7)
            ->setCellValue('A'.ltrim((string)$fl), "derivados")
            ->setCellValue('B'.ltrim((string)$fl), $r["cderiv"]);


for($col='A'; $col< 'L'; $col++){
	ajusta($col);
};
ajusta("M");

$spreadsheet->setActiveSheetIndex(7)->getStyle('A1:M2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');



//  DATOS DE EMISION DEL REPORTE
  $spreadsheet->setActiveSheetIndex(8)
	->setCellValue('A1',"Fecha Desde")
        ->setCellValue('B1',$_GET["desde"])
	->setCellValue('A2',"Fecha Hasta")
        ->setCellValue('B2',$_GET["hasta"])
	->setCellValue('A3',"Emitido el")
	->setCellValue('B3',$_SESSION["DiaHoy"])
	->setCellValue('A4',"Usuario")
	->setCellValue('B4',$_SESSION["glusua"])
;



for($col='A'; $col<= 'B'; $col++){
	ajusta($col);
};

$spreadsheet->setActiveSheetIndex(0);

$filename = 'DGSAP-semanal.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

function ajusta($r){
global $spreadsheet;
$spreadsheet->getActiveSheet()->getColumnDimension($r)->setAutoSize(true);
}
?>
           