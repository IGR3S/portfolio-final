<?php
require_once("../templates/header_admin.php");

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== "admin") {
    header("Location: ../login.php");
    exit();
}else{
    $errores = [];
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    if (!$id || !ctype_digit((string)$id)) {
        header('Location: panel.php');
        exit();
    }
    $stmt = $conexion->prepare("SELECT p.*, c.nombre AS categoria_nombre
                                 FROM proyectos p
                                 INNER JOIN categorias c ON p.categoria_id = c.id
                                 WHERE p.id = ?");
    $stmt->execute([$id]);
    $proyecto = $stmt->fetch();
    if (!$proyecto) {
        header('Location: panel.php');
        exit();
    }
    $stmtTA = $conexion->prepare("SELECT tecnologia_id FROM proyecto_tecnologia WHERE proyecto_id = ?");
    $stmtTA->execute([$id]);
    $tecsActuales = $stmtTA->fetchAll(PDO::FETCH_COLUMN);

    $stmtCats = $conexion->query("SELECT id, nombre FROM categorias ORDER BY nombre");
    $listaCategorias = $stmtCats->fetchAll();

    $stmtTecs = $conexion->query("SELECT id, nombre FROM tecnologias ORDER BY nombre");
    $listaTecnologias = $stmtTecs->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo       = trim($_POST['titulo'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $categoria_id = $_POST['categoria_id'] ?? '';
        $tecs_ids     = $_POST['tecnologias'] ?? [];
        if (empty($titulo))       $errores[] = "El título es obligatorio.";
        if (empty($descripcion))  $errores[] = "La descripción es obligatoria.";
        if (empty($categoria_id)) $errores[] = "Debes seleccionar una categoría.";
        if (empty($tecs_ids))     $errores[] = "Debes seleccionar al menos una tecnología.";
        $nombreImagen = $proyecto['imagen'];
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $tipoArchivo = mime_content_type($_FILES['imagen']['tmp_name']);

            if (!in_array($tipoArchivo, $tiposPermitidos)) {
                $errores[] = "Solo se permiten imágenes (JPG, PNG, GIF, WEBP).";
            } else {
                $extension         = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $nombreImagenNueva = uniqid('img_', true) . '.' . strtolower($extension);
                $rutaDestino       = __DIR__ . '/../static/img/' . $nombreImagenNueva;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $rutaAnterior = __DIR__ . '/../static/img/' . $proyecto['imagen'];
                    if (file_exists($rutaAnterior)) unlink($rutaAnterior);
                    $nombreImagen = $nombreImagenNueva;
                } else {
                    $errores[] = "Error al subir la imagen al servidor.";
                }
            }
        }
        if (empty($errores)) {
            $stmtUp = $conexion->prepare("UPDATE proyectos SET titulo=?, descripcion=?, categoria_id=?, imagen=? WHERE id=?");
            $stmtUp->execute([$titulo, $descripcion, $categoria_id, $nombreImagen, $id]);

            $conexion->prepare("DELETE FROM proyecto_tecnologia WHERE proyecto_id = ?")->execute([$id]);
            $stmtTec = $conexion->prepare("INSERT INTO proyecto_tecnologia (proyecto_id, tecnologia_id) VALUES (?, ?)");
            foreach ($tecs_ids as $tec_id) {
                $stmtTec->execute([$id, $tec_id]);
            }

            header('Location: panel.php?ok=editado');
            exit();
        }
        $proyecto['titulo']       = $titulo;
        $proyecto['descripcion']  = $descripcion;
        $proyecto['categoria_id'] = $categoria_id;
        $tecsActuales             = $tecs_ids;
    }
    ?>
    <main>
        <h1>Editar proyecto (admin)</h1>
        <?php if (!empty($errores)): ?>
            <div>
                <?php foreach ($errores as $e): ?>
                    <p>&#10007; <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="proyecto_editar.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div>
                <div>
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo"
                           value="<?= htmlspecialchars($proyecto['titulo']) ?>">
                </div>
                <div>
                    <label for="categoria_id">Categoría</label>
                    <select id="categoria_id" name="categoria_id">
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($listaCategorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= $proyecto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
            </div>
            <div>
                <div>
                    <label for="tecnologias">Tecnologías <small>(Ctrl+clic para seleccionar varias)</small></label>
                    <select id="tecnologias" name="tecnologias[]" multiple>
                        <?php foreach ($listaTecnologias as $tec): ?>
                            <option value="<?= $tec['id'] ?>"
                                <?= in_array($tec['id'], $tecsActuales) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tec['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Imagen actual</label>
                    <img src="../static/img/<?= htmlspecialchars($proyecto['imagen']) ?>"
                         alt="imagen actual">
                    <label for="imagen_nueva">Nueva imagen <small>(opcional)</small></label>
                    <input type="file" id="imagen_nueva" name="imagen" accept="image/*">
                </div>
            </div>
            <div>
                <a href="panel.php">Cancelar</a>
                <button type="submit">Guardar cambios</button>
            </div>

        </form>
    </main>
    <?php } ?>