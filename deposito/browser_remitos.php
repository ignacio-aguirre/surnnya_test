<?php

include("funciones.php");

session_start();

$tabla = $_GET["tipo"] ?? "";

echo "<table id='brow' class='table table-bordered table-condensed'>";


/* =========================================================
   REMITOS
   ========================================================= */

if ($tabla === "REMITOS") {

    $dde = fget("dde");
    $hta = fget("hta");

    echo "
        <tr class='bg-primary'>
            <th>Fecha</th>
            <th>Remito #</th>
            <th>Efector</th>
            <th>Acciones</th>
        </tr>
    ";

    $sql = "
        SELECT
            fecha,
            numero,
            idremitos,
            nombre,
            impreso,
            DATEDIFF(CURDATE(), fecha) AS dias,
            anulado
        FROM remitos
        WHERE fecha BETWEEN $dde AND $hta
        ORDER BY fecha DESC, numero DESC
    ";

    $reg = registros($sql);

    $cant = 0;

    while ($r = mysqli_fetch_assoc($reg)) {

        $fecha = ffec($r["fecha"]);
        $numero = $r["numero"];
        $idRemito = $r["idremitos"];

        $nombre = htmlspecialchars(
            (string)($r["nombre"] ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

        $impreso = $r["impreso"] ?? "0";
        $anulado = $r["anulado"] ?? "0";
        $dias = intval($r["dias"] ?? 0);

        echo "<tr>";

        echo "<td>" . $fecha . "</td>";
        echo "<td>" . $numero . "</td>";
        echo "<td>" . $nombre . "</td>";
        echo "<td>";

        if ($impreso === "0") {

            echo "
                <img
                    src='imagenes/editar.png'
                    height='20'
                    width='20'
                    alt='Editar'
                    onclick='edita(" . $numero . ")'
                >
                &nbsp;

                <img
                    src='imagenes/llave.png'
                    height='20'
                    width='20'
                    alt='Cerrar'
                    onclick='cierra(" . $idRemito . ")'
                >
            ";

        } else {

            echo "
                <img
                    src='imagenes/imprimir.png'
                    height='20'
                    width='20'
                    alt='Imprimir'
                    onclick='imprime(" . $numero . ")'
                >
                &nbsp;
            ";

            if ($anulado === "1") {

                echo "Anulado";

            } elseif ($dias < 5) {

                echo "
                    <button
                        type='button'
                        class='btn btn-sm btn-danger'
                        onclick='anula(" . $numero . ")'
                    >
                        Anular
                    </button>

                    <button
                        type='button'
                        class='btn btn-sm btn-success'
                        onclick='replica(" . $numero . ")'
                    >
                        Replicar
                    </button>
                ";
            }
        }

        echo "</td>";
        echo "</tr>";

        $cant++;
    }
}


/* =========================================================
   REMITOS DE BIENES DE USO
   ========================================================= */

if ($tabla === "REMITOSBU") {

    $dde = fget("dde");
    $hta = fget("hta");

    echo "
        <tr class='bg-primary'>
            <th>Fecha</th>
            <th>Remito #</th>
            <th>Efector</th>
            <th>Artículo</th>
            <th>F-Estante</th>
        </tr>
    ";

    $sql = "
        SELECT
            fecha,
            numero,
            idremitos,
            nombre,
            articulos.descripcion AS arti,
            ficha_estante
        FROM remitos_articulos
        LEFT JOIN remitos
            ON remito = idremitos
        LEFT JOIN articulos
            ON articulo = idarticulos
        WHERE articulos.tipo_bien = 2
          AND fecha BETWEEN $dde AND $hta
        ORDER BY fecha DESC, numero DESC
    ";

    $reg = registros($sql);

    $cant = 0;

    while ($r = mysqli_fetch_assoc($reg)) {

        $fecha = ffec($r["fecha"]);

        $nombre = htmlspecialchars(
            (string)($r["nombre"] ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

        $articulo = htmlspecialchars(
            (string)($r["arti"] ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

        $fichaEstante = htmlspecialchars(
            (string)($r["ficha_estante"] ?? ""),
            ENT_QUOTES,
            "UTF-8"
        );

        echo "<tr>";

        echo "<td>" . $fecha . "</td>";
        echo "<td>" . $r["numero"] . "</td>";
        echo "<td>" . $nombre . "</td>";
        echo "<td>" . $articulo . "</td>";
        echo "<td>" . $fichaEstante . "</td>";

        echo "</tr>";

        $cant++;
    }
}

echo "</table>";