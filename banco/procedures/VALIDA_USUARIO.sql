CREATE DEFINER=`dba`@`%` PROCEDURE `VALIDA_USUARIO`(IN P_ID_USUARIO INT,
													IN P_TABELA VARCHAR(30))
BEGIN  
 
 CALL VALIDA_CAMPO_OBRIGATORIO(P_ID_USUARIO, P_TABELA, 'ID_USUARIO');
 
 CALL VALIDA_LOOKUP(P_ID_USUARIO, P_TABELA, 'ID_USUARIO');
 
END