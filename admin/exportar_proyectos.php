<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/conexion.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/portfolio-final/includes/funciones.php");

$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=proyectos.csv');

    $output = fopen('php://output', 'w');

    fputcsv($output, ['Título', 'Descripción', 'Categoría', 'Tecnologías'], ';');

    $sql = "SELECT 
                p.titulo,
                p.descripcion,
                c.nombre AS categoria,
                GROUP_CONCAT(t.nombre SEPARATOR ', ') AS tecnologias
            FROM proyectos p
            JOIN categorias c ON p.categoria_id = c.id
            LEFT JOIN proyecto_tecnologia pt ON p.id = pt.proyecto_id
            LEFT JOIN tecnologias t ON pt.tecnologia_id = t.id
            GROUP BY p.id";

    $stmt = $conexion->query($sql);

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $fila, ';');
    }

    fclose($output);
    exit;

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}