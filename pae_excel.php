<?php
error_reporting(E_STRICT);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include("Funciones.php");
session_start();

$spreadsheet = new Spreadsheet();


$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A1', 'RIB')
    ->setCellValue('B1', utf8_encode('Acción AMB'))
    ->setCellValue('C1', 'Etapa')
    ->setCellValue('D1', 'Apellidos')
    ->setCellValue('E1', 'Nombres')
    ->setCellValue('F1', utf8_encode('Documentación'))
    ->setCellValue('G1', 'DNI')
    ->setCellValue('H1', 'CUIL/CUIT')
    ->setCellValue('I1', 'Fecha_Nac')
    ->setCellValue('J1', 'Edad')
    ->setCellValue('K1', 'Nacionalidad')
    ->setCellValue('L1', 'Provincia nacimiento')
    ->setCellValue('M1', 'Provincia')
    ->setCellValue('N1', 'Departamento')
    ->setCellValue('O1', 'Localidad')
    ->setCellValue('P1', utf8_encode('Condición domiciliaria'))
    ->setCellValue('Q1', 'Calle y altura')
    ->setCellValue('R1', utf8_encode('Género'))
    ->setCellValue('S1', 'Sexo s/DNI')
    ->setCellValue('T1', 'Escolarizado')
    ->setCellValue('U1', 'Nivel educativo')
    ->setCellValue('V1', 'Firma del consentimiento informado')
    ->setCellValue('W1', 'Observaciones')
    ->setCellValue('X1', 'Fecha de cambio de etapa')
    ->setCellValue('Y1', 'Fecha de baja')
    ->setCellValue('Z1', 'Discapacidad')
    ->setCellValue('AA1', 'Trabaja')
    ->setCellValue('AB1', utf8_encode('Condición laboral'))
    ->setCellValue('AC1', utf8_encode('Laboral Especificar'))
    ->setCellValue('AD1', utf8_encode('Teléfono celular'))
    ->setCellValue('AE1', utf8_encode('Correo electrónico'))
    ->setCellValue('AF1', utf8_encode('Fec egreso último dispositivo'))
    ->setCellValue('AG1', utf8_encode('Nombre dispositivo cuidado'))
    ->setCellValue('AH1', utf8_encode('Tipo gestión'))
    ->setCellValue('AI1', utf8_encode('Proyecto'))
    ->setCellValue('AJ1', utf8_encode('Autovalimiento'))
    ->setCellValue('AP1', utf8_encode('Fec aplicación última MEX'))
    ->setCellValue('AQ1', utf8_encode('Nro. acto administrativo'))
    ->setCellValue('AR1', utf8_encode('Motivo aplicación última MEX'))
    ->setCellValue('AS1', utf8_encode('Días transcurridos (completar)'))
    ->setCellValue('AT1', utf8_encode('Organismo aplicación última MEX'))
    ->setCellValue('AU1', utf8_encode('Organismo control de legalidad'))
    ->setCellValue('AV1', 'Apellido y nombre del referente')
    ->setCellValue('AW1', 'Dinero que destina a la vivenda')
    ->setCellValue('AX1', 'AUH')
    ->setCellValue('AY1', utf8_encode('Pensión por discapacidad'))
    ->setCellValue('AZ1', 'Otras asignaciones')
    ->setCellValue('BA1', 'Ingresos por trabajo')
    ->setCellValue('BB1', 'Comentarios IxT')
    ->setCellValue('BC1', 'Hijxs')
    ->setCellValue('BD1', 'Representante legal')
    ->setCellValue('BE1', 'Nombre')
    ->setCellValue('BF1', 'DNI')
    ->setCellValue('BG1', 'Sexo s/DNI');


$spreadsheet->setActiveSheetIndex(0)->getStyle('A1:BG1')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('E0ECF8');


  
$sql = "select pae_nomina.*,pae_nomina.id as idrib, sujetos_pae.*, sujetos.legajo , sujetos.apellidos, sujetos.nombres, sujetos.telefonos, sujetos.email, 
edadcalc(f_nacimiento,sujetosedad,0,sujetosactedad," . fget("al") . ") as edad,
 sujetosdni, cuil, f_nacimiento, 
rib_anio,rib_numero,rib_reparticion, sexo, genero, paises.descripcion as nacionalidad,tbtd.deno, tbne.deno as nives ,idg.deno as genero ,
jm.deno as jmod, juzgado_numero, py.deno as proyecto, auva.deno as autoval  
from pae_nomina
   left join sujetos on pae_nomina.legajo=sujetos.legajo 
   left join sujetos_pae on pae_nomina.legajo=sujetos_pae.legajo 
   left join sujetos_juridicos on sujetos.legajo=sujetos_juridicos.legajo
   left join paises on nacionalidad=idpaises
   left join tablas as tbtd on tbtd.tipo='TD' and tipodni=tbtd.valo
   left join tablas as tbne on tbne.tipo='NIVES' and nivel_educativo=tbne.valo
   left join tablas idg on idg.tipo='GENER' and idg.valo=genero 
   left join tablas jm on jm.tipo='TJ' and jm.valo=juzgado_modalidad
   left join tablas py on py.tipo='PAEP' and py.valo=proyecto 	
   left join tablas auva on auva.tipo='AUVA' and auva.valo=autovalimiento 
   order by idrib";

$reg = registros($sql);
$nnya = 0;
$fl = 1;

while ($r = mysqli_fetch_assoc($reg)) {

    $hoga = un_registro("SELECT dispositivos.nombre, conveniado,ong,admi_baja FROM hogares_admision
            left join dispositivos on dispositivos.id=admi_hogar 
       	WHERE tipo_dispositivo<>12 and admi_alta is not null and  admi_baja is null and admi_legajo=" . $r["legajo"] . " order by admi_alta desc limit 1");

    if (is_null($hoga)) {
        
        $hoga = un_registro("SELECT dispositivos.nombre, conveniado,ong,admi_baja FROM hogares_admision
            	left join dispositivos on dispositivos.id=admi_hogar 
       		WHERE tipo_dispositivo<>12 and admi_alta is not null and  admi_baja is not null and admi_legajo=" . $r["legajo"] . " order by admi_baja desc limit 1");
    }

    $tges = "";
    $tges = si($hoga["conveniado"] == 1 || $hoga["ong"] > 0, "Mixto", "Público");

    $hegr = un_campo("SELECT dispositivos.nombre FROM hogares_admision
            	left join dispositivos on dispositivos.id=admi_hogar 
       		WHERE tipo_dispositivo=12 and admi_alta is not null and  admi_baja is not null and admi_legajo=" . $r["legajo"] . " order by admi_baja desc limit 1");

    if ($hegr != "") {
        $r["proyecto"] = $hegr;
    } else if ($hoga["nombre"] != "" && ffec($hoga["admi_baja"]) == "") {
        $r["proyecto"] = "Convivencial";
    }

    $ref1 = "";
    $ref2 = "";

    if ($r["referente_1"] > "0") {
        $ref1 = un_registro("select concat(apellido,', ',nombre) as apyn,cuil from usuarios where id=" . $r["referente_1"]);
        $ref1_dni = substr($ref1["cuil"], 2, 8);
        $ref1_sexo = "";
        $ref1_apyn = $ref1["apyn"];

        if (substr($ref1["cuil"], 0, 2) == "20" || substr($ref1["cuil"], 0, 2) == "23" && substr($ref1["cuil"], -1) == "9") {
            $ref1_sexo = "Masculino";
        }

        if (substr($ref1["cuil"], 0, 2) == "27" || substr($ref1["cuil"], 0, 2) == "23" && substr($ref1["cuil"], -1) == "4") {
            $ref1_sexo = "Femenino";
        }

    } else {
        $ref1_dni = "";
        $ref1_sexo = "";
        $ref1_apyn = "";

        if ($r["referente_1"] == "-1") {
            $ref1_apyn = "GRUPAL";
        }
    }

    if ($r["referente_2"] > "0") {
        $ref2 = un_campo("select concat(apellido,', ',nombre) as apyn from usuarios where id=" . $r["referente_2"]);
    }

    $mex = un_registro("select * from sujetos_medidas where legajo=" . $r["legajo"] . " order by fecha desc limit 1");

    $fl = $fl + 1;
    $acci = accion(ffec($r["f_cons_inf"]), ffec($r["f_baja"]));

    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A' . ltrim((string)$fl), rib2($r))
        ->setCellValue('B' . ltrim((string)$fl), $acci)
        ->setCellValue('C' . ltrim((string)$fl), $r["etapa"])
        ->setCellValue('D' . ltrim((string)$fl), $r["apellidos"])
        ->setCellValue('E' . ltrim((string)$fl), $r["nombres"])
        ->setCellValue('F' . ltrim((string)$fl), si($r["documentacion"] == "DNI", "DNI", si(substr($r["documentacion"], 0, 1) == "C", "CI", "PA")))
        ->setCellValue('G' . ltrim((string)$fl), $r["sujetosdni"])
        ->setCellValue('H' . ltrim((string)$fl), cuil($r["cuil"]))
        ->setCellValue('I' . ltrim((string)$fl), ffec($r["f_nacimiento"]))
        ->setCellValue('J' . ltrim((string)$fl), $r["edad"])
        ->setCellValue('K' . ltrim((string)$fl), $r["nacionalidad"])
        ->setCellValue('L' . ltrim((string)$fl), utf8_encode($r["provincia_nacimiento"]))
        ->setCellValue('M' . ltrim((string)$fl), utf8_encode($r["provincia_domicilio"]))
        ->setCellValue('N' . ltrim((string)$fl), utf8_encode($r["partido_domicilio"]))
        ->setCellValue('O' . ltrim((string)$fl), utf8_encode($r["localidad_domicilio"]))
        ->setCellValue('P' . ltrim((string)$fl), $r["condicion_domicilio"])
        ->setCellValue('Q' . ltrim((string)$fl), utf8_encode($r["callenro_domicilio"]))
        ->setCellValue('R' . ltrim((string)$fl), $r["genero"])
        ->setCellValue('S' . ltrim((string)$fl), si($r["sexo"] == "M", "Masculino", si($r["sexo"] == "F", "Femenino", $r["sexo"])))
        ->setCellValue('T' . ltrim((string)$fl), si($r["escolarizado"] == 1, "SI", "NO"))
        ->setCellValue('U' . ltrim((string)$fl), $r["nives"])
        ->setCellValue('V' . ltrim((string)$fl), ffec($r["f_cons_inf"]))
        ->setCellValue('W' . ltrim((string)$fl), $r["observaciones"])
        ->setCellValue('X' . ltrim((string)$fl), ffec($r["f_cambio_etapa"]))
        ->setCellValue('Y' . ltrim((string)$fl), ffec($r["f_baja"]))
        ->setCellValue('Z' . ltrim((string)$fl), si($r["discapacidad"] == 1, "SI", "NO"))
        ->setCellValue('AA' . ltrim((string)$fl), si($r["trabaja"] == 1, "SI", "NO"))
        ->setCellValue('AB' . ltrim((string)$fl), $r["laboral_condiciones"])
        ->setCellValue('AC' . ltrim((string)$fl), $r["laboral_especificar"])
        ->setCellValue('AD' . ltrim((string)$fl), $r["telefonos"])
        ->setCellValue('AE' . ltrim((string)$fl), $r["email"])
        ->setCellValue('AF' . ltrim((string)$fl), ffec($hoga["admi_baja"]))
        ->setCellValue('AG' . ltrim((string)$fl), $hoga["nombre"])
        ->setCellValue('AH' . ltrim((string)$fl), utf8_encode($tges))
        ->setCellValue('AI' . ltrim((string)$fl), $r["proyecto"])
        ->setCellValue('AJ' . ltrim((string)$fl), $r["autoval"])
        ->setCellValue('AP' . ltrim((string)$fl), si(ffec($r["ultmex_fecha"]) == "", ffec($mex["fecha"]), ffec($r["ultmex_fecha"])))
        ->setCellValue('AQ' . ltrim((string)$fl), si($mex["acto_administrativo"] == "", $r["ultmex_nro"], $mex["acto_administrativo"]))
        ->setCellValue('AR' . ltrim((string)$fl), $r["ultmex_motivo"])
        ->setCellValue('AS' . ltrim((string)$fl), "0")
        ->setCellValue('AT' . ltrim((string)$fl), si(ffec($mex["fecha"]) == "", "", "CDNNYA"))
        ->setCellValue('AU' . ltrim((string)$fl), utf8_encode($r["jmod"] . " " . $r["juzgado_numero"]))
        ->setCellValue('AV' . ltrim((string)$fl), $ref1_apyn)
        ->setCellValue('AW' . ltrim((string)$fl), $r["dinero_vivienda"])
        ->setCellValue('AX' . ltrim((string)$fl), si($r["cobro_auh"] == "1", "SI", ""))
        ->setCellValue('AY' . ltrim((string)$fl), si($r["cobro_pension"] == "1", "SI", ""))
        ->setCellValue('AZ' . ltrim((string)$fl), si($r["cobro_otras"] == 1, utf8_encode($r["cobro_especificar"]), ""))
        ->setCellValue('BA' . ltrim((string)$fl), $r["laboral_dinero"])
        ->setCellValue('BB' . ltrim((string)$fl), $r["laboral_dinero_obs"])
        ->setCellValue('BC' . ltrim((string)$fl), si($r["hijos"] == "0", "NO", si($r["hijos"] == "4", "+ de 3", $r["hijos"])));

    $nnya = $nnya + 1;
    
}

$fl = $fl + 2;

$spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A' . ltrim((string)$fl), "Datos al " . $_GET["al"])
    ->setCellValue('A' . ltrim((string)($fl + 1)), "Emitido el " . $_SESSION["DiaHoy"])
    ->setCellValue('A' . ltrim((string)($fl + 2)), axel("Usuario " . $_SESSION["glusua"]));

for ($col= "A"; $col <= "Z"; $col++) {
    ajusta($col);
    ajusta("A".$col);
    ajusta("B".$col);
}

$spreadsheet->getActiveSheet()->setTitle('PAE Nomina');
$spreadsheet->setActiveSheetIndex(0);

$filename = 'PAENomina.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

function ajusta($r)
{
    global $spreadsheet;

    $spreadsheet->getActiveSheet()
        ->getColumnDimension($r)
        ->setAutoSize(true);
}

function accion($alta, $baja)
{
    $al = str_replace("'", "", fget("al"));
    $falta = str_replace("'", "", fsql($alta));
    $fbaja = str_replace("'", "", fsql($baja));

    if ($alta == "") {
        return "ERROR: SIN/F_CONS_INF";
    }

    if (substr($falta, 0, 6) <= substr($al, 0, 6)) {
        if ($baja == "") {
            return "ALTA";
        }

        if (substr($fbaja, 0, 6) > substr($al, 0, 6)) {
            return "ALTA";
        } else {
            return "BAJA";
        }
    } else {
        return "PROXIMA ALTA";
    }
}
?>