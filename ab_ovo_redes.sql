
-- Base de datos
CREATE DATABASE IF NOT EXISTS ab_ovo_redes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ab_ovo_redes;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('admin', 'editor') DEFAULT 'editor',
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE
);

-- Tabla de publicaciones
CREATE TABLE IF NOT EXISTS publicaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255),
    contenido TEXT,
    imagen VARCHAR(255),
    video_url VARCHAR(255),
    fecha_publicacion DATE,
    autor_id INT,
    categoria_id INT,
    estado ENUM('publicado', 'borrador') DEFAULT 'publicado',
    FOREIGN KEY (autor_id) REFERENCES usuarios(id),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabla de comentarios
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id INT,
    nombre VARCHAR(100),
    email VARCHAR(100),
    comentario TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    aprobado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id)
);

-- Tabla de eventos
CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255),
    descripcion TEXT,
    fecha_evento DATE,
    lugar VARCHAR(255),
    imagen_evento VARCHAR(255),
    publicado BOOLEAN DEFAULT TRUE
);

-- Tabla de mensajes de contacto
CREATE TABLE IF NOT EXISTS mensajes_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100),
    mensaje TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Datos de ejemplo
INSERT INTO usuarios (nombre, email, password, rol) VALUES 
('Administrador', 'admin@abovo.com', MD5('admin123'), 'admin');

INSERT INTO categorias (nombre) VALUES ('Humor'), ('Noticias'), ('Shows');

INSERT INTO publicaciones (titulo, contenido, imagen, video_url, fecha_publicacion, autor_id, categoria_id, estado)
VALUES 
('¡Volvimos al escenario!', 'Después de años de pausa, Ab Ovo regresa con nuevos sketches y el mismo humor de siempre.', 'abovo_retorno.jpg', '', CURDATE(), 1, 3, 'publicado'),
('Recuerdo de los 90s', 'Un clásico de nuestros inicios que marcó una época. ¿Te acordás?', 'clasico90.jpg', '', CURDATE(), 1, 1, 'publicado');
