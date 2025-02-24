<?php
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $base_de_datos = "tareas_db";

    try{
        $conexion = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8", $usuario, $clave);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
?>