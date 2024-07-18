CREATE DATABASE IF NOT EXISTS escrito_2_martin_acosta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE escrito_2_martin_acosta;

-- Tabla personas
CREATE TABLE personas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    telefono VARCHAR(100) NOT NULL
);
