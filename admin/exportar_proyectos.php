<?php
require_once 'conexion.php'; // aquí debe estar tu objeto $conexion (PDO)

// Activar modo excepción (muy recomendable)
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {

    // Cabeceras para forzar descarga del CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=proyectos.csv');

    // Abrir salida directa al navegador
    $output = fopen('php://output', 'w');

    // Escribir cabecera del CSV
    fputcsv($output, ['Título', 'Descripción', 'Categoría', 'Tecnologías'], ';');

    // Consulta SIN filtros (todos los proyectos)
    $sql = "SELECT titulo, descripcion, categoria, tecnologias FROM proyectos";
    $stmt = $conexion->query($sql);

    // Recorrer resultados
    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $fila, ';');
    }

    fclose($output);
    exit;

} catch (PDOException $e) {

    // Si hay error, mostrar mensaje
    die("Error en la consulta: " . $e->getMessage());
}