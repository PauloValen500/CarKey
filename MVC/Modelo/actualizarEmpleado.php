<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene los datos del formulario
$idEmpleado = intval($_POST['idEmpleado']);
$idPersona = intval($_POST['idPersona']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$primerApellido = $conn->real_escape_string($_POST['primerApellido']);
$segundoApellido = $conn->real_escape_string($_POST['segundoApellido']);
$correoElectronico = $conn->real_escape_string($_POST['correoElectronico']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$RFC = $conn->real_escape_string($_POST['RFC']);

// Actualiza los datos en la tabla persona
$sqlPersona = "UPDATE persona SET Nombre = '$nombre', Primer_Apellido = '$primerApellido', Segundo_Apellido = '$segundoApellido', Correo_Electronico = '$correoElectronico', Telefono = '$telefono' WHERE ID_Persona = $idPersona";

if ($conn->query($sqlPersona) === TRUE) {
    // Actualiza los datos en la tabla empleado
    $sqlEmpleado = "UPDATE empleado SET RFC = '$RFC' WHERE ID_Empleado = $idEmpleado";

    if ($conn->query($sqlEmpleado) === TRUE) {
        echo "Empleado actualizado correctamente.";
    } else {
        echo "Error al actualizar el empleado: " . $conn->error;
    }
} else {
    echo "Error al actualizar la persona: " . $conn->error;
}

// Cerrar conexión
$conn->close();

// Redirigir a la página de lista de empleados
header("Location: listaEmpleados.php");
exit();
?>
