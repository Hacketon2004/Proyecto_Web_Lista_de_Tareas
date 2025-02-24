<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encriptar contraseña

    try {
        $sql = "INSERT INTO usuarios (usuario, email, password) VALUES (:usuario, :email, :password)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        echo "✅ Usuario registrado con éxito.";
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
    <link rel="stylesheet" href="Styles/styles-registro.css">
    <title>Registro de Usuario</title>
</head>
<body>
<div class="container">
    <h2>BIENVENID@</h2>
    <form action="registro.php" method="POST">
        
    <div class="input-container">
    <span class="icon">👤</span>
    <input type="text" name="usuario" placeholder="Usuario" required>
    </div>

    <div class="input-container">
    <span class="icon">@</span>
    <input type="email" name="email" placeholder="ejemplo@gmail.com" required>
    </div>

    <div class="input-container">
    <span class="icon">🔒</span>
    <input type="password" name="password" placeholder="Contraseña" required>
    </div>
        <p class="ingresar">¿Ya tiene cuenta? Presione <a href="login.php" id="ingresar">&nbsp;Aquí</a></p>
        <button type="submit">Registrar</button>
    </form>
</div>

</body>
</html>
