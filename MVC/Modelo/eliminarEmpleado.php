<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el ID del empleado a eliminar
$idEmpleado = intval($_GET['id']);

// Primero, obtenemos el ID de la persona
$sql = "SELECT ID_Persona_Emp FROM empleado WHERE ID_Empleado = $idEmpleado";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idPersona = $row['ID_Persona_Emp'];

    // Eliminamos el empleado
    $sqlEmpleado = "DELETE FROM empleado WHERE ID_Empleado = $idEmpleado";

    if ($conn->query($sqlEmpleado) === TRUE) {
        // Eliminamos la persona
        $sqlPersona = "DELETE FROM persona WHERE ID_Persona = $idPersona";

        if ($conn->query($sqlPersona) === TRUE) {
            echo "Empleado eliminado correctamente.";
        } else {
            echo "Error al eliminar la persona: " . $conn->error;
        }
    } else {
        echo "Error al eliminar el cliente: " . $conn->error;
    }
} else {
    echo "Empleado no encontrado.";
}

// Cerrar conexión
$conn->close();

// Redirigir a la página de lista de clientes
header("Location: listaClientes.php");
exit();
?>
