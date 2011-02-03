<?php

/**
 * Carregador de Classes
 * Estrutura para Carregamento Automático de Classes
 * @author Wanderson Henrique Camargo Rosa
 * @see    http://www.wanderson.camargo.nom.br/
 */
class Loader
{
    /**
     * Instância Singleton
     * @var Loader
     */
    private static $_instance = null;

    /**
     * Construtor Privado Singleton
     */
    private function __construct()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', true);
        spl_autoload_register('self::loadClass');
    }

    /**
     * Acesso ao Singleton
     * @return Loader Instância Única de Carregador
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Acesso ao Carregador de Classes
     * @param string $classname Nome da Classe
     * @throws LoaderException Arquivo ou Classe não Encontrada
     * @return void
     */
    public static function loadClass($classname)
    {
        $filename = implode(DIRECTORY_SEPARATOR, array(
            dirname(__FILE__), "$classname.php"
        ));
        if (!is_file($filename)) {
            throw new LoaderException("Arquivo Não Encontrado: '$filename'");
        }
        require_once $filename;
        if (!class_exists($classname)) {
            throw new LoaderException("Class Inválida: '$classname'");
        }
    }
}