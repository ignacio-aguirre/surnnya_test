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
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Intervenciones PFVFyC Desde el '.$_GET["desde"]." al ".$_GET["hasta"])
            ->setCellValue('A2', 'Fecha Ingreso')
            ->setCellValue('B2', 'Derivante')
            ->setCellValue('C2', 'Juzgado Interviniente')
            ->setCellValue('D2', 'Expediente')
	    ->setCellValue('E2', 'Legajo')
            ->setCellValue('F2', 'Grupo Familiar')
            ->setCellValue('G2', 'Int.Previas')
            ->setCellValue('H2', 'NNYA')
            ->setCellValue('I2', 'NNYA+17')
            ->setCellValue('J2', 'NNYA S/D Edad')
            ->setCellValue('K2', 'Adultos Convivientes')
            ->setCellValue('L2', 'Adultos No Convivientes')
            ->setCellValue('M2', 'Domicilio')
            ->setCellValue('N2', 'P/Asignar')
            ->setCellValue('O2', utf8_encode('Asignación'))
            ->setCellValue('P2', 'Informe/CCOO')
            ->setCellValue('Q2', 'Centro Zonal')
            ->setCellValue('R2', utf8_encode('Mot.Intervención 1'))
            ->setCellValue('S2', utf8_encode('Mot.Intervención 2'))
            ->setCellValue('T2', utf8_encode('Mot.Intervención 3'))
            ->setCellValue('U2', utf8_encode('Mot.Intervención 4'))
            ->setCellValue('V2', 'Profes./Oper.Resp.Seguimiento')
            ->setCellValue('W2', 'Fecha Cese')
            ->setCellValue('X2', 'Motivo Cese')
            ->setCellValue('Y2', utf8_encode('Duración Días'))
            ->setCellValue('Z2', utf8_encode('Estado Intervención'))
            ->setCellValue('AA2', utf8_encode('Estado Solicitud'))
	    ->setCellValue('AB2', 'Fecha Rechazo')
	    ->setCellValue('AC2', utf8_encode('Fecha Articulación'))
  ;
  $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:AC2')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');

   $sql="select fv_familias.*,fv_participaciones.*,sectores.denominacion, datediff(case when fecha_baja is null then curdate() else fecha_baja end,fecha_asignacion) as dias, tderi.info, tmi1.deno as mint1, tmi2.deno as mint2, tmi3.deno as mint3, tmi4.deno as mint4, tmba.deno as mbaja, 
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.")  and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$hasta.")<=17) as nnya,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.")  and edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad,".$hasta.")>17) as mayo,
  (select count(*) from fv_familias_miembros left join sujetos on fv_familias_miembros.legajo=sujetos.legajo 
   where familia=idfv_familias  and fv_familias_miembros.fecha_alta<=".$hasta." and (fv_familias_miembros.fecha_baja is null or fv_familias_miembros.fecha_baja>".$desde.")  and f_nacimiento is null and sujetosedad is null) as sded,
  estado_sol(".$desde.",".$hasta.", fecha_articulacion,fecha_rechazo,fecha_asignacion,fecha_baja,fecha_ingreso,fecha_cancelacion) as estado
  from fv_participaciones left join fv_familias on familia=idfv_familias left join sectores on efector=sectores.id 
  left join tablas tderi on tderi.tipo='CM' and tderi.valo=derivante
  left join tablas tmi1 on tmi1.tipo='FVMA' and tmi1.valo=m_asig1
  left join tablas tmi2 on tmi2.tipo='FVMA' and tmi2.valo=m_asig2
  left join tablas tmi3 on tmi3.tipo='FVMA' and tmi3.valo=m_asig3
  left join tablas tmi4 on tmi4.tipo='FVMA' and tmi4.valo=m_asig4
  left join tablas tmba on tmba.tipo='FVMB' and tmba.valo=motivo_baja
  where estado_sol(".$desde.",".$hasta.", fecha_articulacion,fecha_rechazo,fecha_asignacion,fecha_baja,fecha_ingreso,fecha_cancelacion)<>'NUL' 
  order by fecha_ingreso";
   $reg=registros($sql);
   $fami=0;
   $fl=2;
   while($r=mysqli_fetch_assoc($reg)){
        $fl=$fl+1;
        $nnya=intval($r["nnya"]);
        $mayo=intval($r["mayo"]);
        $sded=intval($r["sded"]);
        $adul=intval($r["adultos_convivientes"]);
        $adnc=intval($r["adultos_noconvivientes"]);
    	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), ffec($r["fecha_ingreso"]))
            ->setCellValue('B'.ltrim((string)$fl), $r["info"])
            ->setCellValue('C'.ltrim((string)$fl), $r["juzgado"])
            ->setCellValue('D'.ltrim((string)$fl), $r["expediente"])
            ->setCellValue('E'.ltrim((string)$fl), $r["legajomanual"])
            ->setCellValue('F'.ltrim((string)$fl), $r["descripcion"])
            ->setCellValue('G'.ltrim((string)$fl), si($r["intervenciones_previas"]=="1","SI","NO"))
 	    ->setCellValue('H'.ltrim((string)$fl), $nnya)	
 	    ->setCellValue('I'.ltrim((string)$fl), $mayo)	
 	    ->setCellValue('J'.ltrim((string)$fl), $sded)	
 	    ->setCellValue('K'.ltrim((string)$fl), $adul)	
 	    ->setCellValue('L'.ltrim((string)$fl), $adnc)	
            ->setCellValue('M'.ltrim((string)$fl), $r["domicilio"])
            ->setCellValue('N'.ltrim((string)$fl), ffec($r["fecha_condiciones"]))
 	    ->setCellValue('O'.ltrim((string)$fl), ffec($r["fecha_asignacion"]))
 	    ->setCellValue('P'.ltrim((string)$fl), $r["ccoo_asignacion"])
            ->setCellValue('Q'.ltrim((string)$fl), $r["denominacion"])
            ->setCellValue('R'.ltrim((string)$fl), $r["mint1"])
            ->setCellValue('S'.ltrim((string)$fl), $r["mint2"])
            ->setCellValue('T'.ltrim((string)$fl), $r["mint3"])
            ->setCellValue('U'.ltrim((string)$fl), $r["mint4"])
            ->setCellValue('V'.ltrim((string)$fl), $r["profesionales"])
 	    ->setCellValue('W'.ltrim((string)$fl), ffec($r["fecha_baja"]))
 	    ->setCellValue('X'.ltrim((string)$fl), $r["mbaja"])
            ->setCellValue('Y'.ltrim((string)$fl), $r["dias"])	
 	    ->setCellValue('Z'.ltrim((string)$fl), si($r["estado"]!="INTERVENCION" && $r["estado"]!="CESE","",si($r["estado"]=="INTERVENCION","ABIERTA","CERRADA")))
 	    ->setCellValue('AA'.ltrim((string)$fl),$r["estado"])
	    ->setCellValue('AB'.ltrim((string)$fl), ffec($r["fecha_rechazo"]))
	    ->setCellValue('AC'.ltrim((string)$fl), ffec($r["fecha_articulacion"]))
      
 	    ;
        $fami=$fami+1;
  };
 $fl=$fl+1;
	$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.ltrim((string)$fl), $fami." Solicitudes")
 	    ->setCellValue('H'.ltrim((string)$fl), "=sum(H3:H".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('I'.ltrim((string)$fl), "=sum(I3:I".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('J'.ltrim((string)$fl), "=sum(J3:J".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('K'.ltrim((string)$fl), "=sum(K3:K".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('L'.ltrim((string)$fl), "=sum(L3:L".ltrim((string) ($fl-1)).")")	
 	    ->setCellValue('Y'.ltrim((string)$fl), "=average(Y2:Y".ltrim((string) ($fl-1)).")")	
 	    ;	
          
$fl=$fl+2;
  $spreadsheet->setActiveSheetIndex(0)
	->setCellValue('A'.ltrim((string)$fl),"Emitido el ".$_SESSION["DiaHoy"])
	->setCellValue('A'.ltrim((string)($fl+1)),"Usuario ".$_SESSION["glusua"]);
	 



for($col='A'; $col<= 'Z'; $col++){
	ajusta($col);
};
ajusta('AA');
ajusta('AB');
ajusta('AC');


$spreadsheet->getActiveSheet()->setTitle('FV-intervenciones');
$spreadsheet->setActiveSheetIndex(0);
$filename = 'FV-intervenciones.xlsx';

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
};
?>
           