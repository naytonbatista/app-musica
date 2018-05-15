CREATE DEFINER=`dba`@`%` PROCEDURE `ALTERAR_USUARIO`(IN  P_ID_USUARIO     INT,
													 IN  P_USU_EMAIL      VARCHAR(255),
													 IN  P_USU_SENHA      VARCHAR(255),
                                                     IN  P_USU_ATIVO 	  INT,
													 IN  P_COMMIT         VARCHAR(1),
													 OUT P_OK 	          VARCHAR(1),
													 OUT P_RETORNO        VARCHAR(2000))
BEGIN

DECLARE V_TEXTO	VARCHAR(2000);

DECLARE V_ID_USUARIO INT;
DECLARE V_USU_EMAIL VARCHAR(255);

CALL VALIDA_CAMPO_OBRIGATORIO(P_USU_EMAIL, 'USUARIO', 'USU_EMAIL');
 
CALL VALIDA_USUARIO(P_ID_USUARIO, 'USUARIO');


  -- DADOS DO USUARIO
  SELECT U.USU_EMAIL 
	 INTO V_USU_EMAIL 
        FROM  USUARIO U 
      WHERE U.ID_USUARIO = P_ID_USUARIO;

IF V_USU_EMAIL != P_USU_EMAIL THEN

-- VERIFICA SE EMAIL JA EXISTE PARA OUTRO USUARIO
SELECT COUNT(1)
	 INTO @V_COUNT FROM USUARIO U
		WHERE U.USU_EMAIL = P_USU_EMAIL;
        
  IF @V_COUNT > 0 THEN 
   CALL MSG_ERRO('EMAIL_EXISTE', P_USU_EMAIL, NULL, NULL, NULL, NULL);
   -- O e-mail :param1 já existe.
  END IF;

END IF;

 
    -- ALTERAR USUARIO
    UPDATE USUARIO U 
	   SET U.USU_EMAIL      = P_USU_EMAIL,
           U.USU_ATIVO      = P_USU_ATIVO
     WHERE U.ID_USUARIO     = P_ID_USUARIO;

SET V_TEXTO :=  MSG_TEXTO('ALTERAR_USUARIO'); 
				-- Usuário alterado com sucesso.

SET P_OK      := 'S';
SET P_RETORNO := V_TEXTO;

IF IFNULL(P_COMMIT,'N') = 'S'THEN
 COMMIT;
END IF;

END