<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Validar parámetros
if (!isset($_GET["x"])) {
    echo json_encode(["error" => "Falta el parámetro 'x'"]);
    exit;
}

if (!isset($_GET["y"])) {
    echo json_encode(["error" => "Falta el parámetro 'y'"]);
    exit;
}

$x = urlencode($_GET["x"]);
$y = urlencode($_GET["y"]);
$url = "https://ws.usig.buenosaires.gob.ar/datos_utiles?x={$x}&y={$y}";


// Inicializar CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar request
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

// Enviar la respuesta del servicio USIG al frontend
echo $response;
?>