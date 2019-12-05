CREATE DATABASE IF NOT EXISTS caaind;
CREATE TABLE IF NOT EXISTS Usuario(
    matricula char(10),
    email char(70) NOT NULL,
    pw_hash char(255) NOT NULL,
    PRIMARY KEY (matricula)
);

CREATE TABLE IF NOT EXISTS Alumno(
    matricula char(10),
    nombre char(60),
    PRIMARY KEY (matricula)
);