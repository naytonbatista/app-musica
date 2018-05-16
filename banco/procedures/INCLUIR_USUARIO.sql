CREATE DEFINER=`dba`@`%` PROCEDURE `INCLUIR_USUARIO`(OUT P_ID_USUARIO INT,
													 IN  P_USU_EMAIL  VARCHAR(255),
													 IN  P_USU_SENHA  VARCHAR(255),
													 IN  P_COMMIT     VARCHAR(1),
													 OUT P_OK 	      VARCHAR(1),
													 OUT P_RETORNO    VARCHAR(2000))
BEGIN

DECLARE V_TEXTO	VARCHAR(2000);

DECLARE V_ID_USUARIO INT;
DECLARE V_COUNT INT DEFAULT 0;

CALL VALIDA_CAMPO_OBRIGATORIO(P_USU_EMAIL, 'USUARIO', 'USU_EMAIL');

CALL VALIDA_CAMPO_OBRIGATORIO(P_USU_SENHA, 'USUARIO', 'USU_SENHA');

SELECT COUNT(1)
	 INTO V_COUNT FROM USUARIO U
		WHERE U.USU_EMAIL = P_USU_EMAIL;
        
IF V_COUNT > 0 THEN 
  CALL MSG_ERRO('EMAIL_EXISTE', P_USU_EMAIL, NULL, NULL, NULL, NULL);
  -- O e-mail :param1 já existe.
  END IF;

-- incluir usuário
INSERT INTO USUARIO (USU_EMAIL, USU_SENHA)
	VALUES(P_USU_EMAIL, MD5(P_USU_SENHA));

-- retorna o id do usuário cadastrado
SET P_ID_USUARIO := LAST_INSERT_ID();

SET V_TEXTO :=  MSG_TEXTO('INCLUIR_USUARIO'); -- Usuário cadastrado com sucesso.

SET P_OK      := 'S';
SET P_RETORNO := V_TEXTO;

IF IFNULL(P_COMMIT,'N') = 'S'THEN
 COMMIT;
END IF;

END