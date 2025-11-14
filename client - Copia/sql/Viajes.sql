-- phpMyAdmin SQL Dump
-- versión 5.2.2
-- Servidor: db
-- Base de datos: Viajes
-- Autor: ChatGPT GPT-5
-- Fecha de generación: 08-11-2025

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS Viajes;
CREATE DATABASE Viajes CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE Viajes;

-- --------------------------------------------------------
-- Tabla CITY
-- --------------------------------------------------------
CREATE TABLE `city` (
  `idciudad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idciudad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `city` (`nombre`) VALUES
('Madrid'),
('Barcelona'),
('París'),
('Roma'),
('Londres'),
('Berlín'),
('Ámsterdam'),
('Lisboa'),
('Praga'),
('Viena');

-- --------------------------------------------------------
-- Tabla CLIENT
-- --------------------------------------------------------
CREATE TABLE `client` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `telefono` BIGINT NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `activo` TINYINT(1) NOT NULL,
  `fecharegistro` DATETIME NOT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `client` (`nombre`, `telefono`, `email`, `activo`, `fecharegistro`) VALUES
('Juan Pérez', 654321987, 'juan.perez@email.com', 1, NOW()),
('María López', 611223344, 'maria.lopez@email.com', 1, NOW()),
('Carlos Gómez', 678901234, 'carlos.gomez@email.com', 1, NOW()),
('Laura Fernández', 699887766, 'laura.fernandez@email.com', 0, NOW()),
('Pedro Martínez', 612345678, 'pedro.martinez@email.com', 1, NOW()),
('Ana Torres', 698765432, 'ana.torres@email.com', 1, NOW()),
('Luis Ramos', 634567890, 'luis.ramos@email.com', 1, NOW()),
('Carmen Ruiz', 655443322, 'carmen.ruiz@email.com', 0, NOW()),
('Sofía Díaz', 677889900, 'sofia.diaz@email.com', 1, NOW()),
('Miguel Sánchez', 699000111, 'miguel.sanchez@email.com', 1, NOW());

-- --------------------------------------------------------
-- Tabla TRIP
-- --------------------------------------------------------
CREATE TABLE `trip` (
  `idviaje` INT NOT NULL AUTO_INCREMENT,
  `iddestino` INT NOT NULL,
  `fechasalida` DATETIME NOT NULL,
  `fecharegreso` DATETIME NOT NULL,
  `duracion` INT NOT NULL,
  `preciobase` FLOAT NOT NULL,
  `idorigen` INT NOT NULL,
  `cocheHotel` TINYINT(1) NOT NULL,
  PRIMARY KEY (`idviaje`),
  KEY `fk_city_trip_origen` (`idorigen`),
  KEY `fk_city_trip_destino` (`iddestino`),
  CONSTRAINT `fk_city_trip_destino` FOREIGN KEY (`iddestino`) REFERENCES `city` (`idciudad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_city_trip_origen` FOREIGN KEY (`idorigen`) REFERENCES `city` (`idciudad`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `trip` (`iddestino`, `fechasalida`, `fecharegreso`, `duracion`, `preciobase`, `idorigen`, `cocheHotel`) VALUES
(3, '2025-12-01 08:00:00', '2025-12-07 22:00:00', 7, 1200.50, 1, 1),
(4, '2025-12-10 09:00:00', '2025-12-15 21:30:00', 5, 950.00, 2, 0),
(5, '2026-01-05 10:00:00', '2026-01-12 20:00:00', 7, 1500.75, 3, 1),
(6, '2026-02-01 07:00:00', '2026-02-08 22:00:00', 8, 1300.00, 4, 1),
(7, '2026-02-20 06:30:00', '2026-02-27 23:00:00', 7, 1100.00, 5, 0),
(8, '2026-03-05 09:00:00', '2026-03-10 21:00:00', 5, 980.00, 6, 1),
(9, '2026-03-15 10:00:00', '2026-03-22 19:00:00', 7, 1050.00, 7, 1),
(10, '2026-04-01 08:00:00', '2026-04-07 22:00:00', 6, 1150.00, 8, 0),
(2, '2026-04-15 09:00:00', '2026-04-22 20:30:00', 7, 1250.00, 9, 1),
(1, '2026-05-01 07:30:00', '2026-05-08 22:30:00', 7, 1400.00, 10, 1);

-- --------------------------------------------------------
-- Tabla PACKAGE
-- --------------------------------------------------------
CREATE TABLE `package` (
  `idpaquete` INT NOT NULL AUTO_INCREMENT,
  `nombrepaquete` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `preciopaquete` FLOAT NOT NULL,
  `incluyehotel` TINYINT(1) NOT NULL,
  `idviaje` INT NOT NULL,
  `contratacion` DATETIME NOT NULL,
  `idcliente` INT NOT NULL,
  PRIMARY KEY (`idpaquete`),
  KEY `idviaje` (`idviaje`),
  KEY `fk_client_package` (`idcliente`),
  CONSTRAINT `fk_client_package` FOREIGN KEY (`idcliente`) REFERENCES `client` (`idcliente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `package_ibfk_1` FOREIGN KEY (`idviaje`) REFERENCES `trip` (`idviaje`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `package` (`nombrepaquete`, `descripcion`, `preciopaquete`, `incluyehotel`, `idviaje`, `contratacion`, `idcliente`) VALUES
('Escapada Romántica a París', 'Incluye vuelo + hotel 4 estrellas + cena en restaurante.', 1800.00, 1, 1, NOW(), 1),
('Vacaciones en Roma', 'Paquete de 5 días con tours guiados y transporte incluido.', 1200.00, 0, 2, NOW(), 2),
('Viaje Londres Deluxe', 'Incluye vuelo, hotel y actividades exclusivas.', 2200.00, 1, 3, NOW(), 3),
('Tour por Berlín', 'Recorre los principales puntos históricos.', 1300.00, 1, 4, NOW(), 4),
('Aventura en Ámsterdam', 'Tour de 7 días con bicicleta incluida.', 1450.00, 0, 5, NOW(), 5),
('Descubre Lisboa', 'Vuelo + hotel + paseo en tranvía.', 1000.00, 1, 6, NOW(), 6),
('Encantos de Praga', 'Incluye alojamiento y excursiones guiadas.', 1250.00, 1, 7, NOW(), 7),
('Fin de semana en Viena', 'Oferta especial de 3 noches.', 890.00, 1, 8, NOW(), 8),
('Escapada a Barcelona', 'Ideal para parejas con poco tiempo.', 950.00, 0, 9, NOW(), 9),
('Gran Tour Europeo', 'Ruta de 10 días por varias capitales.', 3000.00, 1, 10, NOW(), 10);

COMMIT;
