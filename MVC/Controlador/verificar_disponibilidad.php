<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibe los datos del formulario
$idPlaca = $conn->real_escape_string($_POST['idPlaca']);
$fechaInicio = $conn->real_escape_string($_POST['fechaInicio']);
$fechaFin = $conn->real_escape_string($_POST['fechaFin']);

// Consulta para verificar la disponibilidad del auto
$sql = "SELECT * FROM renta WHERE Id_Placa_Ra = '$idPlaca' AND ('$fechaInicio' BETWEEN Fecha_Renta_Inicio AND Fecha_Renta_Fin OR '$fechaFin' BETWEEN Fecha_Renta_Inicio AND Fecha_Renta_Fin OR Fecha_Renta_Inicio BETWEEN '$fechaInicio' AND '$fechaFin' OR Fecha_Renta_Fin BETWEEN '$fechaInicio' AND '$fechaFin')";
$result = $conn->query($sql);

$response = [];
if ($result->num_rows === 0) {
    // El auto está disponible, calcular la cotización
    $autoQuery = $conn->query("SELECT Precio_Dia, deposito FROM auto WHERE Id_Placa = '$idPlaca'");
    if ($autoQuery->num_rows > 0) {
        $autoData = $autoQuery->fetch_assoc();
        $precioDia = $autoData['Precio_Dia'];
        $deposito = $autoData['deposito'];

        // Calcular el número de días de la renta
        $datetime1 = new DateTime($fechaInicio);
        $datetime2 = new DateTime($fechaFin);
        $interval = $datetime1->diff($datetime2);
        $diasRenta = $interval->days;

        // Calcular el monto total
        $monto = ($precioDia * $diasRenta) + $deposito;

        $response['disponible'] = true;
        $response['cotizacion'] = [
            'diasRenta' => $diasRenta,
            'precioDia' => $precioDia,
            'deposito' => $deposito,
            'monto' => $monto
        ];
    } else {
        $response['disponible'] = false;
        $response['error'] = "Auto no encontrado.";
    }
} else {
    $response['disponible'] = false;
}

echo json_encode($response);

$conn->close();
?>