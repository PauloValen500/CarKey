<?php
// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'carkey');

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtiene el ID del cliente a editar
$idCliente = intval($_GET['id']);

// Consulta los datos del cliente y de la persona
$sql = "SELECT c.ID_Empleado, p.ID_Persona, p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, p.Correo_Electronico, p.Telefono, c.RFC 
        FROM empleado c 
        JOIN persona p ON c.ID_Persona_Emp = p.ID_Persona
        WHERE c.ID_Empleado = $idCliente";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar Cliente</title>
        <link rel="stylesheet" href="styles.css"> 
        <style>
            form {
                max-width: 600px;
                margin: auto;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 10px;
            }
            label {
                display: block;
                margin: 10px 0 5px;
            }
            input[type="text"], input[type="email"] {
                width: 100%;
                padding: 10px;
                margin: 5px 0 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <h1>Editar Empleado</h1>
        <form action="actualizarEmpleado.php" method="post">
            <input type="hidden" name="idEmp" value="<?php echo $row['ID_Empleado']; ?>">
            <input type="hidden" name="idPersona" value="<?php echo $row['ID_Persona']; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $row['Nombre']; ?>" required>
            <label for="primerApellido">Primer Apellido:</label>
            <input type="text" id="primerApellido" name="primerApellido" value="<?php echo $row['Primer_Apellido']; ?>" required>
            <label for="segundoApellido">Segundo Apellido:</label>
            <input type="text" id="segundoApellido" name="segundoApellido" value="<?php echo $row['Segundo_Apellido']; ?>" required>
            <label for="correoElectronico">Correo Electrónico:</label>
            <input type="email" id="correoElectronico" name="correoElectronico" value="<?php echo $row['Correo_Electronico']; ?>" required>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $row['Telefono']; ?>" required>
            <label for="RFC">RFC:</label>
            <input type="text" id="RFC" name="RFC" value="<?php echo $row['RFC']; ?>" required>
            
            
            <input type="submit" value="Actualizar Empleado">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "No se encontró el empleado.";
}

// Cerrar conexión
$conn->close();
?>
