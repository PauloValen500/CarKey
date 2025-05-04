<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todas las rentas del empleado con ID 34 y estado "pendiente"
$sql = "SELECT * FROM renta WHERE Id_Empleado_Ra = 34 AND Contrato = 'Pendiente'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Rentas del Empleado</title>
    <link rel="stylesheet" href="styles.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Lora;
            margin: 0;
            padding: 20px;
            background-image: url('img/fondoEditar.png');
            color: white;
            

        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
             backdrop-filter: blur(10px); /* Difuminado del fondo */
            -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
            

        }
        th {
            background-color: Black;
            color: white;
           
        }
        td{
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
             backdrop-filter: blur(10px); /* Difuminado del fondo */
            -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
        }
        .btn {
            padding: 5px 10px;
            color: white;
            background-color: #4CAF50; 
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-contract {
            background-color: #f0ad4e; 
        }
        .btn-sign {
            background-color: #d9534f; 
        }
    </style>
</head>
<body>

    <h1>Rentas en Línea</h1>
    <button type="button" onclick="window.location.href='empleado.php'">Salir</button>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID Renta</th><th>ID Cliente</th><th>Placa</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Modelo</th><th>Seguro</th><th>Acciones</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $filePath = "/CarKey/src/contratos/Renta_" . $row['Id_Cliente_Ra'] . ".pdf";
            echo "<tr>";
            echo "<td>" . $row['ID_Renta'] . "</td>";
            echo "<td>" . $row['Id_Cliente_Ra'] . "</td>";
            echo "<td>" . $row['Id_Placa_Ra'] . "</td>";
            echo "<td>" . $row['Fecha_Renta_Inicio'] . "</td>";
            echo "<td>" . $row['Fecha_Renta_Fin'] . "</td>";
            echo "<td>" . $row['Modelo'] . "</td>";
            echo "<td>" . $row['Seguro'] . "</td>";
            echo "<td>
                    <a href='$filePath' class='btn btn-contract' download>Contrato</a>
                    <button class='btn btn-sign' onclick='firmarRenta(" . $row['ID_Renta'] . ")'>Firmado</button>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron rentas.";
    }

    // Cerrar conexión
    $conn->close();
    ?>

    <script>
        function firmarRenta(idRenta) {
            if (confirm('¿Estás seguro de que deseas marcar esta renta como firmada?')) {
                window.location.href = 'firmarRenta.php?id=' + idRenta;
            }
        }
    </script>
</body>
</html>
