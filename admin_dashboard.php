<?php
// admin/dashboard.php
session_start();
require_once '../includes/db.php';

$query = "SELECT p.id, p.titulo, p.fecha_publicacion, c.nombre AS categoria FROM publicaciones p
          LEFT JOIN categorias c ON p.categoria_id = c.id
          ORDER BY p.fecha_publicacion DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración | Ab Ovo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Panel de Publicaciones</h2>
    <a href="agregar_post.php" class="btn btn-success mb-3">+ Nueva Publicación</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['titulo']) ?></td>
                <td><?= $row['categoria'] ?></td>
                <td><?= $row['fecha_publicacion'] ?></td>
                <td>
                    <a href="editar_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    <a href="eliminar_post.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta publicación?');">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<!-- admin/agregar_post.php -->
<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);
    $imagen = $_POST['imagen'];
    $video_url = $_POST['video_url'];
    $fecha_publicacion = $_POST['fecha_publicacion'];
    $autor_id = 1;
    $categoria_id = $_POST['categoria_id'];

    $query = "INSERT INTO publicaciones (titulo, contenido, imagen, video_url, fecha_publicacion, autor_id, categoria_id)
              VALUES ('$titulo', '$contenido', '$imagen', '$video_url', '$fecha_publicacion', '$autor_id', '$categoria_id')";
    mysqli_query($conn, $query);
    header('Location: dashboard.php');
    exit;
}

$categorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Nueva Publicación</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Título</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contenido</label>
            <textarea name="contenido" class="form-control" rows="5"></textarea>
        </div>
        <div class="mb-3">
            <label>Imagen (nombre de archivo)</label>
            <input type="text" name="imagen" class="form-control">
        </div>
        <div class="mb-3">
            <label>Video URL</label>
            <input type="text" name="video_url" class="form-control">
        </div>
        <div class="mb-3">
            <label>Fecha de Publicación</label>
            <input type="date" name="fecha_publicacion" class="form-control">
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria_id" class="form-control">
                <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>

<!-- admin/editar_post.php, admin/eliminar_post.php y publicacion.php se generarán a continuación -->
