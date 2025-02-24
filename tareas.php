<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];

// Insertar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tarea"])) {
    $tarea = trim($_POST["tarea"]);
    $sql = "INSERT INTO tareas (tarea, usuario) VALUES (:tarea, :usuario)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":tarea", $tarea);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();
}

// Marcar como completada
if (isset($_GET["completar"])) {
    $id = $_GET["completar"];
    $sql = "UPDATE tareas SET completado = 1 WHERE id = :id AND usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();
}

// Eliminar tarea
if (isset($_GET["eliminar"])) {
    $id = $_GET["eliminar"];
    $sql = "DELETE FROM tareas WHERE id = :id AND usuario = :usuario";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="Styles/styles.css">
</head>
<body>
    <div class="container">
    <h2>Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</h2>
    <h2>📋 Lista de Tareas</h2>
    <form action="tareas.php" method="POST" class="action-insert">
        <input type="text" name="tarea" placeholder="Escribe Aquì" required>
        <button class="agregar" type="submit">+</button>
    </form>
    
    <h3 class='sub-tittle'>Tareas Pendientes:</h3>
    <ul>
        <?php
        $sql = "SELECT id, tarea, completado FROM tareas WHERE usuario = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":usuario", $usuario);
        $stmt->execute();
        $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tareas as $t) {
            echo "<li>";
            echo $t["completado"] ? "✅" : "❌";
            echo " <span class='tarea-texto'>" . $t["tarea"] . "</span>";
            echo " <a href='tareas.php?completar=" . $t["id"] . "' class='check'>✔</a> ";
            echo " <a href='tareas.php?eliminar=" . $t["id"] . "' class='no-check'>✘</a>";
            echo "</li>";
        }
        ?>
    </ul>
    </div>

    <div class="contenedor-btn">
    <a href="logout.php">
        <button class="Btn">
            <div class="sign">
                <svg viewBox="0 0 512 512">
                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                </svg>
            </div>
            <div class="text">Salir</div>
        </button>
    </a>
    </div>

</body>
</html>
