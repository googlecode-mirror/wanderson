<?php

/**
 * Camada de Modelo para Arquivos
 *
 * Centralização de processamentos para arquivos que são enviados ao sistema,
 * utilizando uma arquitetura básica de armazenamento. Utiliza um manipulador
 * para salvar as informações adicionais do arquivo.
 *
 * @category WSL
 * @package  WSL_Model
 * @package  File
 */
class WSL_Model_File_File {

    /**
     * Caminho Completo do Arquivo no Sistema
     * @var string
     */
    protected $_realPath = null;

    /**
     * Valor Hash do Arquivo
     * @var string
     */
    protected $_hash = null;

    /**
     * Nome do Recipiente
     * @var string
     */
    protected $_container = '';

    /**
     * Nome da Categoria
     * @var string
     */
    protected $_category = '';

    /**
     * Valor de Referência
     * @var int
     */
    protected $_reference = 0;

    /**
     * Valor de Posicionamento
     * @var int
     */
    protected $_order = 0;

    /**
     * Nome Original do Arquivo
     * @var string
     */
    protected $_fileName = '';

    /**
     * Configurações Adicionais
     * @var WSL_Model_Config
     */
    protected $_config = null;

    /**
     * Caminho Base para Armazenamento
     * @var string
     */
    protected static $_basePath = '';

    /**
     * Caminho Temporário para Armazenamento
     * @var string
     */
    protected static $_tempPath = '';

    /**
     * Manipulador de Informações
     * @var WSL_Model_File_InfoHandlerInterface
     */
    protected static $_handler = null;

    /**
     * Construtor Padrão
     *
     * Reponsável pela inicialização de instâncias de classes para arquivos
     * armazenados em disco. Método com visibilidade privada pois temos um
     * padrão de projeto para construir determinado elemento.
     *
     * @param string $realPath Caminho Completo do Arquivo
     */
    private function __construct($realPath) {
        // Configuração
        $this->_setRealPath($realPath);
    }

    /**
     * Captura de Configurações
     *
     * Apresenta o objeto de configurações adicionais utilizado para armazenar
     * outros dados não relacionados no objeto, facilitando a adição de novos
     * valores.
     *
     * @return WSL_Model_Config Valor Solicitado
     */
    public function getConfig() {
        // Inicializado?
        if (empty($this->_config)) {
            $this->_config = new WSL_Model_Config();
        }
        // Apresentação
        return $this->_config;
    }

    /**
     * Configuração do Hash do Arquivo
     *
     * @param  string $hash Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    protected function _setHash($hash) {
        // Configuração
        $this->_hash = (string) $hash;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Hash do Arquivo
     *
     * @return string Valor Solicitado
     */
    public function getHash() {
        // Apresentação
        return $this->_hash;
    }

    /**
     * Configuração do Caminho Completo do Arquivo
     *
     * Configura o valor do caminho completo do arquivo dentro do sistema de
     * arquivos utilizado para armazenar o conteúdo.
     *
     * @param  string $realPath Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    protected function _setRealPath($realPath) {
        // Configuração
        $this->_realPath = (string) $realPath;
        // Encadeamento
        return $this;
    }

    /**
     * Apresentar Caminho Completo do Arquivo
     *
     * Informa o caminho completo do arquivo armazenado no sistema operacional,
     * exibindo todos os diretórios superiores. O caminho base é utilizado e o
     * hash é utilizado para construção do arquivo no sistema.
     *
     * @return string Valor Solicitado
     */
    public function getRealPath() {
        // Apresentação
        return $this->_realPath;
    }

    /**
     * Salvar Elementos
     *
     * Utilizado para sincronização de arquivos dentro do sistema, salvando as
     * informações armazenadas no elemento na estrutura de armazenamento de
     * arquivos e no manipulador de arquivos.
     *
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function save() {
        // Salvar Arquivo
        if (self::getDefaultHandler()->save($this)) {
            // Arquivo Existe?
            if ($this->exists()) {
                // Nome de Arquivo Alvo
                $hashPath = self::_buildHashPath($this->getHash());
                // Adicionar Diretórios Necessários
                $dirname = dirname($hashPath);
                // Existe Diretório?
                if (!is_dir($dirname)) {
                    mkdir($dirname, 0777, true);
                }
                // Adicionar uma Cópia do Arquivo na Estrutura de Diretórios
                copy($this->getRealPath(), $hashPath);
                // Configurar Novo Caminho de Arquivo
                $this->_setRealPath($hashPath);
            }
        }
        // Encadeamento
        return $this;
    }

    /**
     * Remoção de Elemento
     *
     * Remove uma referência a arquivos armazenados no sistema. Estes arquivos
     * nem sempre devem ser removidos do disco, somente quando há permissão do
     * objeto manipulador das informações.
     *
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function delete() {
        // Remover Arquivo
        if (self::getDefaultHandler()->delete($this)) {
            // Arquivo Existe?
            if ($this->exists()) {
                // Remover Fisicamente o Arquivo
                unlink($this->getRealPath());
            }
        }
        // Encadeamento
        return $this;
    }

    /**
     * Executa a Comparação entre Arquivos
     *
     * Verifica se os códigos de Hash dos arquivos são idênticos, caracterizando
     * assim os mesmos conteúdos que foram armazenados no sistema.
     *
     * @param  WSL_Model_File_File $file Arquivo para Comparação
     * @return bool Confirmação Solicitada
     */
    public function equals(WSL_Model_File_File $file) {
        // Comparação
        return $this->getHash() == $file->getHash();
    }

    /**
     * Informa se Arquivo Existe
     *
     * Durante alguns processamentos e principalmente divisão em ambientes de
     * desenvolvimento, nas máquinas distribuídas não existirão os arquivos.
     * Portanto, é possível a construção de um objeto do tipo arquivo, sem um
     * conteúdo propriamente dito em disco.
     *
     * @return bool Confirmação Solicitada
     */
    public function exists() {
        return is_file($this->getRealPath());
    }

    /**
     * Configuração de Recipiente
     *
     * @param  string $container Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setContainer($container) {
        // Configuração
        $this->_container = (string) $container;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Recipiente
     *
     * @return string Valor Solicitado
     */
    public function getContainer() {
        // Apresentação
        return $this->_container;
    }

    /**
     * Configuração de Categoria
     *
     * @param  string $category Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setCategory($category) {
        // Configuração
        $this->_category = (string) $category;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Categoria
     *
     * @return string Valor Solicitado
     */
    public function getCategory() {
        // Apresentação
        return $this->_category;
    }

    /**
     * Configuração de Referência
     *
     * @param  int $reference Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setReference($reference) {
        // Configuração
        $this->_reference = (int) $reference;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Referência
     *
     * @return int Valor Solicitado
     */
    public function getReference() {
        // Apresentação
        return $this->_reference;
    }

    /**
     * Configuração de Posicionamento
     *
     * @param  int $order Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setOrder($order) {
        // Configuração
        $this->_order = (int) $order;
        // Encadeamento
        return $this;
    }

    /**
     * Informação de Posicionamento
     *
     * @return int Valor Solicitado
     */
    public function getOrder() {
        // Apresentação
        return $this->_order;
    }

    /**
     * Configura o Nome Original do Arquivo
     *
     * @param  string $fileName Valor para Configuração
     * @return WSL_Model_File_File Próprio Objeto para Encadeamento
     */
    public function setFileName($fileName) {
        // Configuração
        $this->_fileName = (string) $fileName;
        // Encadeamento
        return $this;
    }

    /**
     * Apresenta o Nome Original do Arquivo
     *
     * @return string Valor Solicitado
     */
    public function getFileName() {
        // Apresentação
        return $this->_fileName;
    }

    /**
     * Captura do Conteúdo do Arquivo
     *
     * Verifica se o arquivo existe em disco e apresenta o seu conteúdo; caso
     * contrário, será apresentado um conteúdo vazio.
     *
     * @return string Conteúdo do Arquivo Solicitado
     */
    public function getContent() {
        // Inicialização
        $result = '';
        // Existe Arquivo?
        if ($this->exists()) {
            $result = file_get_contents($this->getRealPath());
        }
        // Apresentação
        return $result;
    }

    /**
     * Configura o Caminho Base para Arquivos
     *
     * @param string $basePath Valor para Configuração
     */
    public static function setBasePath($basePath) {
        // Configuração
        self::$_basePath = (string) $basePath;
    }

    /**
     * Apresenta o Caminho Base para Arquivos
     *
     * @return string Valor Configurado
     */
    public static function getBasePath() {
        // Apresentação
        return self::$_basePath;
    }

    /**
     * Configura o Caminho Temporário para Arquivos
     *
     * @param string $tempPath Valor para Configuração
     */
    public static function setTempPath($tempPath) {
        // Configuração
        self::$_tempPath = (string) $tempPath;
    }

    /**
     * Apresenta o Caminho Temporário para Arquivos
     *
     * @param string Valor Configurado
     */
    public static function getTempPath() {
        // Apresentação
        return self::$_tempPath;
    }

    /**
     * Sincronização de Elementos
     *
     * Método responsável pela sincronização de elementos, recebendo como
     * parâmetro dois conjuntos de arquivos, onde o primeiro representa os
     * arquivos já salvos no sistema e o outro os arquivos considerados como
     * novos na estrutura. Todos os arquivos do segundo elemento serão
     * considerados, ao final da execução, os novos arquivos com o devido
     * posicionamento necessário e valores atualizados serão retornados.
     *
     * @param  array $oldfiles Conjunto de Arquivos Antigos
     * @param  array $newfiles Conjunto de Arquivos Novos
     * @return array Conjunto de Arquivos Sincronizados
     */
    public static function synchronize(array $oldfiles, array $newfiles) {
        // Salvar Posicionamentos
        $counter = 0;
        $element = reset($newfiles);
        while ($element !== false) {
            $element->setOrder($counter++);
            $element = next($newfiles);
        }
        // Remoção de Elementos
        foreach ($oldfiles as $oldfile) {
            $search = null;
            foreach ($newfiles as $index => $newfile) {
                if ($oldfile->equals($newfile)) {
                    $search = $newfiles[$index] = $oldfile->setOrder($newfile->getOrder());
                }
            }
            // Elemento Encontrado?
            if (empty($search)) {
                // Não Encontrado: Remover
                $oldfile->delete();
            }
        }
        // Salvar Elementos Novos
        foreach ($newfiles as $newfile) {
            $newfile->save();
        }
        // Apresentação
        return $newfiles;
    }

    /**
     * Configuração do Manipulador de Informações
     *
     * Utilizado para salvar informações adicionais sobre o arquivo armazenado
     * no sistema operacional e que precisa de registros adicionais, como
     * categorias que estão relacionadas com o objeto.
     *
     * @param WSL_Model_File_InfoHandlerInterface $handler Elemento para Configuração
     */
    public static function setDefaultHandler(WSL_Model_File_InfoHandlerInterface $handler) {
        // Configuração
        self::$_handler = $handler;
    }

    /**
     * Apresentação do Manipulador de Informações
     *
     * Elemento utilizado para gerenciamento de informações adicionais aos
     * arquivos aplicados na árvore de diretórios do sistema.
     *
     * @return WSL_Model_File_InfoHandlerInterface
     */
    public static function getDefaultHandler() {
        // Apresentação
        return self::$_handler;
    }

    /**
     * Construção de Nome de Arquivo na Árvore de Diretórios
     *
     * Apresenta o caminho completo do arquivo será armazenado na árvore de
     * diretórios conforme o Hash apresentado. O nome completo do arquivo será o
     * caminho base concatenado com divisor de diretórios, primeiros 3
     * caracteres do Hash, divisor de diretórios, próximos 3 caracteres do Hash,
     * divisor de diretórios e os outros 36 caracteres. Logo, temos o seguinte
     * exemplo:
     *
     * $hash = ec7117851c0e5dbaad4effdb7cd17c050cea88cb
     * $path = [BASEPATH]/ec7/117/851c0e5dbaad4effdb7cd17c050cea88cb
     *
     * @param  string $hash Valor Base para Construção
     * @return string Caminho do Arquivo na Estrutura de Diretórios
     */
    protected static function _buildHashPath($hash) {
        // Construção
        return self::getBasePath()
            . DIRECTORY_SEPARATOR . substr($hash, 0, 3)
            . DIRECTORY_SEPARATOR . substr($hash, 3, 3)
            . DIRECTORY_SEPARATOR . substr($hash, 6);
    }

    /**
     * Construção de Arquivos por Referências
     *
     * Consulta o manipulador de arquivos com os parâmetros apresentados,
     * fornecendo os hashes que devem ser utilizados na captura dos arquivos.
     * Estes arquivos serão novamente apresentados ao manipulador para
     * carregamento das informações adicionais.
     *
     * @param  string $container Recipiente de Armazenamento
     * @param  string $category  Categoria Relacionada
     * @param  int    $reference Referência Cruzada
     * @return array  Conjunto de Arquivos Encontrados
     */
    public static function findFromReferences($container, $category, $reference) {
        // Captura de Hashes
        $hashes = self::getDefaultHandler()->find($container, $category, $reference);
        // Construção de Elementos
        $elements = self::findFromHashes($hashes);
        // Configurações Básicas
        foreach ($elements as $order => $element) {
            $element // Configuração
                ->setContainer($container)
                ->setCategory($category)
                ->setReference($reference)
                ->setOrder($order);
        }
        // Carregar Informações Adicionais
        self::getDefaultHandler()->load($elements);
        // Apresentar Elementos
        return $elements;
    }

    /**
     * Construção de Arquivos por Hash
     *
     * Efetua uma busca no diretório padrão de armazenamento pelo código de Hash
     * apresentado, construindo o elemento. Caso não seja encontrado, será
     * também consultado o diretório de armazenamento temporário de arquivos.
     *
     * @param  array $hashes Conjunto de Códigos para Busca
     * @return array Conjunto de Arquivos Encontrados
     */
    public static function findFromHashes(array $hashes) {
        // Inicialização
        $elements = array();
        // Consultar os Arquivos
        foreach ($hashes as $hash) {
            // Captura de Arquivo em Árvore Local
            $path = self::_buildHashPath($hash);
            // Arquivo Existe?
            if (!is_file($path)) {
                // Captura de Arquivo em Diretório Temporário
                $path = self::getTempPath() . DIRECTORY_SEPARATOR . $hash;
            }
            // Construção de Elemento
            $element = new self($path);
            // Configurar Hash
            $element->_setHash($hash);
            // Adicionar ao Conjunto
            $elements[] = $element;
        }
        // Apresentação
        return $elements;
    }

    /**
     * Construção de Arquivo pelo Caminho
     *
     * Recebendo como parâmetro o caminho do arquivo, será criado um objeto
     * relacionado, inicializando os parâmetros básicos. Verifica se o arquivo
     * existe em disco, caso contrário será apresentado um erro.
     *
     * @param  string $realPath Caminho Completo do Arquivo
     * @return WSL_Model_File_File Elemento Construído com os Parâmetros
     * @throws Exception Arquivo não Existente em Disco
     */
    public static function buildFromRealPath($realPath) {
        // Caminho Completo do Arquivo
        $realPath = realpath($realPath);
        // Arquivo Existe em Disco?
        if (empty($realPath)) {
            throw new Exception("Invalid RealPath: '$realPath'");
        }
        // Construção do Objeto Relacionado
        $element = new self($realPath);
        // Configurações Básicas
        $element->_setHash(sha1_file($realPath));
        // Apresentação
        return $element;
    }

    /**
     * Construção de Arquivo por Conteúdo
     *
     * Informando um nome de arquivo e conteúdo para armazenamento, será criado
     * em disco um arquivo com o conteúdo apresentado e o objeto relacionado
     * receberá o nome do arquivo apresentado.
     *
     * @param  string $fileName Nome do Arquivo para Configuração
     * @param  string $content  Conteúdo para Armazenamento
     * @return WSL_Model_File_File Elemento Construído com os Parâmetros
     */
    public static function buildFromContent($fileName, $content) {
        // Criação de Arquivo Temporário
        $realPath = tempnam(sys_get_temp_dir(), 'wslmff');
        // Armazenar Conteúdo em Disco
        file_put_contents($realPath, $content);
        // Criação de Elemento
        $element = self::buildFromRealPath($realPath);
        // Configurar Nome de Arquivo
        $element->setFileName($fileName);
        // Apresentar Elemento
        return $element;
    }

}
