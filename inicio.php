<?php 

    require_once("templates/header.php");

    if(isset($_COOKIE['vistas'])){
        $vistas = (int)$_COOKIE['vistas'] + 1;
    }else{
        $vistas = 1;
    }
    setcookie("vistas", $vistas, time()+3600, "/");
?>

<div class="centro">
    <div class="presentacion">
        <img src="static/img/LogoFondo.jpg" class="logoFondo">
        <h2>Bienvenido a mi Portfolio</h2>
        <br>
        <p>Explora mis proyectos y trabajos destacados</p>
        <br>
        <p>Has visitado la pagina <?= $visitas ?> veces.</p>
    </div>
</div>


<?php 

    require_once("templates/footer.php");

?>