<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si el ID de renta está en la URL
if (isset($_GET['id'])) {
    $idRenta = $conn->real_escape_string($_GET['id']);

    // Actualizar el estado de la renta a "firmado"
    $sql = "UPDATE renta SET Contrato = 'firmado' WHERE ID_Renta = $idRenta";
    if ($conn->query($sql) === TRUE) {
        echo "Renta marcada como firmada correctamente.";
    } else {
        echo "Error al actualizar el estado de la renta: " . $conn->error;
    }
} else {
    echo "ID de renta no proporcionado.";
}

// Cerrar conexión
$conn->close();

// Redirigir de vuelta a rentaslinea.php
header("Location: rentaslinea.php");
exit();
?>
