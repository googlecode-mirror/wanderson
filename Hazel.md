# Hazel #

Esta página visa documentar a biblioteca Hazel (Hazel Zend Framework Extended
Library), que busca especializar as classes de desenvolvimento do Zend
Framework. _Esta documentação está incompleta e carece de informações_.

## Hazel\_Controller ##

Pacote http://code.google.com/p/wanderson/source/browse/trunk/Hazel/Controller/

O pacote de controle do Hazel trabalha com especializações para manipulação de objetos provenientes do banco de dados. Se existe uma entidade no banco de dados que pode ser trabalhada através do padrão CRUD, utilizando um formulário e uma tabela somente, a classe `Hazel_Controller_DatabaseCrudAbstract` pode ser estendida. Esta classe possui as ações padrão para edição e toda a programação necessária para edição simples das informações.

A idéia principal da classe é que toda a programação seja encapsulada nas controladoras e caso seja necessário a modificação de alguns métodos, estes
consigam ser sobrescritos, afetando ao mínimo o fluxo de processamento; ou sejam adicionados métodos nas classes de formulário e tabela, dando flexibilidade à programação.

Para exemplificar, temos a seguinte tabela de usuários de um sistema, criada em banco de dados PostgreSQL:

```
-- migration usuario-up 10 lines
CREATE TABLE usuario
(
    idusuario SERIAL,
    display   VARCHAR(40),
    nome      VARCHAR(20) NOT NULL UNIQUE,
    senha     CHAR(32) NOT NULL,
    ativado   BOOLEAN NOT NULL DEFAULT TRUE,
    deletado  BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY(idusuario)
);
```

Podemos criar uma classe representante desta tabela utilizando o padrão de aplicativos do Zend Framework:

```
<?php

/**
 * Tabela de Usuários
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH /model/DbTable/Usuario.php
 */
class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{
    protected $_name = 'usuario';
    protected $_primaries = array('idusuario');
}
```

Também vamos criar um formulário para edição destes dados para uma linha da tabela. Note que é importante a adição de um filtro de elementos nulos à chave primária representante neste formulário: ele é utilizado tanto para inserção ou atualização dos dados, pois se a chave primária é zerada pelo filtro de inteiros, então o filtro de elementos nulos irá retornar nulo e o elemento será salvo no banco; caso contrário ele é atualizado. Se este filtro de valores nulos não fosse inserido neste caso, um elemento de chave primária de valor zero será criado, o que não queremos que aconteça. Vejamos o exemplo abaixo:

```
<?php

/**
 * Formulário de Usuário
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH /forms/Usuario.php
 */
class Application_Form_Usuario extends Zend_Form
{
    public function init()
    {
        $idusuario = new Zend_Form_Element_Hidden('idusuario');
        $idusuario->loadDefaultDecorators();
        $idusuario->removeDecorator('Label')->setRequired(true)
            ->addFilter(new Zend_Filter_Int())
            ->addFilter(new Zend_Filter_Null());
        $this->addElement($idusuario);

        $display = new Zend_Form_Element_Text('display');
        $display->setLabel('Nome Completo')->setRequired(true)
            ->setAllowEmpty(true)->addFilter(new Zend_Filter_Null())
            ->addValidator(new Zend_Validate_StringLength(1,40))
            ->addValidator(new Zend_Validate_Alnum(true));
        $this->addElement($display);

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Usuário')->setRequired(true)->setAllowEmpty(false)
            ->addValidator(new Zend_Validate_NotEmpty())
            ->addValidator(new Zend_Validate_StringLength(1,20))
            ->addValidator(new Zend_Validate_Alpha(false))
            ->addFilter(new Zend_Filter_StringToLower());
        $this->addElement($nome);

        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha')->setRequired(false)->setAllowEmpty(true)
            ->setRenderPassword(false);
        $this->addElement($senha);

        $ativado = new Zend_Form_Element_Checkbox('ativado');
        $ativado->setLabel('Ativado')->addFilter(new Zend_Filter_Boolean());
        $this->addElement($ativado);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Gravar')->setIgnore(true);
        $this->addElement($submit);

        $this->setName('usuario_form')->setMethod(self::METHOD_POST);
    }
}
```

Para estes dados, podemos construir o controle de usuários da seguinte forma:

```

/**
 * Controle de Usuários
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH /controllers/UsuarioController.php
 */
class UsuarioController extends Hazel_Controller_DatabaseCrudAbstract
{
}
```

Quando a classe é estendida, métodos representantes do padrão CRUD são criados no controle para manipulação dos dados. Lembramos que o nome do formulário e da tabela devem seguir o padrão do nome da controladora para que sejam automaticamente carregados. Se precisamos de um controle de `Musica`, devemos criar a classe de controle `MusicaController`, o formulário `Application_Form_Musica` e a representante de tabela `Application_Model_DbTable_Musica`. Não há problemas quando estas classes são criadas em módulos: a classe do Hazel pesquisa corretamente os locais. Se temos o módulo `Servico` e o controle de `Servico_RelatorioController`, necessitamos criar o formulário `Servico_Form_Relatorio` e a representante da tabela `Servico_Model_DbTable_Relatorio`.

Se há necessidade de carregamento de um formulário ou tabela de nomes diferentes, podemos configurar o atributo da classe na controladora, informando qual classe representante deve ser utilizada.

```
<?php

/**
 * Controle de Usuários Modificado
 * Podemos Informar Outra Classe de Tabela ou Formulário
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH /controllers/UsuarioController.php
 */
class UsuarioController extends Hazel_Controller_DatabaseCrudAbstract
{
    /**
     * Nome da Classe de Tabela
     * @var string
     */
    protected $_dbtable = 'Application_Model_DbTable_Pessoas';

    /**
     * Nome do Formulário
     * @var string
     */
    protected $_form = 'Application_Form_Login';
}
```

Ainda utilizando o exemplo de controle de `Usuario`, devemos criar as visualizações, que não são executadas automaticamente para que seja possível a renderização especializada, como o `Zend_View_Helper_PaginationControl`.

Um modelo de visualização de dados em tabela pode ser construído para a ação `retrieve` do controle de `Usuario` da seguinte maneira:

```
<!-- @see APPLICATION_PATH /views/scripts/datagrid.phtml -->
<?php if (count($this->messages) > 0) : ?>
<ul>
<?php foreach ($this->messages as $message) : ?>
    <li><?php echo $message ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>
<table>
    <tr>
<?php foreach ($this->columns as $column => $label) : ?>
        <th><a href="<?php echo $this->url(array('order' => $column)) ?>"><?php echo $label?></a></th>
<?php endforeach ?>
        <th colspan="2"><a href="<?php echo $this->url(array('action' => 'create', 'order' => null, 'page' => null)) ?>">Adicionar</a></th>
    </tr>
<?php if (count($this->result) > 0) : ?>
<?php foreach ($this->result as $element) : ?>
    <tr>
<?php foreach ($this->columns as $column => $label) : ?>
        <td><?php echo $element->$column ?></td>
<?php endforeach ?>
<?php $search = array('order' => null, 'page' => null) ?>
<?php foreach ($this->primaries as $primary) : ?>
<?php $search[$primary] = $element->$primary ?>
<?php endforeach ?>
        <td><a href="<?php echo $this->url(array_merge($search, array('action' => 'update'))) ?>">Visualizar</a></td>
        <td><a href="<?php echo $this->url(array_merge($search, array('action' => 'delete'))) ?>">Deletar</a></td>
    </tr>
<?php endforeach ?>
<?php else : ?>
    <tr>
        <td colspan="<?php echo count($this->columns) + 2 ?>">Lista Vazia</td>
    </tr>
<?php endif ?>
</table>
```

Este padrão de elementos em tabela é renderizado no arquivo `retrieve.phtml` da camada de visualização utilizando método específico:

```
<!-- @see APPLICATION_PATH /views/scripts/usuario/retrieve.phtml -->
<?php echo $this->render('datagrid.phtml'); ?>
```

Os outros arquivos de visualização recebem o seguinte conteúdo de programação:

```
<!-- @see APPLICATION_PATH /views/scripts/usuario/create.phtml -->
<?php echo $this->form ?>
```

```
<!-- @see APPLICATION_PATH /views/scripts/usuario/update.phtml -->
<?php echo $this->form ?>
```

Não há encapsulamento destas execuções pois geralmente são necessários dados adicionais referente ao conteúdo, sobre como um usuário deve ser adicionado ou saída de dados que auxiliam o utilizador do sistema a trabalhar.

As colunas para exibição nos dados tabulares podem ser modificadas configurando as colunas no controle. As informações são passadas através de _arrays_ associativos onde a chave fornece o nome da coluna para renderização da tabela e o valor trabalha como tituleira da coluna, preenchendo o cabeçalho.

```

/**
 * Controle de Usuários Modificado
 * Modificação de Colunas Exibidas na Listagem
 * @author Wanderson Henrique Camargo Rosa
 * @see    APPLICATION_PATH /controllers/UsuarioController.php
 */
class UsuarioController extends Hazel_Controller_DatabaseCrudAbstract
{
    /**
     * Colunas para Exibição
     * @var array
     */
    protected $_columns = array('display' => 'Nome', 'nome' => 'Usuário');
}
```