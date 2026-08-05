<?php
/**
 * geocodificar.php
 * 
 * Lee direcciones desde un archivo CSV o TXT (una por línea),
 * consulta la API de Google Geocoding,
 * y guarda un CSV con dirección, latitud, longitud y estado.
 */

$apiKey = "AIzaSyCbEYhO4fGVrwDAgLY-9GeOotGSfTQxUb0";  // ← reemplazá con tu clave real
$inputFile = "test/direcciones.csv"; // archivo de entrada
$outputFile = "test/coordenadas.csv"; // archivo de salida

// --- Configuración ---
$delay = 0.25; // segundos entre llamadas (para evitar límites)
$retryDelay = 2; // segundos entre reintentos en caso de error
$maxRetries = 3; // cantidad máxima de reintentos

// --- Cargar direcciones ---
if (!file_exists($inputFile)) {
    die("No se encontró el archivo $inputFile\n");
}

$direcciones = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// --- Abrir archivo de salida ---
$fp = fopen($outputFile, 'a');
if (filesize($outputFile) === 0) {
    fputcsv($fp, ['direccion', 'lat', 'lng', 'status']);
}

// --- Evitar duplicados ya procesados ---
$procesadas = [];
if (($fh = fopen($outputFile, 'r')) !== false) {
    while (($row = fgetcsv($fh)) !== false) {
        $procesadas[$row[0]] = true;
    }
    fclose($fh);
}

$total = count($direcciones);
$cont = 0;

foreach ($direcciones as $dir) {
    $cont++;
    if (isset($procesadas[$dir])) {
        echo "[$cont/$total] Ya procesada: $dir\n";
        continue;
    }

    echo "[$cont/$total] Consultando: $dir ... ";

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($dir) . "&key=" . $apiKey;

    $intento = 0;
    do {
        $intento++;
        $json = file_get_contents($url);
        if ($json === false) {
            echo "Error de conexión, reintentando...\n";
            sleep($retryDelay);
            continue;
        }

        $data = json_decode($json, true);

        if ($data["status"] === "OK") {
            $lat = $data["results"][0]["geometry"]["location"]["lat"];
            $lng = $data["results"][0]["geometry"]["location"]["lng"];
            fputcsv($fp, [$dir, $lat, $lng, "OK"]);
            echo "OK ($lat, $lng)\n";
            break;
        } elseif (in_array($data["status"], ["OVER_QUERY_LIMIT", "UNKNOWN_ERROR"])) {
            echo "Límite o error temporal, reintentando...\n";
            sleep($retryDelay);
        } else {
            fputcsv($fp, [$dir, "", "", $data["status"]]);
            echo "Fallo: " . $data["status"] . "\n";
            break;
        }
    } while ($intento < $maxRetries);

    usleep($delay * 1e6);
}

fclose($fp);
echo "\nFinalizado. Resultados guardados en $outputFile\n";
?>
