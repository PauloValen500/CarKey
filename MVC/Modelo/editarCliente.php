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
$sql = "SELECT c.ID_Cliente, p.ID_Persona, p.Nombre, p.Primer_Apellido, p.Segundo_Apellido, p.Correo_Electronico, p.Telefono, c.RFC, c.INE, c.Licencia_de_conducir 
        FROM cliente c 
        JOIN persona p ON c.ID_Persona_Cl = p.ID_Persona
        WHERE c.ID_Cliente = $idCliente";
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
        <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
        <style>
            body{
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
            input[type="text"], input[type="email"] {
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
                font-family: lora;
            }
            input:hover{
                background-color: white;
                color: black;
            }
            
        </style>
    </head>
    <body>
        
        <h1>Editar Cliente</h1>
        <form action="actualizarCliente.php" method="post">
            <input type="hidden" name="idCliente" value="<?php echo $row['ID_Cliente']; ?>">
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
            <label for="INE">INE:</label>
            <input type="text" id="INE" name="INE" value="<?php echo $row['INE']; ?>" required>
            <label for="licenciaConducir">Licencia de Conducir:</label>
            <input type="text" id="licenciaConducir" name="licenciaConducir" value="<?php echo $row['Licencia_de_conducir']; ?>" required>
            <input type="submit" value="Actualizar Cliente">
        </form>
    </body>
    </html>
    <?php
} else {
    echo "No se encontró el cliente.";
}

// Cerrar conexión
$conn->close();
?>
