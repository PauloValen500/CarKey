<?php
session_start(); // Inicia la sesión


// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

            $sql = "SELECT * FROM renta WHERE Fecha_Renta_Fin >= CURDATE()";
            $result = $conn->query($sql);
// Consulta para obtener las rentas en curso
$sql = "SELECT * FROM renta WHERE Fecha_Renta_Fin >= CURDATE()";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <title>Rentas en Curso</title>
    <style>
        body {
            font-family: Lora;
            background-image: url('img/fondoRentar.png');
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #464545;
            color: white;
        }
        td{
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
            backdrop-filter: blur(10px); /* Difuminado del fondo */
             -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
    border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */

        }
        tr.inactive {
            background-color: #FF6347; 
            color: white;
        }
        tr.active {
            background-color: #90EE90; 
            color: white;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }
        .salir-btn {
            margin-top: 20px;
            background-color: #555;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Rentas en Curso</h1>
    <table>
        <thead>
            <tr>
                <th>ID Renta</th>
                <th>ID Placa</th>
                <th>Fecha Renta Inicio</th>
                <th>Fecha Renta Fin</th>
                <th>ID Cliente</th>
                
                <th>Seguro</th>
                <th>ID Empleado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $estadoClase = $row["Estado"] === 'Finalizada' ? 'active' : 'inactive';
                    echo "<tr class='$estadoClase' id='renta-{$row["ID_Renta"]}'>";
                    echo "<td>" . htmlspecialchars($row["ID_Renta"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Id_Placa_Ra"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Fecha_Renta_Inicio"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Fecha_Renta_Fin"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Id_Cliente_Ra"]) . "</td>";
                    
                    echo "<td>" . htmlspecialchars($row["Seguro"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Id_Empleado_Ra"]) . "</td>";
                    echo "<td><button onclick='finalizarRenta(" . $row["ID_Renta"] . ")'>Finalizar</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No hay rentas en curso.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <button onclick="window.history.back();">Salir 

    <script>
        function finalizarRenta(rentaId) {
            if (confirm('¿Estás seguro de que deseas finalizar esta renta?')) {
                var formData = new FormData();
                formData.append('renta_id', rentaId);

                fetch('finalizarRenta.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert('Renta finalizada con éxito');
                    location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }
    </script>
</body>
</html>
