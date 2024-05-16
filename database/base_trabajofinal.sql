CREATE DATABASE trabajofinal;
use trabajofinal;

CREATE TABLE personas(
	idpersona			INT AUTO_INCREMENT PRIMARY KEY,
    apepaterno			VARCHAR(50)			NOT NULL,
    apematerno			VARCHAR(50)			NOT NULL,
    nombres				VARCHAR(50)			NOT NULL,
	nrodocumento		CHAR(8)				NOT NULL,
    telprincipal		CHAR(9)				NULL,
    telsecundario		CHAR(9)				NULL,
    create_at		DATETIME			NOT NULL DEFAULT NOW(),
    inactive_at		DATETIME			NULL,
    CONSTRAINT uk_numero_documento UNIQUE(nrodocumento)
)ENGINE = INNODB;

CREATE TABLE roles(
	idrol			INT AUTO_INCREMENT PRIMARY KEY,
    rol				CHAR(1)	   NOT NULL
)ENGINE = INNODB;

CREATE TABLE tipoproductos
(
	idtipoproducto		INT AUTO_INCREMENT PRIMARY KEY,
    tipoproducto		VARCHAR(30)		   NOT NULL
)ENGINE = INNODB;

CREATE TABLE marcas
(
	idmarca			INT AUTO_INCREMENT PRIMARY KEY,
    marca			VARCHAR(50)			NOT NULL
)ENGINE = INNODB;

CREATE TABLE productos
(
	idproducto		INT AUTO_INCREMENT PRIMARY KEY,
    idtipoproducto	INT NOT NULL,
    idmarca			INT NOT NULL,
    producto		VARCHAR(100)		NOT NULL,
    descripcion		VARCHAR(100)		NOT NULL,
    modelo			VARCHAR(30)			NOT NULL,
    CONSTRAINT fk_idmarca FOREIGN KEY(idmarca) REFERENCES marcas(idmarca),
    CONSTRAINT fk_tipoproducto FOREIGN KEY(idtipoproducto) REFERENCES tipoproductos(idtipoproducto)
)ENGINE = INNODB;

CREATE TABLE colaboradores
(
	idcolaborador	INT AUTO_INCREMENT PRIMARY KEY,
    idpersona		INT,
    idrol			INT,
    nomusuario		VARCHAR(50) NOT NULL UNIQUE, -- CAMPO UNICO
    passusuario		VARCHAR(60) NOT NULL,
    create_at		DATETIME			NOT NULL DEFAULT NOW(),
    inactive_at		DATETIME			NULL,
    CONSTRAINT fk_idpersona FOREIGN KEY(idpersona) REFERENCES personas(idpersona),
    CONSTRAINT fk_idrol FOREIGN KEY(idrol) REFERENCES roles(idrol)
) ENGINE = INNODB;


CREATE TABLE kardex
(
	idalmacen			INT AUTO_INCREMENT PRIMARY KEY,
    idcolaborador		INT,
    idproducto			INT,
    tipomovimiento		VARCHAR(10)	NOT NULL,
    stockactual			INT,
    cantidad			INT,
    fecha_registro		DATETIME,
    CONSTRAINT fk_idcolaborador FOREIGN KEY(idcolaborador) REFERENCES colaboradores(idcolaborador),
    CONSTRAINT fk_idproducto	FOREIGN KEY(idproducto) REFERENCES productos(idproducto),
    CONSTRAINT chk_cantidad		CHECK (cantidad > 0),
    CONSTRAINT chk_stock_total  CHECK(stockactual >=0)
)ENGINE = INNODB;
