<?php include('includes/db.php'); ?>
<?php include('includes/header.php'); ?>

<?php
// Nueva consulta SQL agregada
$query = "SELECT p.*, c.nombre AS categoria, u.nombre AS autor
          FROM publicaciones p
          LEFT JOIN categorias c ON p.categoria_id = c.id
          LEFT JOIN usuarios u ON p.autor_id = u.id
          WHERE estado = 'publicado'
          ORDER BY fecha_publicacion DESC
          LIMIT 6";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid hero-bg">
    <div class="container py-5">
        <h1 class="display-4 fw-bold text-white text-center mb-4">Ab Ovo – El Regreso</h1>
        <p class="lead text-center text-white-50 mb-5">Explora las últimas publicaciones sobre cultura y arte contemporáneo</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 border-0 shadow-lg hover-effect">
                <?php if ($row['imagen']): ?>
                <div class="card-img-top overflow-hidden" style="height: 250px;">
                    <img src="assets/images/<?= htmlspecialchars($row['imagen']) ?>" 
                         class="img-fluid w-100 h-100 object-fit-cover" 
                         alt="<?= htmlspecialchars($row['titulo']) ?>">
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge rounded-pill bg-primary mb-2"><?= $row['categoria'] ?></span>
                    <h3 class="h5 card-title fw-bold"><?= htmlspecialchars($row['titulo']) ?></h3>
                    <p class="card-text text-muted"><?= substr(strip_tags($row['contenido']), 0, 120) ?>...</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><?= date("d/m/Y", strtotime($row['fecha_publicacion'])) ?></small>
                        <a href="publicacion.php?id=<?= $row['id'] ?>" class="btn btn-link text-decoration-none">
                            Leer más <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>
