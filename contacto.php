<?php

require_once("templates/header.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
</head>

<body>
    <div class="contact">
        <img src="static/img/LogoFondo.jpg" class="fotoPerfil">
        <div class="datosPersonales">
            <h1 class="nombre">Sergi Espinosa Belén</h1>
            <p>Ciclo Superior DAW</p>
            <p>IES Maciá Abela, Crevillent</p>
            <br>
            <p><strong>Teléfono: </strong>+34 XXX XX XX XX</p>
            <p><strong>Email: </strong>sergiesbe@gmail.com</p>
        </div>
    </div>

    <br>
    <hr>
    <div class="tituloFormulario">
        <p>Formulario para contactar</p>
    </div>
    
    <div class="cajaFormulario">
    <form class ="datosForm" action="">
        <label id="nombre">Nombre *</label><br>
        <input type="text" required placeholder="Tu nombre" name="nombre"><br><br>
        <label id="correo">Correo electronico *</label><br>
        <input type="text" required placeholder="ejemplo@correo.com" name="correo"><br><br>
        <label id="asunto">Asunto *</label><br>
        <input type="text" required placeholder="Motivo del mensaje" name="asunto"><br><br>
        <label id="mensaje">Mensaje *</label><br>
        <textarea rows="7" required placeholder="Escribe tu mensaje aqui..." name="mensaje"></textarea><br>
        <button type="submit">Enviar</button>
    </form>
    </div>

</body>

</html>

<?php
$rutaBase = __DIR__;
require_once("templates/footer.php");

?>