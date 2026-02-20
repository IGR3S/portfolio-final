<?php

if (is_dir($rutaBase . "/static")) {
    $rutaStatic = "static/";
} else {
    $rutaStatic = "../static/";
}

?>
<footer>
    <div class="centro">
        <div class ="contacto">
            <h2>Contacto</h2>
            <img src="<?= $rutaStatic ?>/img/iconoTelf.png" class="logoLink">
            <a href="">+34 640 27 35 32</a>
            <br>
            <img src="<?= $rutaStatic ?>/img/iconoMail.png" class="logoLink">
            <a href="">sergiesbe@gmail.com</a>
        </div>
        <div class ="redesSociales">
            <h2>Redes Sociales</h2>
            <img src="<?= $rutaStatic ?>/img/iconoX.png" class="logoLink">
            <img src="<?= $rutaStatic ?>/img/iconoLinkedin.png" class="logoLink">
            <img src="<?= $rutaStatic ?>/img/iconoGitHUB.png" class="logoLink">
            <br><br><br>

        </div>
        <div class ="portfolio">
            <h2>Portfolio</h2>
            <p>Los mejores desarrollos en Frontend, <br>Backend y Fullstack.</p>
            <br>
            <p>© 2025 Sergi Espinosa Belén</p>
            <br>
        </div>
    </div>
</footer>
    
</body>
</html>