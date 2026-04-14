CREATE DATABASE IF NOT EXISTS taller_electronicos;
USE taller_electronicos;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

INSERT INTO usuarios (username, password) VALUES ('admin', '1234');

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    direccion VARCHAR(150)
);

CREATE TABLE equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    tipo_equipo VARCHAR(50) NOT NULL,
    marca VARCHAR(50),
    modelo VARCHAR(50),
    num_serie VARCHAR(50),
    descrip_falla TEXT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE tecnico (
    id_tecnico INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    telefono VARCHAR(20),
    especialidad VARCHAR(50)
);

INSERT INTO tecnico (nombre, telefono, especialidad) VALUES
('Juan Pérez', '8091111111', 'Hardware'),
('María López', '8092222222', 'Software'),
('Carlos Díaz', '8093333333', 'Redes');

CREATE TABLE reparaciones (
    id_reparacion INT AUTO_INCREMENT PRIMARY KEY,
    id_equipo INT NOT NULL,
    id_tecnico INT,
    fecha_ingreso DATETIME,
    estado VARCHAR(50),
    costo_estimado DECIMAL(10,2),
    FOREIGN KEY (id_equipo) REFERENCES equipos(id_equipo)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (id_tecnico) REFERENCES tecnico(id_tecnico)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_reparacion INT NOT NULL,
    fecha_pago DATE,
    monto DECIMAL(10,2),
    metodo_pago VARCHAR(40),
    FOREIGN KEY (id_reparacion) REFERENCES reparaciones(id_reparacion)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);