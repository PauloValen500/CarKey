<?php
session_start(); // Inicia la sesión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carkey";

// Crear conexión a la base de datos 
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $placa = $_POST['placa'];
    $color = $_POST['color'];
    $anio = $_POST['anio'];
    $kilometraje = $_POST['kilometraje'];
    $combustible = $_POST['combustible'];
    $precio = $_POST['precio'];
    $deposito = $_POST['deposito'];

    // Manejo de la imagen
    $target_dir = "uploads/"; 
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);  // Crea la carpeta si no existe
    }
    
    $nombreArchivo = basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . $nombreArchivo;
    
    // Mueve el archivo cargado a la carpeta 'uploads'
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
    // Insertar datos en la base de datos
    $sql = "INSERT INTO auto (id_placa, marca, foto, modelo, anio_fabricacion, color, tipo_combustible, kilometraje, precio_dia, deposito, estado_vehiculo) 
            VALUES ('$placa', '$marca', '$nombreArchivo', '$modelo', '$anio', '$color', '$combustible', '$kilometraje', '$precio', '$deposito', 1)";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Nuevo auto registrado correctamente.";
        header("Location: ../validacion.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../fallaReg.php");
    }
} else {
    echo "Lo siento, hubo un error al subir tu archivo.";
}

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Vehículo</title>
    <link rel="stylesheet" href="registro.css">
</head>
<Style>
    html {
    background-image: url(img/fondo6.jpg);
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
}

.top-nav {
    
   background-color: #b2b4b880;
    padding: 10px 0px;
    text-align: center;
    align-items: center;
    

}
h4{
    font-size: 50px;
    font-family: cursive;
    color: #fdfdfd;
    text-shadow: #000;
    margin: 10px 0;
    justify-content: center;
    text-align: center;
    padding: 10px 0px;
}
.top-nav h4{
    justify-content: center;
    font-size: 50px;
    text-align: center;
    font-family: cursive;
    color: rgb(250, 243, 243);
    margin: 10px 0;
    
}

.modal-content {
    background: rgba(212, 205, 205, 0.8);
    padding: 20px ;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    width: 300px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}
.modal-content input {
    width: 100%;
    padding: 7px;
    margin-bottom: 3%;
    border: 1px solid #555;
    border-radius: 10px;
    background: rgba(231, 228, 228, 0.8);
    color: #000;
    font-family: cursive;
}

.modal-content label{
font-family: Georgia, 'Times New Roman', Times, serif;
font-size: 18px;
 left: 10%;
    margin-bottom: 5px;

}

.registro input {
    background-color: #000000;
    color: aliceblue;
    font-size: 14px;
    margin-top: 15px;
cursor: pointer; 
    transition: background-color 0.3s;
}
.registro input:hover {
    background-color: #fdfdfd; 
    color: #000000;
}
.close {
    color: #aaa;
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 25px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: rgb(8, 6, 6);
    text-decoration: none;
    cursor: pointer;
}

    </Style>
<body>
    <nav class="top-nav"></nav>
    <div class="registrer-container">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>CarKey</h4>
            <form action="src/registrar_vehiculo.php" method="post" enctype="multipart/form-data">
                <input type="text" id="marca" name="marca" placeholder="Marca" required>
                <input type="text" id="modelo" name="modelo" placeholder="Modelo" required>
                <input type="text" id="placa" name="placa" placeholder="Placa" required>
                <input type="text" id="color" name="color" placeholder="Color" required>
                <label for ="anio">Fecha de fabricación</label>
                <input type="date" id="anio" name="anio" placeholder="Año" required>
                <input type="text" id="kilometraje" name="kilometraje" placeholder="Kilometraje" required>
                <input type="text" id="combustible" name="combustible" placeholder="Tipo de Combustible" required>
                <input type="text" id="precio" name="precio" placeholder="Precio por Día" required>
                <input type="text" id="deposito" name="deposito" placeholder="Depósito" required>
                <label for ="foto">Foto</label>
                <input type="file" id="foto" name="foto" required>
                <div class="registro">
                    <input type="submit" value="Registrar Auto">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

