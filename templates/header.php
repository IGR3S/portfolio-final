<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/conexion.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/funciones.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel ="stylesheet" href="static/css/estiloNormal.css">
</head>
<body>
    <header>
        <div class = "centro">
            <div class="lista">
                <a href="inicio.php"><img class="logo" src="static/img/LogoTransp.png" alt="" height="70px"></a>
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    <li><a href="proyectos.php">Proyectos</a></li>
                    <?php
                    $sql = "SELECT DISTINCT nombre FROM categorias";
                    $stmt = $conexion->prepare($sql);
                    $stmt->execute();
                    $resultado = $stmt->fetchAll();
                    foreach ($resultado as $a) {
                    ?>
                        <li><a href="proyecto.php?cat=<?= $a["nombre"] ?>"><?= $a["nombre"] ?></a></li>
                    <?php
                    }
                    ?>
                    <li><a href="contacto.php">Contacto</a></li>
                    <?php
                    //Si se ha iniciado sesion, administracion y cerrar sesion, sino login
                            if(isset($_SESSION['admin'])){
                        ?>
                            <li><button id="botonVerde"><a href="admin/panel.php">Administracion</a></button></li>  
                            <li><button id="botonRojo"><a href="logout.php">Cerrar Sesion</a></button></li>
                        <?php
                            } else {
                        ?>
                            <li><button id="botonVerde"><a href="./login.php">Login</a></button></li>
                        <?php } ?> 
                    
                </ul>
            </div>
        </div>
    </header>

