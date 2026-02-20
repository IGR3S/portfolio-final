<?php
require_once '../templates/header_admin.php';
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== "admin") {
    header('Location: ../login.php');
    exit();
}
if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
} else {
    $categoria = "todas";
}
?>
<main>
    <h1>Administracion de proyectos (admin)</h1>

    <form action="panel.php" method="get">
        <form action="" method="get">
         <p>Filtro por categoria: </p>
         <?php
            $select = generarSelect($conexion, true);
            echo $select;
         ?>
         <input type="submit" value="Filtrar">
      </form>
    <a href="exportar_proyectos.php" class="boton-azul">Exportar CSV</a>
    <a href="proyecto_nuevo.php" class="boton-verde">Nuevo proyecto</a>
    <a href="logout.php" class="logout">Cerrar sesion</a>
    <br><br>
    <table border="1">
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Categoria</th>
            <th>Tecnologias</th>
            <th>Acciones</th>
        </tr>

        <?php foreach (obtenerProyectos($conexion, $categoria) as $proyecto) {
            ?>
            <tr>
                <td>
                    <?= $proyecto['titulo'] ?>
                </td>
                <td>
                    <?= $proyecto['descripcion'] ?>
                </td>

                <td>
                    <?= $proyecto['categoria_nombre'] ?>
                </td>
                <td>
                    <?= $proyecto["tecnologias"]?>
                </td>
                <td>
                    <a href="proyecto_editar.php?id=<?= $proyecto['id'] ?>" class="boton-azul">Editar</a><a href="proyecto_borrar.php?id=<?= $proyecto['id'] ?>" class="logout">Borrar</a>
                </td>
            </tr>
            <?php
            //revisar porque da problemas en la linea 27 del funciones.php
        } ?>

    </table>
</main>

<?php
require_once '../templates/footer.php';
?>