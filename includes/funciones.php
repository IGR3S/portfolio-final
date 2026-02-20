<?php

function obtenerProyectos($conexion, $categoria)
{
    if ($categoria != null && $categoria != 'Todas') {
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

function generarSelect($conexion, $todas = true){
    $select = "<select name='cat'>";
    if($todas){
        $select .= "<option> TODAS </option>";
    }
    $sql = "SELECT DISTINCT nombre FROM categorias";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach ($resultado as $r) {
        $select .= "<option value='{$r['nombre']}'>".$r['nombre'] ."</option>";
    }
    $select .= "</select>";
    return $select;
}

?>