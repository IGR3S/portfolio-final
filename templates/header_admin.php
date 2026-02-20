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
    <link rel ="stylesheet" href="../static/css/estiloAdmin.css">
</head>
<body>
    <header>
        <div class = "centroHead">
            <ul>
                <li><a href="../inicio.php">IR A INICIO</a></li>
            </ul>
        </div>
    </header>