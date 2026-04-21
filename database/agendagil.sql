CREATE TABLE roles (
    idRol INT AUTO_INCREMENT,
    nombreRol VARCHAR(50) NOT NULL,
    PRIMARY KEY (idRol)
);

CREATE TABLE usuarios (
    idUsuario INT AUTO_INCREMENT,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contraseña VARCHAR(255),
    idRol INT,
    reset_token VARCHAR(64),
    token_expira DATETIME,    
    PRIMARY KEY (idUsuario),
    FOREIGN KEY (idRol) REFERENCES roles(idRol)
);

CREATE TABLE pacientes (
    idPaciente INT AUTO_INCREMENT,
    idUsuario INT,
    telefono VARCHAR(15),
    fechaNacimiento DATE,
    PRIMARY KEY (idPaciente),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE TABLE dentistas (
    idDentista INT AUTO_INCREMENT,
    idUsuario INT,
    especialidad VARCHAR(100),
    PRIMARY KEY (idDentista),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario)
);

CREATE TABLE tratamientos (
    idTratamiento INT AUTO_INCREMENT,
    nombreTratamiento VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(10,2),
    PRIMARY KEY (idTratamiento)
);

CREATE TABLE citas (
    idCita INT AUTO_INCREMENT,
    idPaciente INT,
    idDentista INT,
    idTratamiento INT,
    descripcion TEXT,
    fecha DATE,
    hora TIME,
    estado VARCHAR(50),
    PRIMARY KEY (idCita),
    FOREIGN KEY (idPaciente) REFERENCES pacientes(idPaciente),
    FOREIGN KEY (idDentista) REFERENCES dentistas(idDentista),
    FOREIGN KEY (idTratamiento) REFERENCES tratamientos(idTratamiento)
);

CREATE TABLE historialclinico (
    idHistorial INT AUTO_INCREMENT,
    idPaciente INT,
    idCita INT,
    motivoConsulta TEXT,
    diagnostico TEXT,
    tratamientoAplicado TEXT,
    observaciones TEXT,
    fechaRegistro DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idHistorial),
    FOREIGN KEY (idPaciente) REFERENCES pacientes(idPaciente),
    FOREIGN KEY (idCita) REFERENCES citas(idCita)
);

CREATE TABLE horarios (
    idHorario INT AUTO_INCREMENT,
    idDentista INT,
    diaSemana VARCHAR(20),
    horaInicio TIME,
    horaFin TIME,
    PRIMARY KEY (idHorario),
    FOREIGN KEY (idDentista) REFERENCES dentistas(idDentista)
);
