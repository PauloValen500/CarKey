<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el ID del cliente a eliminar
$idCliente = intval($_GET['id']);

// Primero, obtenemos el ID de la persona
$sql = "SELECT ID_Persona_Cl FROM cliente WHERE ID_Cliente = $idCliente";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idPersona = $row['ID_Persona_Cl'];

    // Eliminamos el cliente
    $sqlCliente = "DELETE FROM cliente WHERE ID_Cliente = $idCliente";

    if ($conn->query($sqlCliente) === TRUE) {
        // Eliminamos la persona
        $sqlPersona = "DELETE FROM persona WHERE ID_Persona = $idPersona";

        if ($conn->query($sqlPersona) === TRUE) {
            echo "Cliente y persona eliminados correctamente.";
        } else {
            echo "Error al eliminar la persona: " . $conn->error;
        }
    } else {
        echo "Error al eliminar el cliente: " . $conn->error;
    }
} else {
    echo "Cliente no encontrado.";
}

// Cerrar conexión
$conn->close();


header("Location: listaClientes.php");
exit();
?>
