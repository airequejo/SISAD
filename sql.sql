CREATE DEFINER=`u110688400_appcuentas`@`%` PROCEDURE `cuentas`(IN _idcuenta INT, _codigo VARCHAR(2), _descripcion VARCHAR(150), _tipo TINYINT(1),_data int(1))
BEGIN

DECLARE total_codigo INT;
DECLARE total_descripcion INT;

		CASE 
		
-- INSERT CUENTA

		WHEN _data = 1 THEN
			
			SET total_codigo = (SELECT COUNT(*) FROM cuentas WHERE codigo = _codigo);
			SET total_descripcion = (SELECT COUNT(*) FROM cuentas WHERE REPLACE(descripcion, ' ', '') = REPLACE(_descripcion,' ',''));
			
			IF _tipo >=0 && _codigo != '' && _descripcion != '' THEN
			
					IF 	total_codigo = 0 && total_descripcion = 0 THEN
				
							INSERT INTO cuentas (codigo, descripcion, tipo) VALUES(_codigo, _descripcion, _tipo);			
							
							SELECT 1 as state; -- insert ok
				
					ELSE
				
							SELECT 2 as state; -- duplicado
				
					END IF;
				
			ELSE
			
					SELECT  3 as state; -- COMPETE LOS DATOS;
			
			END IF;
			
-- UPDATE CUENTA

		WHEN _data = 2 THEN
			
			SET total_codigo = (SELECT COUNT(*) FROM cuentas WHERE codigo = _codigo AND idcuenta != _idcuenta);
			SET total_descripcion = (SELECT COUNT(*) FROM cuentas WHERE REPLACE(descripcion, ' ', '') = REPLACE(_descripcion,' ','') AND idcuenta != _idcuenta);
			
		
				IF _tipo >= 0 && _codigo != '' && _descripcion != '' && _idcuenta != '' THEN
				
						IF 	total_codigo = 0 && total_descripcion = 0 THEN
				
								UPDATE cuentas SET codigo = _codigo, descripcion = _descripcion , tipo = _tipo WHERE idcuenta = _idcuenta;			
								
								SELECT 1 as state; -- update ok
						
						ELSE
				
								SELECT 2 as state; -- duplicado
					
						END IF;
				
					ELSE
			
						SELECT  3 as state; -- COMPETE LOS DATOS;
			
				END IF;
			
					
-- ACTIVAR CUENTA

		WHEN _data = 3 THEN
		
				UPDATE cuentas SET estado = 1 WHERE idcuenta = _idcuenta;
				
				SELECT 1 as state; -- update ok
		
-- DESACTIVAR CUENTA

		WHEN _data = 4 THEN
				
				UPDATE cuentas SET estado = 0 WHERE idcuenta = _idcuenta;
				
				SELECT 1 as state; -- update ok				

-- MOSTRAR CUENTA

		WHEN _data = 5 THEN
						
				SELECT * FROM cuentas WHERE idcuenta = _idcuenta;

-- listar CUENTA

		WHEN _data = 6 THEN
						
				SELECT * FROM cuentas;

-- COMBO CUENTA

		WHEN _data = 7 THEN
						
				SELECT * FROM cuentas WHERE estado = 1;
				
		ELSE
		
					SELECT 0 AS state; -- error
	
		END CASE;
		
	
		
END