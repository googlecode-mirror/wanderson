<?php
/**
 * Pokeflute
 * @author Wanderson Henrique Camargo Rosa
 */
namespace Model;
use \Pokeflute\DbAdapter as DbAdapter;

/**
 * Camada de Modelo para Músicas
 *
 * @category Default
 * @package  Default_Model
 */
class Musics {

    /**
     * Adicionar um Arquivo no Banco de Dados
     *
     * Para a inclusão de arquivos no banco de dados, precisamos capturar o nome
     * completo do arquivo no sistema operacional e verificar se o mesmo é um
     * arquivo válido. Se as validações estiverem corretas, o arquivo será
     * incluído na estrutura do banco de dados com as informações padrão de
     * cadastro.
     *
     * @param  string $filename Nome do Arquivo para Inclusão
     * @return bool   Confirmação de Execução com Sucesso ou Falha
     */
    public function addFilename($filename) {
        // Resultado Inicial
        $result = false;
        // Captura de Nome Completo do Arquivo
        $filename = realpath($filename);
        // Verificação de Existência
        if (!empty($filename)) {
            // Recurso de Banco de Dados
            $resource = DbAdapter::getInstance()->getResource();
            // Criação de Statement
            $stmt = $resource->prepare('INSERT INTO `musics`(`filename`) VALUES (:filename)');
            // Passagem de Parâmetros
            $stmt->bindParam(':filename', $filename, SQLITE3_TEXT);
            // Execução
            $stmt->execute();
            // Resultado Obtido
            $result = true;
        }
        // Apresentar Resultados
        return $result;
    }

    /**
     * Remover um Arquivo no Banco de Dados
     *
     * Durante a remoção de um arquivo do sistema, precisamos remover a sua
     * entrada no banco de dados para que este não seja mais selecionado. A
     * remoção pode ser lógica, somente desabilitando a música no conjunto ou
     * retirando-a totalmente do sistema.
     *
     * @param  string $filename Nome do Arquivo para Remoção
     * @param  bool   $complete Remover a Entrada do Banco de Dados
     * @return Musics Próprio Objeto para Encadeamento
     */
    public function removeFilename($filename, $complete = false) {
        // Conversão
        $filename = (string) $filename;
        $complete = (bool) $complete;
        // Remoção Completa?
        if ($complete) {
            // Recurso de Banco de Dados
            $resource = DbTable::getInstance()->getResource();
            // Criação de Statement
            $stmt = $resource->prepare('DELETE FROM `musics` WHERE `filename` = :filename');
            // Passagem de Parâmetros
            $stmt->bindParam(':filename', $filename, SQLITE3_TEXT);
            // Execução
            $stmt->execute();
        } else {
            // Remoção Lógica
            $this->setEnabled($filename, false);
        }
        // Encadeamento
        return $this;
    }

    /**
     * Habilitar ou Desabilitar uma Música
     *
     * Atualiza o banco de dados, modificando a coluna que informa se o elemento
     * pode ser selecionado, conforme o nome do arquivo que foi informado. Este
     * arquivo não será apresentado na consulta randômica.
     *
     * @param  string $filename Nome do Arquivo para Modificação
     * @param  bool   $flag     Habilitar ou Desabilitar o Conteúdo Selecionado
     * @return Musics Próprio Objeto para Encadeamento
     */
    public function setEnabled($filename, $flag) {
        // Conversão
        $filename = (string) $filename;
        $flag     = (bool)   $flag;
        // Recurso de Banco de Dados
        $resource = DbAdapter::getInstance()->getResource();
        // Criação de Statement
        $stmt = $resource->prepare('UPDATE `musics` SET `enabled` = :enabled WHERE `filename` = :filename');
        // Passagem de Parâmetros
        $stmt->bindParam(':enabled', intval($flag), SQLITE3_INTEGER);
        $stmt->bindParam(':filename', $filename, SQLITE3_TEXT);
        // Execução
        $stmt->execute();
        // Encadeamento
        return $this;
    }

    /**
     * Verificação de Música Existente
     *
     * Efetua uma consulta no banco de dados, verificando se o nome do arquivo
     * solicitado já foi adicionado na listagem de elementos, apresentando um
     * valor booleano confirmando a pesquisa.
     *
     * @param  string $filename Nome do Arquivo para Consulta
     * @return bool   Informação de Existência
     */
    public function hasFilename($filename) {
        // Recurso de Banco de Dados
        $resource = DbAdapter::getInstance()->getResource();
        // Criação de Statement
        $stmt = $resource->prepare('SELECT `m`.`filename` FROM `musics` AS `m` WHERE `m`.`filename` = :filename LIMIT 1');
        // Passagem de Parâmetros
        $stmt->bindParam(':filename', $filename, SQLITE3_TEXT);
        // Consulta ao Banco de Dados
        $element = $stmt->execute()->fetchArray();
        // Apresentação
        return !empty($element);
    }

    /**
     * Consulta por Prioridade
     *
     * Efetua uma consulta por prioridade na tabela de músicas no sistema,
     * considerando fatores como prioridade atual modificada, quantidade de
     * vezes que a música foi executada e randomização em restantes. Apresenta
     * um nome de arquivo como resposta, atualizando também a base de dados
     * conforme necessidade.
     *
     * @return string|null Nome do Arquivo Selecionado ou Valor Nulo
     */
    public function random() {
        // Resultado Inicial
        $result = null;
        // Recurso de Banco de Dados
        $resource = DbAdapter::getInstance()->getResource();
        // Consulta para Execução
        $query = 'SELECT `m`.`id`, `m`.`filename` FROM `musics` AS `m` WHERE `m`.`enabled` = 1 ORDER BY `m`.`priority` DESC, `m`.`counter` ASC, RANDOM() LIMIT 1';
        // Execução
        $element = $resource->query($query)->fetchArray(SQLITE3_ASSOC);
        // Verificar Resultados
        if (!empty($element)) {
            // Confirmar Execução
            $this->confirm($element['id']);
            // Capturar Resultado
            $result = $element['filename'];
        }
        // Resultados
        return $result;
    }

    /**
     * Confirmar Utilização
     *
     * Uma entrada deve ser confirmada sempre que estiver sendo utilizada no
     * sistema. Isto quer dizer que a coluna de contabilização de músicas será
     * incrementada e, caso solicitado, a prioridade desta música não será
     * zerada para que continue com seleção ativa.
     *
     * @param  int    $id       Identificador do Elemento no Banco de Dados
     * @param  int    $priority Atualizar os Valores de Prioridade
     * @return Musics Próprio Objeto para Encadeamento
     */
    public function confirm($id, $priority = 0) {
        // Conversão
        $id       = (int) $id;
        $priority = (int) $priority;
        // Recurso de Banco de Dados
        $resource = DbAdapter::getInstance()->getResource();
        // Criação de Statement
        $stmt = $resource->prepare('UPDATE `musics` SET `counter` = `counter`+1, `priority` = :priority WHERE `id` = :id');
        // Passagem de Parâmetros
        $stmt->bindParam(':priority', $priority, SQLITE3_INTEGER);
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        // Execução de Comando
        $stmt->execute();
        // Encadeamento
        return $this;
    }

    /**
     * Consulta de Músicas no Banco de Dados
     *
     * Executa uma busca completa no banco de dados, ordenando as músicas
     * conforme seu estado de habilitação, prioridade, contagem de execuções e
     * nome do arquivo. Apresenta um conjunto de informações com o conteúdo
     * selecionado do banco de dados.
     *
     * @return array Conjunto de Informações Selecionadas
     */
    public function fetchAll() {
        // Recurso de Banco de Dados
        $resource = DbAdapter::getInstance()->getResource();
        // Construção de Comando
        $query = <<<QUERY
SELECT
    `m`.`id` AS `id`,
    `m`.`filename` AS `filename`,
    `m`.`priority` AS `priority`,
    `m`.`counter` AS `counter,
    `m`.`enabled` AS `enabled`
FROM `musics` AS `m`
ORDER BY
    `m`.`enabled` DESC,
    `m`.`priority` DESC,
    `m`.`counter` ASC,
    `m`.`filename ASC
QUERY;
        // Consulta
        $result = $resource->query($query);
        // Inicialização
        $elements = array();
        // Construção de Conteúdo
        while(($element = $result->fetchArray(SQLITE3_ASSOC)) !== false) {
            $elements[] = $element;
        }
        // Apresentação
        return $elements;
    }

}

