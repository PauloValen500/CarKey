<?php
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "carkey";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM auto";
$result = $conn->query($sql);

$vehiculos = array();

if ($result->num_rows > 0) {
    // Salida de cada fila
    while($row = $result->fetch_assoc()) {
        $vehiculos[] = $row;
    }
} else {
    echo "0 resultados";
}

$conn->close();

echo json_encode($vehiculos);
?>
