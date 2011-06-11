<?php

/**
 * Comparação de Emails do Usuário
 * 
 * Verifica se o email modificado não existe no banco de dados; caso contrário
 * compara o cadastrado do usuário atual, validando a não modificação.
 * @todo Modificar Nome da Classe
 * 
 * @category   Local
 * @package    Local_Validate
 * @subpackage Db
 */
class Local_Validate_Db_NoRecordExists extends Zend_Validate_Db_NoRecordExists
{
    protected function _query($value)
    {
        $result = parent::_query($value);
        // @todo Email do Usuário pelo Autenticados
        return $result == 'wandersonwhcr@gmail.com' ? $result : false;
    }
}