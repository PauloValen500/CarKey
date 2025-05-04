<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_GET['id']; // Obtiene el ID del auto desde la URL

// Inicia la transacción
$conn->begin_transaction();

try {
    // Eliminar todas las rentas asociadas al auto en la tabla renta
    $stmt = $conn->prepare("DELETE FROM renta WHERE Id_Placa_Ra = ?");
    $stmt->bind_param("s", $id);  // Usamos "s" si el Id_Placa es un string
    if (!$stmt->execute()) {
        throw new Exception("Error eliminando las rentas: " . $stmt->error);
    }

    

    // Ahora, eliminar el auto
    $stmt = $conn->prepare("DELETE FROM auto WHERE Id_Placa = ?");
    $stmt->bind_param("s", $id);
    if ($stmt->execute()) {
        // Si todo es exitoso, confirmamos la transacción
        $conn->commit();
        echo "<script>alert('Auto eliminado correctamente'); window.location.href='consultaAuto.php';</script>";
    } else {
        throw new Exception("Error eliminando el auto: " . $stmt->error);
    }
} catch (Exception $e) {
    // Si algo falla, revertimos la transacción
    $conn->rollback();
    echo "Failed to delete auto: " . $e->getMessage();
}

$conn->close();
?>
