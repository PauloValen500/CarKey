<?php
session_start();

if (isset($_POST['renta_id'])) {
    $renta_id = $_POST['renta_id'];

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'carkey');

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Primero, recuperamos la renta a finalizar
        $query = "SELECT * FROM renta WHERE ID_Renta = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $renta_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $renta_data = $result->fetch_assoc();

        if ($renta_data) {
            // Insertamos en rentasFinalizadas
            $insert_query = "INSERT INTO rentasFinalizadas (renta_id_fin, Estado) VALUES (?, 'Finalizada')";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("i", $renta_id);
            $insert_stmt->execute();

            // Actualizar la renta original
            $update_query = "UPDATE renta SET Estado = 'Finalizada' WHERE ID_Renta = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $renta_id);
            $update_stmt->execute();

            // Si todo está bien, commit
            $conn->commit();
        }

        $stmt->close();
        $insert_stmt->close();
        $update_stmt->close();
    } catch (Exception $e) {
        $conn->rollback(); // Algo salió mal, revertimos la base de datos
        error_log($e->getMessage()); // Log del error
        exit('Error procesando la renta finalizada.');
    }

    $conn->close();
    header("Location: rentasEnCurso.php"); // Redirigir de vuelta a la lista
    exit();
}
?>
