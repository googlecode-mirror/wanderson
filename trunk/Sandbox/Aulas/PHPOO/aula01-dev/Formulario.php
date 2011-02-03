<?php

/**
 * Classe Abstrata de Formulário
 * Exemplo Básico para Orientação a Objetos
 * Impossível Criar um Objeto da Classe por Ser Abstrata
 * 
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
abstract class Formulario
{
    /**
     * Método Abstrato
     * Certifica que Classes Estendidas Implementem o Método
     * 
     * @return array Valores Preenchidos no Formulário
     */
    abstract public function getValores();

    /**
     * Envio de Formulário
     * Busca os Valores e Envia Dados para Cadastro
     * Informações na Saída Padrão
     * 
     * @return void
     */
    public function enviar()
    {
        $valores  = $this->getValores();
        $cadastro = array();
        foreach ($valores as $nome => $valor) {
            $cadastro[] = "$nome=$valor";
        }
        $cadastro = implode('&', $cadastro);
        echo 'Enviando Formulário. Valores: ' . $cadastro;
    }
}