<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el ID del auto a editar (ID_Placa)
$idPlaca = $_GET['id'];  // El ID se pasa como parámetro en la URL

// Consulta para obtener los detalles del auto
$sql = "SELECT * FROM auto WHERE Id_Placa = '$idPlaca'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar Auto</title>
        <link rel="stylesheet" href="styles.css">
        <style>
            body {
                background-image: url('img/fondoEditar.png');
                font-family: Lora;
                color: white;
                text-align: center;
            }
            form {
                max-width: 600px;
                margin: auto;
                padding: 30px;
                border: 1px solid #ccc;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
                border-radius: 15px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
                backdrop-filter: blur(10px); /* Difuminado del fondo */
                -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
                border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
            }
            label {
                display: flex;
                margin: 10px 0 5px;
            }
            input[type="text"], input[type="date"], input[type="number"], input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin: 5px 0 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                display: center;
            }
            input[type="submit"] {
                background-color: #000000;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                font-family: Lora;
            }
            input:hover {
                background-color: white;
                color: black;
            }
        </style>
    </head>
    <body>
        <h1>Editar Auto</h1>
        <form action="actualizarAuto.php" method="post">
            <input type="hidden" name="idPlaca" value="<?php echo $row['Id_Placa']; ?>">
            
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo $row['Marca']; ?>" required>

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $row['Modelo']; ?>" required>

            <label for="anio">Año de fabricación:</label>
            <input type="date" id="anio" name="anio" value="<?php echo $row['Anio_Fabricacion']; ?>" required>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo $row['Color']; ?>" required>

            <label for="tipo_combustible">Tipo de combustible:</label>
            <input type="text" id="tipo_combustible" name="tipo_combustible" value="<?php echo $row['Tipo_Combustible']; ?>" required>

            <label for="kilometraje">Kilometraje:</label>
            <input type="number" id="kilometraje" name="kilometraje" value="<?php echo $row['Kilometraje']; ?>" required>

            <label for="precio_dia">Precio por día:</label>
            <input type="number" id="precio_dia" name="precio_dia" value="<?php echo $row['Precio_Dia']; ?>" required>

            <label for="deposito">Depósito:</label>
            <input type="number" id="deposito" name="deposito" value="<?php echo $row['deposito']; ?>" required>

            <input type="submit" value="Actualizar Auto">
        </form>
    </body>
    </html>
<?php
} else {
    echo "No se encontró el auto con la placa $idPlaca.";
}

// Cerrar conexión
$conn->close();
?>
