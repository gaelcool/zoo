DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS reservas;
 
CREATE TABLE usuarios (
    id_usr INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(50) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL
);

CREATE TABLE reservas (
    id_reserva INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usr INTEGER NOT NULL,
    tipo_tour VARCHAR(20) NOT NULL,
    fecha_visita DATE NOT NULL,
    cantidad_adultos INTEGER DEFAULT 0,
    cantidad_menores INTEGER DEFAULT 0,
    cantidad_ninos INTEGER DEFAULT 0,
    precio_total DECIMAL(10,2) NOT NULL,
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usr) REFERENCES usuarios(id_usr)
);

-- Demo users with hashed passwords
-- Password for Mechy: 'password' (hashed)
INSERT INTO usuarios (usuario, nombre, correo, clave) VALUES (
    'Mechy',
    'Gael Méndez',
    'gael@zoolandia.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
);

-- Password for Jimmy: 'password123' (hashed)
INSERT INTO usuarios (usuario, nombre, correo, clave) VALUES (
    'Jimmy',
    'James Rodriguez',
    'jimmy@zoolandia.com',
    '$2y$10$eUmiGjrO3bHRWZqB/j.8CeJKZIxH5gD.dWHZxMkE3Qs7l8qPm7Ppm'
);