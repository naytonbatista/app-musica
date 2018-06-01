CREATE DEFINER=`dba`@`%` PROCEDURE `ALTERAR_PLAYLIST_MUSICA`(IN  P_ID_PLAYLIST_MUSICA INT,
		                                                     IN  P_ID_PLAYLIST 	      INT,
                                                             IN  P_ID_MUSICA	      INT,
															 IN  P_ID_USUARIO         INT,
                                                             IN  P_PLM_ANOTACAO       VARCHAR(255),
                                                             IN  P_PLM_ORDEM	      INT,
                                                             IN  P_PLM_FAVORITA	      INT,
													         IN  P_COMMIT             CHAR(1),
													         OUT P_OK 	              CHAR(1),
															 OUT P_RETORNO     		  VARCHAR(2000))
ALTERAR_PLAYLIST_MUSICA:BEGIN

DECLARE V_PLA_NOME VARCHAR(255);
DECLARE V_MUS_NOME  VARCHAR(255);

CALL VALIDA_LOOKUP(P_ID_PLAYLIST_MUSICA, 'PLAYLIST_MUSICA', 'ID_PLAYLIST_MUSICA', P_OK, P_RETORNO);

     IF P_OK = 'N' THEN
        LEAVE ALTERAR_PLAYLIST_MUSICA;
     END IF;

CALL VALIDA_LOOKUP(P_ID_PLAYLIST, 'PLAYLIST', 'ID_PLAYLIST', P_OK, P_RETORNO);
    
     IF P_OK = 'N' THEN
        LEAVE ALTERAR_PLAYLIST_MUSICA;
     END IF;

CALL VALIDA_LOOKUP(P_ID_MUSICA, 'MUSICA', 'ID_MUSICA', P_OK, P_RETORNO);

     IF P_OK = 'N' THEN
        LEAVE ALTERAR_PLAYLIST_MUSICA;
     END IF;

CALL VALIDA_USUARIO(P_ID_USUARIO, 'USUARIO', P_OK, P_RETORNO);

     IF P_OK = 'N' THEN
        LEAVE ALTERAR_PLAYLIST_MUSICA;
     END IF;

   -- DADOS DA PLAYLIST
   SELECT P.PLA_NOME
	      INTO V_PLA_NOME
	  FROM PLAYLIST P
     WHERE P.ID_PLAYLIST = P_ID_PLAYLIST;
  
   -- VALIDA SE PLAYLIST PERTENCE AO MESMO USUÁRIO
   SELECT COUNT(1)
	    INTO @V_COUNT
     FROM PLAYLIST P
	WHERE P.ID_USUARIO   = P_ID_USUARIO
	  AND P.ID_PLAYLIST  = P_ID_PLAYLIST;
      
IF @V_COUNT = 0 THEN
    CALL MSG_ERRO('PLAYLIST_NAO_PERTENCE_USUARIO', V_PLA_NOME, NULL, NULL, NULL, NULL, P_OK, P_RETORNO);
	      -- A playlist :param1 não pertence ao seu usuário.
          
        LEAVE ALTERAR_PLAYLIST_MUSICA;
        
END IF;
    
	-- DADOS DA MUSCIA
    SELECT M.MUS_NOME
		   INTO V_MUS_NOME
	  FROM MUSICA M
	 WHERE M.ID_MUSICA = P_ID_MUSICA;
      

   -- ATUALIZA PLAYLIST_MUSICA
  UPDATE PLAYLIST_MUSICA 
	     SET  ID_PLAYLIST = P_ID_PLAYLIST,
              PLM_ANOTACAO= P_PLM_ANOTACAO,
              PLM_ORDEM   = P_PLM_ORDEM
		WHERE ID_PLAYLIST_MUSICA = P_ID_PLAYLIST_MUSICA;


CALL MSG_SUCESSO('ALTERAR_PLAYLIST_MUSICA', V_MUS_NOME, V_PLA_NOME, NULL, NULL, NULL, P_OK, P_RETORNO);  
				-- A música :param1 foi alterada na playlist :param2 com sucesso.
                
     IF P_OK = 'N' THEN
        LEAVE ALTERAR_PLAYLIST_MUSICA;
     END IF;

IF IFNULL(P_COMMIT, 'N') = 'S'THEN
 COMMIT;
END IF;

END