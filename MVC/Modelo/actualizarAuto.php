<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el formulario ha sido enviado (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $idPlaca = $_POST['idPlaca'];  // El ID de la placa del auto a editar
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $tipo_combustible = $_POST['tipo_combustible'];
    $kilometraje = $_POST['kilometraje'];
    $precio_dia = $_POST['precio_dia'];
    $deposito = $_POST['deposito'];

    // Verifica que se está recibiendo correctamente el idPlaca
    echo "ID Placa recibido: " . $idPlaca . "<br>";  // Muestra el valor de idPlaca
    echo "Marca: " . $marca . "<br>"; 
    echo "Modelo: " . $modelo . "<br>";
    echo "Año: " . $anio . "<br>";
    echo "Color: " . $color . "<br>";
    echo "Tipo Combustible: " . $tipo_combustible . "<br>";
    echo "Kilometraje: " . $kilometraje . "<br>";
    echo "Precio por Día: " . $precio_dia . "<br>";
    echo "Depósito: " . $deposito . "<br>";
    
    // Asegúrate que los datos estén correctamente formateados
    if (!is_numeric($kilometraje)) {
        echo "Error: Kilometraje no es un número.<br>";
    }
    if (!is_numeric($precio_dia)) {
        echo "Error: Precio por Día no es un número.<br>";
    }
    if (!is_numeric($deposito)) {
        echo "Error: Depósito no es un número.<br>";
    }

    // Consulta de actualización
    $sql = "UPDATE auto SET 
                Marca=?, Modelo=?, Anio_Fabricacion=?, 
                Color=?, Tipo_Combustible=?, Kilometraje=?, 
                Precio_Dia=?, deposito=? 
            WHERE Id_Placa=?";
    
    // Prepara la consulta
    $stmt = $conn->prepare($sql);
    
    // Asegúrate de usar el tipo de datos correcto
    // 's' para string (Id_Placa, Marca, Modelo, Año, Color, Tipo_Combustible)
    // 'd' para double (Kilometraje, Precio_Dia, Deposito)
    $stmt->bind_param("ssdssddds", $marca, $modelo, $anio, $color, $tipo_combustible, $kilometraje, $precio_dia, $deposito, $idPlaca);

    // Ejecuta la consulta y revisa si hubo algún error
    if ($stmt->execute()) {
        echo "<script>alert('Auto actualizado correctamente.'); window.location.href='consultaAuto.php';</script>";
    } else {
        echo "Error al actualizar el auto: " . $conn->error . "<br>";
    }
}

// Cerrar conexión
$conn->close();
?>
