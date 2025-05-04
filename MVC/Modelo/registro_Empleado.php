<?php
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

// Preparar y ejecutar la inserción en la tabla Empleado
$estatus = 1; 
$sqlEmpleado = "INSERT INTO empleado (RFC, ID_Persona_Emp, Estatus) VALUES (?, ?, ?)";
$stmtEmpleado = $conn->prepare($sqlEmpleado);
if (!$stmtEmpleado) {
    die('MySQL prepare error: ' . $conn->error);
}


$stmtEmpleado->bind_param("ssi", $rfc, $personaId, $estatus);
$stmtEmpleado->execute();
$empleadoId = $stmtEmpleado->insert_id; 

// Guardar los IDs en la sesión
$_SESSION['personaId'] = $personaId;
$_SESSION['empleadoId'] = $empleadoId;


header("Location: ../validarREGEM.php?personaId=$personaId&empleadoId=$empleadoId&contrasena=$contrasena");
exit;

$stmtPersona->close();
$stmtEmpleado->close();
$conn->close();
?>
