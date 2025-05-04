<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Renta</title>
    <link rel="stylesheet" href="registroRenta.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

    <style>
        /* Tu estilo ya está bien. Puedes mantenerlo igual. */
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="registrer-container">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>CarKey</h4>
                <h5>Renta de Vehículo</h5>
                
                <form id="mainForm" action="registroRenta.php" method="post"> 
                    <input type="number" id="idEmpleado" name="idEmpleado" placeholder="ID Empleado" required>
                    <input type="number" id="idCliente" name="idCliente" placeholder="ID Cliente" required>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre Cliente" required>
                    <input type="text" id="modelo" name="modelo" placeholder="Modelo" required>
                    <input type="text" id="placaR" name="placaR" placeholder="Placa" required>
                    <input type="text" id="seguro" name="seguro" placeholder="Seguro" required>
                    <label for="fechaInicio"> Fecha Inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required>
                    <label for="fechaFin"> Fecha Fin</label>
                    <input type="date" id="fechaFin" name="fechaFin" required>
                    
                    <div class="registro">
                        <input type="submit" value="REGISTRAR">
                        <button onclick="window.history.back();">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
  
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const idPlaca = urlParams.get('placa');
            const modelo = urlParams.get('modelo');
            const precioDia = urlParams.get('costoTotal'); // Asegúrate de que el parámetro se llame 'costoTotal'
            const fechaInicio = urlParams.get('startDate');
            const fechaFin = urlParams.get('endDate');

            // Llenar los campos del formulario con los valores obtenidos
            if (idPlaca) document.getElementById('placaR').value = idPlaca;
            if (modelo) document.getElementById('modelo').value = modelo;
            if (precioDia) document.getElementById('seguro').value = precioDia; // Ajustar el campo adecuado para el precio o seguro
            if (fechaInicio) document.getElementById('fechaInicio').value = fechaInicio;
            if (fechaFin) document.getElementById('fechaFin').value = fechaFin;

            // Si el idEmpleado debe obtenerse de la sesión de PHP (con fetch):
            fetch('get_employee_id.php')
                .then(response => response.json())
                .then(data => {
                    if (data.idEmpleado) {
                        document.getElementById('idEmpleado').value = data.idEmpleado;
                    }
                });
        });
    </script>
</body>
</html>

