<?php
/**
 * Pokeflute Library
 * @author Wanderson Henrique Camargo Rosa
 */
namespace Pokeflute;

/**
 * Pokeflute Multiton Manager
 *
 * @category Pokeflute
 * @package  Pokeflute_Loader
 */
class Multiton {

    /**
     * Multiton Instances
     * @var array
     */
    private static $_instances = array();

    /**
     * Multiton Access
     *
     * @param  string Nome de Classe para Captura
     * @return mixed  Instância de Classe Solicitada
     */
    public static function getInstance($classname) {
        // Conversão
        $classname = (string) $classname;
        // Verificação de Instância
        if (!array_key_exists($classname, self::$_instances)) {
            // Carregamento de Classe
            self::$_instances[$classname] = new $classname();
        }
        // Apresentação
        return self::$_instances[$classname];
    }

}
