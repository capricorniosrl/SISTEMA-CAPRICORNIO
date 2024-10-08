CREATE TABLE tb_cargo(
    id_cargo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_cargo VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    estado VARCHAR(11) NOT NULL
);

CREATE TABLE tb_urbanizacion(
    id_urbanizacion INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_urbanizacion VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    estado VARCHAR(11) DEFAULT '1'
);


CREATE TABLE tb_usuarios(
    id_usuario INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ap_paterno VARCHAR(100) NOT NULL,
    ap_materno VARCHAR(100) NOT NULL,
    foto_perfil  VARCHAR(255) DEFAULT 'img/user.png',
    ci VARCHAR(20) NOT NULL UNIQUE,
    exp VARCHAR(10) NOT NULL,
    celular VARCHAR(10) NULL,
    cargo VARCHAR(255) NOT NULL,
    email VARCHAR(255)NOT NULL,
    direccion TEXT NOT NULL,
    password TEXT NOT NULL,
    id_cargo_fk int(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    estado VARCHAR(11) NOT NULL, 
    estado_guia INT DEFAULT 0, 
    FOREIGN KEY (id_cargo_fk) REFERENCES tb_cargo(id_cargo)

);




CREATE TABLE tb_contactos(
    id_contacto INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    celular INT(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    detalle VARCHAR(255),
    detalle_agenda VARCHAR(100),
    estado VARCHAR(11) NOT NULL,
    id_usuario_fk INT(11),
    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios(id_usuario)
);


CREATE TABLE tb_clientes(
    id_cliente INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(255),
    apellidos VARCHAR(255),
    ci_cliente INT(11),
    exp_cliente VARCHAR(20),
    tipo_urbanizacion VARCHAR(100),
    reprogramar VARCHAR(50),
    detalle_llamada VARCHAR(50),
    detalle TEXT,
    fecha_registro DATE,
    fecha_llamada DATE,
    hora_llamada TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    estado VARCHAR(11) NOT NULL,    
    id_usuario_fk INT(11),
    id_contacto_fk INT(11),
    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios(id_usuario),
    FOREIGN KEY (id_contacto_fk) REFERENCES tb_contactos(id_contacto)
);


CREATE TABLE tb_agendas(
    id_agenda INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fecha_visita DATE NOT NULL,
    visitantes VARCHAR(20) NOT NULL,
    detalle TEXT,
    estado VARCHAR(11),
    asistio ENUM('SI', 'NO') DEFAULT 'NO',

    detalle_agenda TEXT DEFAULT "SIN DETALLES",
    id_apoyo_fk int(11) DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,

    id_usuario_fk INT(11),
    id_cliente_fk INT(11),

    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios (id_usuario),
    FOREIGN KEY (id_cliente_fk) REFERENCES tb_clientes (id_cliente)
);


CREATE TABLE tb_designacion(
    id_designacion INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_agenda_fk INT(11),
    id_usuario_fk INT(11),

    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios(id_usuario),
    FOREIGN KEY (id_agenda_fk) REFERENCES tb_agendas(id_agenda)

);

CREATE TABLE tb_apoyo(
    id_apoyo INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_agenda_fk INT(11),
    id_usuario_fk INT(11),

    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios(id_usuario),
    FOREIGN KEY (id_agenda_fk) REFERENCES tb_agendas(id_agenda)

);

CREATE TABLE tb_informe(
    id_informe INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_agenda_fk INT(11),
    fecha_registro DATE,
    fecha_cierre DATE,
    tipo_pago VARCHAR(100),
    num_recibo VARCHAR(100),
    num_transferencia VARCHAR(100),
    monto INT(100),

    -- se aumento estos campos
    literal_monto VARCHAR(200) DEFAULT "CERO 00/100 BOLIVIANOS",
    concepto TEXT,
    precio_acordado INT(11),
    tipo_cambio VARCHAR(100) DEFAULT 7,
    precio_acordado_literal VARCHAR(255),
    plan VARCHAR(100),
    fecha_limite_pago VARCHAR(100) DEFAULT 3,
    observacion TEXT,
    -- -----------------------------


    lote VARCHAR(50),
    manzano VARCHAR(50),
    superficie VARCHAR(50),
    tipo_cliente VARCHAR(50),
    detalle_tipo_cliente VARCHAR(100),
    resumen_visita TEXT,
    seguiente_paso TEXT,
    estado_reporte int(11) DEFAULT 0,
    estado_cierre int(11) DEFAULT 0,
    estado int(11) DEFAULT 1,

    FOREIGN KEY (id_agenda_fk) REFERENCES tb_agendas(id_agenda)

);

ALTER TABLE tb_informe
ADD COLUMN compra_directo VARCHAR(255) DEFAULT 'NO' AFTER estado;


CREATE TABLE tb_aumento_reserva(
    id_aumento_reserva INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    monto_aumento INT(100),
    literal_aumento VARCHAR(255),
    tipo_pago_aumento VARCHAR(100),
    concepto VARCHAR(255),
    num_recibo_aumento VARCHAR(100),
    fecha_registro_aumento DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,
    id_informe_fk INT(11),
    FOREIGN KEY (id_informe_fk) REFERENCES tb_informe(id_informe)
);


CREATE TABLE tb_liberacion(
    id_liberacion INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    resumen TEXT,
    seguiente TEXT,
    estado int(11) DEFAULT 1,
    id_informe_fk INT(11),

    FOREIGN KEY (id_informe_fk) REFERENCES tb_informe(id_informe)

);

CREATE TABLE tb_funciones(
    id_funciones INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_usuario_fk INT(11),
    nombre_funcion VARCHAR(255),
    estado_funcion INT(11) DEFAULT 1,
    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios(id_usuario)
);

CREATE TABLE tb_comprador(
    id_comprador INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_1 VARCHAR(100) NOT NULL,
    ap_paterno_1 VARCHAR(100) NOT NULL,
    ap_materno_1 VARCHAR(100) NOT NULL,
    ci_1 INT(11),
    exp_1 VARCHAR(10),
    celular_1 INT(10),
    nombre_2 VARCHAR(100) NOT NULL,
    ap_paterno_2 VARCHAR(100) NOT NULL,
    ap_materno_2 VARCHAR(100) NOT NULL,
    ci_2 INT(11),
    exp_2 VARCHAR(10),
    celular_2 INT(10),
    id_usuario_fk INT(11),
    estado_doc_priv INT(11) DEFAULT 0,

    FOREIGN KEY(id_usuario_fk) REFERENCES tb_usuarios(id_usuario)
);

CREATE TABLE tb_contado(
    id_ccontado INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    monto_dolar VARCHAR(11) NOT NULL,
    tipo_cambio VARCHAR(11) NOT NULL,
    monto_bolivianos VARCHAR(11)NOT NULL,
    tipo_moneda VARCHAR(50) NOT NULL,
    literal VARCHAR(255) NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    urbanizacion VARCHAR(255) NOT NULL,
    lote VARCHAR(50) NOT NULL,
    manzano VARCHAR(50) NOT NULL,
    superficie VARCHAR(50) NOT NULL,
    fecha_registro DATE,
    num_recibo VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,

    id_comprador_fk INT(11),

    FOREIGN KEY (id_comprador_fk) REFERENCES tb_comprador(id_comprador)

);


CREATE TABLE tb_semicontado(
    id_semicontado INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    monto_dolar VARCHAR(11) NOT NULL,
    tipo_cambio VARCHAR(11) NOT NULL,
    monto_bolivianos VARCHAR(11)NOT NULL,
    tipo_moneda VARCHAR(50) NOT NULL,
    literal_general VARCHAR(255) NOT NULL,
    literal VARCHAR(255) NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    urbanizacion VARCHAR(255) NOT NULL,
    lote VARCHAR(50) NOT NULL,
    manzano VARCHAR(50) NOT NULL,
    superficie VARCHAR(50) NOT NULL,
    fecha_registro DATE,
    cuota_inicial INT(11),    
    cuota_inicial_literal VARCHAR(255),
    num_recibo_inicial VARCHAR(50) UNIQUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,

    id_comprador_fk INT(11),

    FOREIGN KEY (id_comprador_fk) REFERENCES tb_comprador(id_comprador)

);

CREATE TABLE tb_cuotas(
    id_cuota INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_semicontado_fk INT(11),
    nombre_cuota VARCHAR(11),
    monto FLOAT,
    tipo_pago VARCHAR(50),
    fecha_pago DATE,
    fecha_registro_pago DATE,
    numero_recibo VARCHAR(11),
    nueva_cuota INT(11) DEFAULT 0,
    FOREIGN KEY (id_semicontado_fk) REFERENCES tb_semicontado(id_semicontado)
);



CREATE TABLE tb_credito(
    id_credito INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    monto_dolar VARCHAR(11) NOT NULL,
    tipo_cambio VARCHAR(11) NOT NULL,
    monto_bolivianos VARCHAR(11)NOT NULL,
    tipo_moneda VARCHAR(50) NOT NULL,
    literal_general VARCHAR(255) NOT NULL,
    literal VARCHAR(255) NOT NULL,
    concepto VARCHAR(255) NOT NULL,
    urbanizacion VARCHAR(255) NOT NULL,
    lote VARCHAR(50) NOT NULL,
    manzano VARCHAR(50) NOT NULL,
    superficie VARCHAR(50) NOT NULL,
    fecha_registro DATE,
    cuota_inicial INT(11),
    cuota_inicial_literal VARCHAR(255),
    cuota_interes INT(11),
    num_recibo_inicial VARCHAR(50) UNIQUE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fyh_eliminacion DATETIME NULL,

    id_comprador_fk INT(11),

    FOREIGN KEY (id_comprador_fk) REFERENCES tb_comprador(id_comprador)

);

CREATE TABLE tb_cuotas_credito(
    id_cuota INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_credito_fk INT(11),
    nombre_cuota VARCHAR(11),
    monto FLOAT,
    tipo_pago VARCHAR(50),
    fecha_pago DATE,
    fecha_registro_pago DATE,
    numero_recibo VARCHAR(11),
    nueva_cuota INT(11) DEFAULT 0,
    FOREIGN KEY (id_credito_fk) REFERENCES tb_credito(id_credito)
);



CREATE TABLE tb_archivo (
    id_archivo INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    ruta_archivo VARCHAR(255) NOT NULL,
    matricula VARCHAR(100) NOT NULL,
    id_comprador_fk INT(11),
    FOREIGN KEY (id_comprador_fk) REFERENCES tb_comprador(id_comprador)
);




create table tb_documento(
    id_documento INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    texto TEXT NOT NULL,
    id_comprador_fk INT (11),
    FOREIGN KEY (id_comprador_fk) REFERENCES tb_comprador(id_comprador)
);



INSERT INTO `tb_cargo`(nombre_cargo,estado) VALUES ('ADMINISTRATIVO',1);


INSERT INTO tb_usuarios(nombre, ap_paterno, ap_materno, ci, exp, celular, cargo, email, direccion, password, id_cargo_fk, estado, estado_guia) VALUES ('admin','prueba','prueba','123', 'LP.', '77777777', 'ADMINISTRATIVO', 'admin@gmail.com', 'LA PAZ EL ALTO LLOJETA', '$2y$10$Ezc6l8CAZcLVKHowZIZkL.SWGeuyTqmm2oBFKPqJkQjaWTJmo8GVm', '1', '1', '0');

INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'CARGO',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'FUNCIONES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'URBANIZACIONES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'USUARIOS',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'CONTRASEÑAS',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'REG_CLIENTES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'AGE_CLIENTES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'RESERVAS',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'DESIGNAR',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'REPORTES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'CIERRE_DIRECTO',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'BUSQUEDA_CIERRES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'LISTA_CIERRES',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'LEGAL',1);
INSERT INTO `tb_funciones`(id_usuario_fk, nombre_funcion, estado_funcion) VALUES (1,'IMPORTACIONES',1);




















CREATE TABLE tb_clientes_importacion(
    id_cliente_imp INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_completo VARCHAR(100)  DEFAULT 'SIN RESPONDER',
    celular INT(11) ,
    email VARCHAR(100)  DEFAULT 'SIN RESPONDER',
    producto VARCHAR(255)  DEFAULT 'SIN RESPONDER',
    obs_contacto TEXT,
    fecha_registro_imp DATE,
    direccion VARCHAR(255)  DEFAULT 'SIN RESPONDER',

    pregunta_1 VARCHAR(10),
    pregunta_2 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_3 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_3_1 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_3_2 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_4 DATE,
    pregunta_5 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_6 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_7 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_7_1 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_8 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_9 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_10 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_11 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_12 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    pregunta_13 VARCHAR(255) DEFAULT 'SIN RESPONDER',
    id_usuario_fk INT(11),
    
    FOREIGN KEY (id_usuario_fk) REFERENCES tb_usuarios (id_usuario)
);


-- consulta para los agendados
SELECT con.celular, cli.nombres, cli.apellidos FROM tb_contactos con INNER JOIN tb_clientes cli WHERE (con.id_contacto=cli.id_contacto_fk)
