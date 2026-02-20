<?php

require_once("templates/header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/conexion.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/funciones.php");

?>

<h2>Proyectos</h2>
    <form action="" method="get">
        <input class="filtro" type="text" name="fil">
        <button class="filtro" type="submit">Buscar</button>
    </form>
    <?php
    $resultado = obtenerProyectos($conexion, $cat);
    $proyectos = [];

    foreach ($resultado as $fila) {
        $id = $fila['id'];

        if (!isset($proyectos[$id])) {
            $proyectos[$id] = $fila;
            $proyectos[$id]['tecnologias'] = [];
        }

        $proyectos[$id]['tecnologias'][] = $fila['tecnologias'];
    }

    foreach ($proyectos as $a) {
        ?>
        <div class="caja">
            <img src="static/img/<?= $a['imagen'] ?>" height="200">
            <h3 class="izq"><?= $a['titulo'] ?></h3><br>
            <p class="izq"><?= $a['descripcion'] ?></p><br>
            <p class="izq"><strong>Categoria: </strong><?= $a['categoria'] ?></p>

            <span class="izq negrita">
                Tecnologias:
                <?php foreach ($a['tecnologias'] as $tec) { ?>
                    <span class="badge"><?= $tec ?></span>
                <?php } ?>
            </span>
        </div>
        <?php
    }
$rutaBase = __DIR__;
require_once("templates/footer.php");
?>