<?php
include('includes/db.php');
include('includes/header.php');

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT p.*, c.nombre AS categoria, u.nombre AS autor 
              FROM publicaciones p
              LEFT JOIN categorias c ON p.categoria_id = c.id
              LEFT JOIN usuarios u ON p.autor_id = u.id
              WHERE p.id = '$id' AND estado = 'publicado'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
?>

<div class='container mt-5'>
    <article class='mb-5'>
        <h1><?= htmlspecialchars($row['titulo']) ?></h1>
        <p class='text-muted'>Por <?= $row['autor'] ?> | <?= date('d/m/Y', strtotime($row['fecha_publicacion'])) ?> | <?= $row['categoria'] ?></p>
        
        <?php if($row['imagen']): ?>
            <img src="assets/images/<?= htmlspecialchars($row['imagen']) ?>" class="img-fluid mb-4" alt="Imagen destacada">
        <?php endif; ?>
        
        <div class='contenido-publicacion'>
            <?= $row['contenido'] ?>
        </div>
    </article>
</div>

<?php
    } else {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Publicación no encontrada</div></div>";
    }
} else {
    header("Location: index.php");
    exit();
}

include('includes/footer.php');
?>