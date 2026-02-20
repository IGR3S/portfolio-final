<?php
require_once("../templates/header_admin.php");

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
    <h1>Administracion de proyectos</h1>
    <div class="filtroCat">
    <form action="panel.php" method="get" >
        <form action="" method="get">
            <label>Filtro por categoria: </label>
            <?php
               $select = generarSelect($conexion, true);
               echo $select;
            ?>
            <input type="submit" value="Filtrar">
        </form>
    </div>
    <div class="botonesSobreTabla">
        <a href="exportar_proyectos.php" id="botonAzul">Exportar CSV</a>
        <a href="proyecto_nuevo.php" id="botonVerde">Nuevo proyecto</a>
        <a href="../logout.php" id="botonRojo">Cerrar sesion</a>
    </div>
    
    <br><br>
    <table border="1">
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Categoria</th>
            <th>Tecnologias</th>
            <th>Acciones</th>
        </tr>

        <?php $resultado = obtenerProyectos($conexion, $cat);
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
               <tr>
                  <td><?= $a['titulo'] ?></td>
                  <td><?= $a['descripcion'] ?></td>
                  <td><?= $a['categoria'] ?></td>
                  <?php 
                  foreach ($a['tecnologias'] as $tec) { ?>
                     <td><?= $tec ?></td>
                  <?php 
                  } ?>
                  <td class="botonesTabla">
                     <form action="proyecto_editar.php" method="post">
                        <input type="hidden" value="<?= $a['id'] ?>" name="id">
                        <input type="submit" value="Editar" id="botonAzul">
                     </form>
                     <form action="proyecto_borrar.php" method="post">
                        <input type="hidden" value="<?= $a['id'] ?>" name="id">
                        <input type="submit" value="Borrar" id="botonRojo">
                     </form>
               </td>
               </tr>
        <?php } ?>
    </table>
</main>

<?php
$rutaBase = __DIR__;
require_once '../templates/footer.php';
?>