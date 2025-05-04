document.getElementById('loginButton').onclick = function() {
    document.getElementById('loginModal').style.display = 'block';
}

document.querySelector('.close').onclick = function() {
    document.getElementById('loginModal').style.display = 'none';
}
document.getElementById('loginForm').onsubmit = function() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    console.log('Intento de inicio de sesión con', username, password);
    // Aquí podría ir una llamada AJAX si quieres hacer la validación sin recargar la página
};
document.getElementById('loginButton').addEventListener('click', function() {
    window.location.href = 'inicio.html';
});
// scripts.js
function nuevoRegistro() {
    document.getElementById('nuevoRegistroModal').style.display = 'block';
}
  
  


function crearReporte() {
    window.location.href = 'crear_reporte.html';
}

function verCatalogo() {
    window.location.href = 'catalogo.html';
}

function tramitarRenta() {
    window.location.href = 'tramitar_renta.html';
}

function consultarCliente() {
    window.location.href = 'consultar_cliente.html';
}

function rentasEnCurso() {
    window.location.href = 'rentas_en_curso.html';
}

function verMensajes() {
    window.location.href = 'mensajes.html';
}

function salir() {
    // Aquí deberías manejar el cierre de sesión de manera segura
    window.location.href = 'index.html';
}
