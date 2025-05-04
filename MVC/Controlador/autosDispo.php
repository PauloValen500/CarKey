<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');


// Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene las fechas del formulario
    $startDate = new DateTime($_POST['startDate']);
    $endDate = new DateTime($_POST['endDate']);
    $interval = $startDate->diff($endDate);
    $days = $interval->days;

    // Consulta para obtener autos no rentados entre las fechas seleccionadas
    $sql = "
        SELECT auto.Id_Placa, auto.Marca, auto.Modelo, auto.Color, auto.Precio_Dia, auto.deposito
        FROM auto
        LEFT JOIN renta ON auto.Id_Placa = renta.Id_Placa_Ra
        WHERE 
            (renta.Fecha_Renta_Inicio IS NULL 
            OR renta.Fecha_Renta_Fin < ? 
            OR renta.Fecha_Renta_Inicio > ?)
            AND auto.Estado_Vehiculo = 1
    ";
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_POST['startDate'], $_POST['endDate']);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autos Disponibles</title>
    <style>
        /* General body styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1f1f1f;
            margin: 0;
            padding: 20px;
            color: #f0f0f0;
        }

        /* Dashboard container */
        .dashboard {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Heading styles */
        h1 {
            text-align: center;
            color: #fff;
            font-weight: 600;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-top: 30px;
        }

        /* Form styles */
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 15px;
            width: 80%;
        }

        .input-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #fff;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #00d1b2;
        }

        /* Button styles */
        .btn-submit {
            background-color: #00d1b2;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #00a69e;
        }

        /* Table styles */
        .table-auto {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }

        th {
            background-color: #222;
            color: #fff;
        }

        td {
            color: #fff;
        }

        tr:hover {
            background-color: #333;
        }

        /* Rent button */
        .btn-rent {
            background-color: #4caf50;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-rent:hover {
            background-color: #45a049;
        }

        /* Back button */
        .btn-back {
            background-color: #ff5722;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #e64a19;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Buscar Autos Disponibles</h1>

        <!-- Formulario para seleccionar fechas -->
        <form action="" method="POST" class="form-container">
            <div class="input-group">
                <label for="startDate">Fecha de Inicio:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>
            <div class="input-group">
                <label for="endDate">Fecha de Fin:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>
            <button type="submit" class="btn-submit">Buscar</button>
        </form>

        <!-- Mostrar resultados si el formulario ha sido enviado -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <h2>Autos Disponibles del <?php echo $startDate->format('Y-m-d'); ?> al <?php echo $endDate->format('Y-m-d'); ?></h2>
            <div id="availableCars">
                <?php if (isset($result) && $result->num_rows > 0): ?>
                    <table class="table-auto">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Costo Total</th>
                                <th>Rentar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['Id_Placa']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Marca']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Modelo']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Color']); ?></td>
                                    <td>
                                        <?php
                                        $costoTotal = ($row['Precio_Dia'] * $days) + $row['deposito'];
                                        echo '$' . number_format($costoTotal, 2);
                                        ?>
                                    </td>
                                    <td>
                <?php
            // Calcular el costo total
                    $costoTotal = ($row['Precio_Dia'] * $days) + $row['deposito'];

                    // Crear una URL con los parámetros para la página de renta
                $url = "renta.php?placa=" . urlencode($row['Id_Placa']) . "&marca=" . urlencode($row['Marca']) . "&modelo=" . urlencode($row['Modelo']) . "&color=" . urlencode($row['Color']) . "&costoTotal=" . urlencode($costoTotal) . "&startDate=" . urlencode($startDate->format('Y-m-d')) . "&endDate=" . urlencode($endDate->format('Y-m-d'));
    ?>
    <a href="<?php echo $url; ?>">
        <button class="btn-rent">Rentar</button>
    </a>
</td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay autos disponibles en las fechas seleccionadas.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <button class="btn-back" onclick="window.location.href='empleado.php'">Salir</button>
    </div>
</body>
</html>

<?php
// Solo cerrar la conexión y la declaración si se ha ejecutado la consulta
if (isset($stmt)) {
    $stmt->close();
}

$conn->close();
?>


