<?php
// Iniciar sesión y conexión a la base de datos
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carkey";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejar la acción de 'Atendido'
if (isset($_POST['marcarAtendido'])) {
    $idReporte = $_POST['idReporte'];
    $sql = "DELETE FROM reporte WHERE ID_Reporte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idReporte);
    if ($stmt->execute()) {
        echo "<script>alert('Reporte atendido y eliminado correctamente');</script>";
    } else {
        echo "<script>alert('Error al atender el reporte');</script>";
    }
}

// Obtener los reportes de la base de datos
$sql = "SELECT * FROM reporte";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Reportes</title>
    <script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Lora;
            background-image: url('img/fondoCliente.png');
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.1); /* Fondo transparente */
            border-radius: 15px;
           

        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #000000;
            color: white;
        }
        td {
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37); /* Efecto de profundidad */
            backdrop-filter: blur(10px); /* Difuminado del fondo */
            -webkit-backdrop-filter: blur(10px); /* Difuminado para Safari */
            border: 1px solid rgba(255, 255, 255, 0.18); /* Borde con transparencia */
        }
        tr:hover {
            background-color: #f1f1f1;
            color: black;
        }
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }
        button:hover {
            background-color: #45a049;
            
        }
        .btn-exit {
            margin-top: 20px;
            background-color: #555;
            color: white;
            text-align: center;
            display: block;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <h1>Reportes de Incidentes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Placa</th>
                <th>Fecha del Incidente</th>
                <th>Detalles</th>
                <th>Empleado</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['ID_Reporte']; ?></td>
                <td><?php echo $row['Id_Placa_Re']; ?></td>
                <td><?php echo $row['Fecha_Incidente']; ?></td>
                <td><?php echo $row['Detalles']; ?></td>
                <td><?php echo $row['Id_Empleado_Re']; ?></td>
                <td><?php echo $row['Id_Cliente_Re']; ?></td>
                <td>
                    <form action="verReporte.php" method="post">
                        <input type="hidden" name="idReporte" value="<?php echo $row['ID_Reporte']; ?>">
                        <button type="submit" name="marcarAtendido">Atendido</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button class="btn-exit" onclick="window.location.href='administrativo.php'">Regresar al Administrativo</button>
</body>
</html>

<?php
$conn->close();
?>
