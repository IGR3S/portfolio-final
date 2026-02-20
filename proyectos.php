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
function obtenerProyectos($conexion, $categoria)
{
    if ($categoria != null) {
        $sql = "SELECT p.id, p.titulo, p.descripcion, c.nombre AS categoria, p.imagen, GROUP_CONCAT(t.nombre SEPARATOR ', ') AS tecnologias
        FROM proyectos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        INNER JOIN proyecto_tecnologia pt ON p.id = pt.proyecto_id
        INNER JOIN tecnologias t ON pt.tecnologia_id = t.id
        WHERE c.nombre = ?
        GROUP BY p.id;";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$categoria]);
    } else {
        $sql = "SELECT p.id,p.titulo,p.descripcion,c.nombre AS categoria,p.imagen,GROUP_CONCAT(t.nombre SEPARATOR ', ') AS tecnologias
        FROM proyectos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        INNER JOIN proyecto_tecnologia pt ON p.id = pt.proyecto_id
        INNER JOIN tecnologias t ON pt.tecnologia_id = t.id
        GROUP BY p.id;";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    }
    $resultado = $stmt->fetchAll();
    return $resultado;
}
$cat = $_GET['cat'] ?? null;
$fil = $_GET['fil'] ?? null;
?>