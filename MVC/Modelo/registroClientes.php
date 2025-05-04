<?php
// Inicia la sesión
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos del formulario
$nombre = $_POST['nombre'];
$primerApellido = $_POST['primerApellido'];
$segundoApellido = $_POST['segundoApellido'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$rfc = $_POST['rfc'];
$ine = $_POST['ine'];
$licencia = $_POST['licencia'];
$numeroTarjeta = $_POST['numeroTarjeta'];
$cvv = $_POST['cvv'];
$fechaVencimiento = $_POST['fechaVencimiento'];

// Usar el RFC directamente como contraseña
$contrasena = $rfc;

// Preparar y ejecutar la inserción en la tabla Persona
$sqlPersona = "INSERT INTO Persona (Nombre, Primer_Apellido, Segundo_Apellido, Correo_Electronico, contrasena, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
$stmtPersona = $conn->prepare($sqlPersona);
if (!$stmtPersona) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmtPersona->bind_param("ssssss", $nombre, $primerApellido, $segundoApellido, $correo, $contrasena, $telefono);
$stmtPersona->execute();
$personaId = $stmtPersona->insert_id; // Obtiene el ID de la última inserción

// Preparar y ejecutar la inserción en la tabla Cliente
$sqlCliente = "INSERT INTO Cliente (RFC, INE, Licencia_de_conducir, ID_Persona_Cl) VALUES (?, ?, ?, ?)";
$stmtCliente = $conn->prepare($sqlCliente);
if (!$stmtCliente) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmtCliente->bind_param("sssi", $rfc, $ine, $licencia, $personaId);
$stmtCliente->execute();
$clienteId = $stmtCliente->insert_id; // Obtiene el ID de la última inserción en la tabla Cliente

// Preparar y ejecutar la inserción en la tabla tarjetacredito
$sqlTarjeta = "INSERT INTO tarjetacredito (Id_Cliente_Tar, numero, cvv, fechaVencimiento) VALUES (?, ?, ?, ?)";
$stmtTarjeta = $conn->prepare($sqlTarjeta);
if (!$stmtTarjeta) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmtTarjeta->bind_param("issi", $clienteId, $numeroTarjeta, $cvv, $fechaVencimiento);
$stmtTarjeta->execute();

// Redirigir a validacion.php con los IDs en la URL
header("Location: ../validacion.php?personaId=$personaId&clienteId=$clienteId&contrasena=$contrasena");
exit;

// Cerrar las declaraciones y la conexión
$stmtPersona->close();
$stmtCliente->close();
$stmtTarjeta->close();
$conn->close();
?>
