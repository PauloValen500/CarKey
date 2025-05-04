<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene los datos del formulario
$idCliente = intval($_POST['idCliente']);
$idPersona = intval($_POST['idPersona']);
$nombre = $conn->real_escape_string($_POST['nombre']);
$primerApellido = $conn->real_escape_string($_POST['primerApellido']);
$segundoApellido = $conn->real_escape_string($_POST['segundoApellido']);
$correoElectronico = $conn->real_escape_string($_POST['correoElectronico']);
$telefono = $conn->real_escape_string($_POST['telefono']);
$RFC = $conn->real_escape_string($_POST['RFC']);
$INE = $conn->real_escape_string($_POST['INE']);
$licenciaConducir = $conn->real_escape_string($_POST['licenciaConducir']);

// Actualiza los datos en la tabla persona
$sqlPersona = "UPDATE persona SET Nombre = '$nombre', Primer_Apellido = '$primerApellido', Segundo_Apellido = '$segundoApellido', Correo_Electronico = '$correoElectronico', Telefono = '$telefono' WHERE ID_Persona = $idPersona";

if ($conn->query($sqlPersona) === TRUE) {
    // Actualiza los datos en la tabla cliente
    $sqlCliente = "UPDATE cliente SET RFC = '$RFC', INE = '$INE', Licencia_de_conducir = '$licenciaConducir' WHERE ID_Cliente = $idCliente";

    if ($conn->query($sqlCliente) === TRUE) {
        echo "Cliente actualizado correctamente.";
    } else {
        echo "Error al actualizar el cliente: " . $conn->error;
    }
} else {
    echo "Error al actualizar la persona: " . $conn->error;
}

// Cerrar conexión
$conn->close();

// Redirigir a la página de lista de clientes
header("Location: listaClientes.php");
exit();
?>
