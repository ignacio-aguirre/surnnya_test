<?php

include("funciones.php");

session_start();

$tabla = $_GET["tipo"] ?? "";

/*
 * strpos() puede devolver 0, por eso debe compararse expresamente
 * con false.
 */
if (strpos($tabla, "EXCEL") === false) {
    echo "<table id='brow' class='table table-bordered table-condensed'>";
}


/* =========================================================
   LISTADO HTML DE INGRESOS
   ========================================================= */

if ($tabla === "INGRESOS") {

    $desde = fget("desde");
    $hasta = fget("hasta");

    echo "
        <tr class='bg-primary'>
            <th>Id</th>
            <th>Fecha</th>
            <th>Origen</th>
            <th>Observaciones</th>
            <th>Cant. Art.</th>
            <th>Acciones</th>
        </tr>
    ";

    $sql = "
        SELECT
            fecha,
            idingresos,
            origen,
            observaciones,
            (
                SELECT COUNT(*)
                FROM ingresos_articulos
                WHERE ingreso = idingresos
            ) AS cnt
        FROM ingresos
        WHERE fecha BETWEEN $desde AND $hasta
        ORDER BY fecha DESC, idingresos DESC
    ";

    $reg = registros($sql);

    while ($r = mysqli_fetch_assoc($reg)) {

        $id = $r["idingresos"];
        $fecha = ffec($r["fecha"]);
        $origen = morig($r["origen"]);
        $observaciones = htmlspecialchars(
            (string)($r["observaciones"] ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );
        $cantidad = $r["cnt"];

        echo "<tr>";

        echo "<td>" . $id . "</td>";
        echo "<td>" . $fecha . "</td>";
        echo "<td>" . $origen . "</td>";
        echo "<td>" . $observaciones . "</td>";
        echo "<td>" . $cantidad . "</td>";

        echo "
            <td>
                <img
                    src='imagenes/ver.svg'
                    height='20'
                    width='20'
                    alt='Ver'
                    onclick='ver(" . $id . ")'
                >
            </td>
        ";

        echo "</tr>";
    }

    echo "</table>";
}


/* =========================================================
   EXPORTACIÓN A EXCEL
   ========================================================= */

if ($tabla === "INGRESOS_EXCEL") {

    /*
     * Los mensajes de PHP no deben mezclarse con el archivo Excel.
     * Se registran, pero no se muestran en la descarga.
     */
    error_reporting(E_ALL);
    ini_set("display_errors", "0");

    require "../vendor/autoload.php";

    $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    $objPHPExcel
        ->getProperties()
        ->setCreator("Patrimonio")
        ->setTitle("Ingresos");

    $hoja = $objPHPExcel->getActiveSheet();

    $hoja
        ->setCellValue("A1", "Id")
        ->setCellValue("B1", "Fecha")
        ->setCellValue("C1", "Origen")
        ->setCellValue("D1", "Observaciones")
        ->setCellValue("E1", "Descripción")
        ->setCellValue("F1", "Cantidad");

    $sql = "
        SELECT
            ingresos.*,
            articulos.descripcion AS arti,
            ingresos_articulos.cantidad
        FROM ingresos_articulos
        LEFT JOIN ingresos
            ON ingreso = idingresos
        LEFT JOIN articulos
            ON articulo = idarticulos
        ORDER BY
            fecha DESC,
            idingresos DESC,
            idingresos_articulos
    ";

    $reg = registros($sql);

    $f = 2;

    while ($r = mysqli_fetch_assoc($reg)) {

        $hoja
            ->setCellValue("A" . $f, $r["idingresos"])
            ->setCellValue("B" . $f, ffec($r["fecha"]))
            ->setCellValue("C" . $f, morig($r["origen"]))
            ->setCellValue(
                "D" . $f,
                (string)($r["observaciones"] ?? "")
            )
            ->setCellValue(
                "E" . $f,
                (string)($r["arti"] ?? "")
            )
            ->setCellValue(
                "F" . $f,
                $r["cantidad"] ?? 0
            );

        $f++;
    }

    /*
     * Solo hay columnas utilizadas desde A hasta F.
     */
    foreach (range("A", "F") as $columna) {
        ajusta($objPHPExcel, $columna);
    }

    $hoja->setTitle("Ingresos");

    $objPHPExcel->setActiveSheetIndex(0);

    /*
     * Elimina cualquier salida previa que pudiera corromper
     * el archivo XLSX.
     */
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    $filename = "ingresos.xlsx";

    header(
        "Content-Type: " .
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    );

    header(
        'Content-Disposition: attachment; filename="' .
        $filename .
        '"'
    );

    header("Cache-Control: max-age=0");
    header("Expires: 0");
    header("Pragma: public");

    $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx(
        $objPHPExcel
    );

    $objWriter->save("php://output");

    $objPHPExcel->disconnectWorksheets();
    unset($objPHPExcel);

    exit;
}


/* =========================================================
   FUNCIONES
   ========================================================= */

function morig($origen): string
{
    if ($origen === "P") {
        return "Proveedor";
    }

    if ($origen === "D") {
        return "Otro Depo";
    }

    if ($origen === "E") {
        return "Dev. Efector";
    }

    return "";
}


function ajusta(
    \PhpOffice\PhpSpreadsheet\Spreadsheet $libro,
    string $columna
): void {
    $libro
        ->getActiveSheet()
        ->getColumnDimension($columna)
        ->setAutoSize(true);
}