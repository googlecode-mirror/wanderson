<?php

/**
 * Interface para Manipulação em Banco de Dados
 * Exemplo Básico para Orientação a Objetos
 * Garantia de Métodos Implementados na Classe
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
interface BancoInterface
{
    /**
     * Salva os Dados no Banco
     * Deve ser Implementado na Classe Alvo
     * 
     * @return boolean Confirmação da Ação
     */
    public function save();

    /**
     * Remove os Dados do Banco
     * Deve ser Implementado na Classe Alvo
     * 
     * @return boolean Confirmação da Ação
     */
    public function delete();
}