<?php
require_once("../templates/header_admin.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== "admin") {
    header("Location: ../login.php");
    exit();
}else{  
    $id = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } elseif (isset($_POST['id'])) {
        $id = $_POST['id'];
    }

    if (!$id || !is_numeric($id)) {
        header('Location: panel.php');
        exit();
    }

    $stmt = $conexion->prepare("SELECT id, titulo, imagen FROM proyectos WHERE id = ?");
    $stmt->execute([$id]);
    $proyecto = $stmt->fetch();

    if (!$proyecto) {
        header('Location: panel.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
        $rutaImagen = "../static/img/" . $proyecto['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        $stmt2 = $conexion->prepare("DELETE FROM proyectos WHERE id = ?");
        $stmt2->execute([$id]);
        header('Location: panel.php?ok=borrado');
        exit();
    }
    ?>
    <main>
        <h1>Borrar proyecto</h1>
        <div>
            <p>¿Estás seguro de que deseas borrar el proyecto
                <strong><?= $proyecto['titulo'] ?></strong>
                (ID: <?= $proyecto['id'] ?>)?
            </p>
        </div>
        <div style="display:flex; gap:10px; margin-top:16px;">
            <a href="panel.php"><button type="button">Cancelar</button></a>

            <form action="proyecto_borrar.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="confirmar" value="1">
                <button type="submit">Borrar</button>
            </form>
        </div>
    </main>
    <?php
    }
    ?>