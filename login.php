<?php
include "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    try {
        $sql = "SELECT usuario, password FROM usuarios WHERE usuario = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioData && password_verify($password, $usuarioData["password"])) {
            $_SESSION["usuario"] = $usuarioData["usuario"];
            header("Location: tareas.php");
            exit;
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/login-styles.css">
    <title>Iniciar Sesión</title>
</head>
<body>

<div class="container">
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">

        <div class="input-container">
            <span class="icon">👤</span>
            <input type="text" name="usuario" placeholder="Usuario" required><br><br>
        </div>

        <div class="input-container">
            <span class="icon">🔒</span>
            <input type="password" name="password" placeholder="Contraseña" required><br><br>
        </div>

        <p class="ingresar">¿No Tienes Cuenta? Presione <a href="registro.php" id="ingresar">&nbsp;Aquí</a></p>

        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
