<?php 

    require_once("templates/header.php");

    if(isset($_COOKIE['visitas'])){
        $visitas = (int)$_COOKIE['visitas'] + 1;
    }else{
        $visitas = 1;
    }
    setcookie("visitas", $visitas, time()+3600, "/");
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
$rutaBase = __DIR__;
    require_once("templates/footer.php");

?>