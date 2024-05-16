USE trabajofinal;

-- INSERTANDO DATOS EN LA TABLA PERSONAS
INSERT INTO personas
		(apepaterno,apematerno,nombres,nrodocumento,telprincipal,telsecundario)
        VALUES('Castilla','Maraví','Juan Javier','75065875','973323783','');
        


-- SELECCIONANDO TODOS LOS DATOS DE LA TABLA PERSONAS
SELECT * FROM personas;

-- --------------------------------------------------------------

-- INSERTANDO DATOS EN LA TABLA ROLES
INSERT INTO roles
			(rol)
            VALUES('A'), -- ADMINISTRADOR
            ('C'); -- INVITADO
            
-- SELECCIONANDO TODOS LOS DATOS DE LA TABLA PERSONAS
SELECT * FROM roles;            

-- ----------------------------------------------------------------

-- INSERTANDO DATOS EN LA TABLA TIPO DE PRODUCTOS
INSERT INTO tipoproductos
			(tipoproducto)
            VALUES('Electrodomesticos'),
				  ('Producto Limpieza');
                  
SELECT * FROM tipoproductos;

-- ------------------------------------------------------------------

-- INSERTANDO DATOS EN LA TABLA DE MARCAS
INSERT INTO marcas
			(marca)	
            VALUES('Clorina'),
				  ('Dkasa'),
                  ('Prolimso'),
                  ('HP'),
                  ('Samsung'),
                  ('LG');
                  
SELECT * FROM marcas;

-- -------------------------------------------------------------------------

-- INSERTANDO DATOS EN LA TABLA PRODUCTOS
INSERT INTO productos
			(idtipoproducto,idmarca,producto,descripcion,modelo)
			VALUES(1,4,'Televisor', '40 pulgadas','HP_001');

SELECT * FROM productos;

-- -----------------------------------------------------------------------------
-- INSERTANDO DATOS EN LA TABLA COLABORADORES
INSERT INTO colaboradores
			(idpersona,idrol,nomusuario,passusuario)
            VALUES(1,1,'javier234','$2y$10$wQEsOWs4FOMMeyWz7WgPwe/mSLJCJlaeqK1zznuA2Y.fz7niyD2ey');
UPDATE colaboradores SET passusuario = "$2y$10$wQEsOWs4FOMMeyWz7WgPwe/mSLJCJlaeqK1zznuA2Y.fz7niyD2ey" WHERE idcolaborador = 1;

SELECT * FROM colaboradores;

-- INSERTANDO DATOS EN LA TABLA KARDEX

INSERT INTO kardex
			(idcolaborador,idproducto,tipomovimiento,stockactual,cantidad,fecha_registro)
            VALUES(1,1,'ENTRADA',20,4,'2024-05-10');

SELECT * FROM kardex;

-- PROCEDIMIENTO ALMACENADO PARA PODER REGISTRAR COLABORADORES
DELIMITER $$
CREATE PROCEDURE spu_colaborador_login(IN _nomusuario VARCHAR(50))
BEGIN
	SELECT 
    CO.idcolaborador,
    PER.apepaterno, PER.apematerno, PER.nombres,
    CO.nomusuario,CO.passusuario
    FROM colaboradores CO
    INNER JOIN personas PER ON PER.idpersona = CO.idpersona
    WHERE CO.nomusuario = _nomusuario AND CO.inactive_at IS NULL;
END $$

CALL spu_colaborador_login('javier234');

-- CREANDO PROCEDIMIENTO PARA REGISTRAR PERSONAS
DELIMITER $$
CREATE PROCEDURE spu_registrar_persona(
    IN _apepaterno VARCHAR(50),
    IN _apematerno VARCHAR(50),
    IN _nombres VARCHAR(50),
    IN _nrodocumento CHAR(8),
    IN _telprincipal CHAR(9),
    IN _telsecundario CHAR(9)
)
BEGIN
    SET _telprincipal = NULLIF(_telprincipal, '');
    SET _telsecundario = NULLIF(_telsecundario, '');

    INSERT INTO personas(apepaterno, apematerno, nombres, nrodocumento, telprincipal, telsecundario)
    VALUES (_apepaterno, _apematerno, _nombres, _nrodocumento, _telprincipal, _telsecundario);
    SELECT  @@last_insert_id 'idpersona';
END $$

CALL spu_registrar_persona('Soto','Saravia','Alexia','34569706','123456789','');
CALL spu_registrar_persona('Carbajal','Perez','Jose','12567890','987654321','');
SELECT * FROM personas;
select * from colaboradores

-- PROCEDIMIENTO PARA PODER REGISTRAR UN COLABORADOR
DELIMITER $$
CREATE PROCEDURE spu_registrar_colaborador (
	_idpersona		INT,
    _idrol			INT,
    _nomusuario		VARCHAR(50),
    _passusuario	VARCHAR(60)
)
BEGIN
	INSERT INTO colaboradores(idpersona,idrol,nomusuario,passusuario)
    VALUES (_idpersona,_idrol,_nomusuario,_passusuario);
    SELECT  @@last_insert_id 'idcolaborador';
END $$

CALL spu_registrar_colaborador(1,2,'joseq23','ess8wged34');

-- CREAR PROCEDIMIENTO PARA BUSCAR A LA PERSONA POR SU NUMERO DE DOCUMENTO ( DNI )
DELIMITER $$
CREATE PROCEDURE spu_usuario_buscar_dni (IN _nrodocumento CHAR(8))
BEGIN
	SELECT 
    CO.idcolaborador,
    PER.apepaterno,
    PER.apematerno,
    PER.nombres,
    PER.telprincipal,
    PER.telsecundario
    FROM personas PER
    LEFT JOIN colaboradores CO
    ON CO.idcolaborador = PER.idpersona
    WHERE nrodocumento = _nrodocumento;
END $$

-- CREANDO MI PROCEDIMIENTO ALMACENADO PARA LISTAR MIS MARCAS
DELIMITER $$
CREATE PROCEDURE spu_marca_listar()
BEGIN
	SELECT
    MC.idmarca,
    MC.marca
    FROM marcas MC;
END $$

-- PROCEDIMIENTO ALMACENADO PARA ENLISTAR MI TIPO DE PRODUCTO
DELIMITER $$
CREATE PROCEDURE spu_tipoproducto_listar()
BEGIN
	SELECT 
    TP.idtipoproducto,
    TP.tipoproducto
    FROM tipoproductos TP;
END $$

-- PROCEDIMIENTO ALMACENADO PARA REGISTRAR MIS PRODUCTOS
DELIMITER $$
CREATE PROCEDURE spu_registrar_productos(
	IN _idtipoproducto  		INT,
    IN _idmarca					INT,
    IN _producto		VARCHAR(100),
    IN _descripcion		VARCHAR(100),
    IN _modelo			VARCHAR(30)
)
BEGIN
	INSERT INTO productos(idtipoproducto,idmarca,producto,descripcion, modelo)
    VALUES (_idtipoproducto,_idmarca,_producto,_descripcion,_modelo);
END $$
            
CALL spu_registrar_productos(1,5,'Cocina','De seis ornillas','SM_02039');
CALL spu_registrar_productos(1,4,'Planca','De 3 niveles','FM_47922');

SELECT * FROM productos;
select * from marcas;
select * from personas;
select * from colaboradores;

-- CREANDO MI PROCEDIMIENTO ALMACENADO DE MI KARDEX
DELIMITER $$
CREATE PROCEDURE RegistrarMovimientoKardex(
    IN p_idcolaborador INT,
    IN p_idproducto INT,
    IN p_tipomovimiento VARCHAR(10),
    IN p_cantidad INT
)
BEGIN
    DECLARE v_stock_anterior INT;
    DECLARE v_stock_actual INT;
    
    -- Obtener el stock actual del producto
    SELECT stockactual INTO v_stock_anterior
    FROM kardex
    WHERE idproducto = p_idproducto
    ORDER BY fecha_registro DESC
    LIMIT 1;
    
    -- Calcular el nuevo stock
    IF p_tipomovimiento = 'ENTRADA' THEN
        SET v_stock_actual = v_stock_anterior + p_cantidad;
    ELSEIF p_tipomovimiento = 'SALIDA' THEN
        SET v_stock_actual = v_stock_anterior - p_cantidad;
    END IF;
    
    -- Insertar el nuevo registro en el kardex
    INSERT INTO kardex (idcolaborador, idproducto, tipomovimiento, stockactual, cantidad, fecha_registro)
    VALUES (p_idcolaborador, p_idproducto, p_tipomovimiento, v_stock_actual, p_cantidad, NOW());
    
    -- Obtener el nuevo stock actual del producto
    SELECT stockactual INTO v_stock_actual
    FROM kardex
    WHERE idproducto = p_idproducto
    ORDER BY fecha_registro DESC
    LIMIT 1;
    
    -- Actualizar el stock actual del producto en el registro previo
    UPDATE kardex
    SET stockactual = v_stock_actual
    WHERE idproducto = p_idproducto
    AND fecha_registro = NOW();
END $$

CALL RegistrarMovimientoKardex(1, 1, 'ENTRADA', 30);
CALL RegistrarMovimientoKardex(1,1,'SALIDA',0);
select * from kardex;

-- CREANDO PROCEDIMIENTO PARA LISTAR MIS PRODUCTOS
DELIMITER $$
CREATE PROCEDURE spu_productos_listar()
BEGIN
	SELECT
	PRO.idproducto,
    TPR.tipoproducto,
    MAR.marca,
    PRO.descripcion,
    PRO.modelo
    FROM productos PRO
    INNER JOIN tipoproductos TPR ON TPR.idtipoproducto = PRO.idtipoproducto
    INNER JOIN marcas MAR ON MAR.idmarca = PRO.idmarca;
END $$


CALL spu_productos_listar();