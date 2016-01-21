# Introdução #

Esta página visa documentar a utilização do pacote de formatação de referẽncias bibliográficas do Hazel. Será apresentado o problema decorrente da formatação de bibliografias em artigos, um estudo de caso de padrão para referências e como podemos construir um conjunto de classes capaz de separar dados de cadastro e formatação.

# Descrição #

Ao desenvolvermos artigos para Blog, nem sempre estamos preparados ou utilizamos referências bibliográficas para estudos mais aprofundados. Com a iniciativa de documentação brasileira de Zend Framework, foi necessária a construção de um conjunto de classes que separassem o cadastro de referências bibliográficas, formatação e normas técnicas e saída para HTML.

## Banco de Dados de Referências ##

Podemos criar um banco de dados para referências bibliográficas que armazene as informações de documentos variados em que nosso trabalho foi idealizado. O problema é que nem sempre os documentos possuem as mesmas características, gerando problemas em tempo de construção de tabela capaz de armazenar estas informações. A técnica utilizada foi de armazenamento dos dados em uma única coluna de tabela.

Porém temos outro problema. Devemos criar um algoritmo capaz de efetuar a leitura de um texto padronizado que será armazenado nesta coluna da tabela. Algo parecido já existe na programação, chamado BibTeX, um motor de formatação de referências bibliográficas. Este motor separa os dados de documentos e a lógica de formatação, dando a capacidade de troca desta em tempo de execução.

Logo, podemos criar um tradutor que receba este conteúdo representante da referência e transforme num objeto de documento. Este documento deve possuir um gerenciador que será responsável pela formatação em normas técnicas e, completando a necessidade do nosso problema, saída em HTML.

## Estrutura de Bibliografia ##

Conforme descrito anteriormente, o formato de descrição de bibliografia é muito semelhante ao BibTeX, porém com algumas restrições para facilitar a programação. Futuramente outras capacidades utilizadas pelo BibTeX poderão ser implementadas. Um livro pode ser descrito da seguinte maneira:

```
@book{aho1988,
    author    = "Alfred V. Aho and Ravi Sethi and Jeffrey D. Ullman",
    title     = "Compilers: Principles, Techniques and Tools",
    publisher = "Addison-Wesley",
    year      = "1988"
}
```

Este conteúdo poderá ser salvo em banco de dados e previamente traduzido para uma classe bibliográfica. O tipo de documento é descrito como `@book` e devemos criar um corpo para armazenar as informações, envolvido entre chaves. A primeira informação do corpo é o identificador do documento `aho1988` e considerado único em todo o banco de dados. Todas as informações posteriores são dados sobre o livro, separados entre vírgulas. Para níveis avançados, as expressões regulares de captura de documento e parâmetros internos estão descritas abaixo:

```
PATTERN_DOCUMENT = '/^\s*@([a-z][a-zA-Z]*)\s*\{([a-zA-Z0-9]+),([^}]*)\}\s*$/';
PATTERN_ELEMENT = '/^\s*([a-z][a-zA-Z]*)\s*=\s*"([^"]*)"\s*$/';
```

## Objeto de Bibliografia ##

Cada tipo de documento deverá receber um objeto representante no pacote de bibliografia para encapsulamento de informações e testes de preenchimento. Logo, podemos verificar se determinadas informações foram corretamente preenchidas. Todas as classes de bibliografia devem extender a classe `Hazel_Bibliography_DocumentAbstract`. As classes podem ser encontradas no subpacote `Document` deste pacote e são nomeadas conforme padrão de formatação de nomes do Zend Framework.

Os tipos de documentos devem ter como último nome da classe o nome identificador de tipo com a primeira letra em capital. Desta forma, o tipo de documento `@book` deverá ter como classe representante `Hazel_Bibliography_Document_Book` ou o tipo de documento `@article` deverá ter como classe representante `Hazel_Bibliography_Document_Article`. Isto é necessário para criação de um tradutor capaz de encontrar facilmente a classe representante do conteúdo salvo no banco de dados, através do Padrão de Projeto _Factory_.

## Classe de Livros ##

A classe de bibliografia para o tipo livros é a primeira representante de tipos de documentos. Como todas as classes que serão desenvolvidas, ela extende da classe `Hazel_Bibliography_DocumentAbstract`. Os livros aqui descritos possuem quatro atributos: `author`, `title`, `publisher` e `year`, que deverão ser criados na classe representante e encapsulamentos com `get` e `set` devem ser criados. O código-fonte pode ser encontrado em [Book.php](http://code.google.com/p/wanderson/source/browse/trunk/Hazel/Bibliography/Document/Book.php).

## Formatação de Referências ##

A lógica de formatação de referências está separada da classe representante da estrutura da referência. Isto fornece uma abstração de programação, podendo ser modificada a formatação padrão e até inclusas novos tipos de normas para renderização. O pacote bibliográfico possui uma classe de formatação chamada `Hazel_Bibliography_FormatterAbstract` responsável pela formatação de documentos. Todas as classes de formatação devem ser extendidas desta classe para manter o encapsulamento e armazenadas no subpacote `Formatter`

Para formatar um tipo de documento, devemos criar na classe extendida um método que tenha como prefixo `format` e o nome do tipo do documento capitalizado, com somente um argumento que será o documento a ser formatado. Logo, para criarmos um formatador e a regra de formatação de livros, a assinatura do método deverá ser `formatBook($document)`. Abaixo temos a estrutura de classe básica para um formatador _default_ que possui regras de formatação de livros e artigos.

```
class Hazel_Bibliography_Formatter_Default
    extends Hazel_Bibliography_FormatterAbstract
{
    public function formatBook($document) { /* method */ }
    public function formatArticle($document) { /* method */ }
}
```

Portanto, todas as regras de formatação são armazenadas na mesma classe de regras. A classe abstrata extendida possui tratamento de erros caso exista uma chamada de método não  desenvolvido, gerando uma exceção específica do pacote `Hazel_Bibliography_Exception`. Para formatação de um documento conforme normas _default_, devemos trabalhar da seguinte maneira:

```
$document  = new Hazel_Bibliography_Document_Book();
$formatter = new Hazel_Bibliography_Document_Default();
echo $formatter->format($document);
```

O próprio formatador será responsável pela escolha do método adequado em tempo de execução.

## Gerenciamento de Documentos ##

Um texto que recebe referências bibliográficas nem sempre possui somente uma fonte para consulta. Devemos então criar um gerenciador capaz de receber todos os documentos relacionados, o formatador de documentos e saber como deverá ser feita a saída HTML. Para isto foi criada a classe `Hazel_Bibliography_Manager` responsável por estas características e pela tradução do formato BibTeX para objetos do pacote, através do método estático `factory($content)`.

Para finalização, ainda precisamos de uma classe responsável pela saída HTML. O Padrão de Projeto _Decorator_ é utilizado neste caso, onde uma classe especializada deve ser extendida da classe `Hazel_Bibliography_DecoratorAbstract`, que exige o método de instância `render($content)`. O argumento `$content` é um conjunto de elementos formatados, portando `array` de variáveis do tipo `string`. O método é a última camada da renderização do gerenciador de documentos.

## Utilização do Conjunto de Pacotes ##

Um documento pode ser adicionado diretamente no formato BibTeX através do método de instância `parseDocument($content)`. Por padrão, em tempo de construção do gerenciador são adicionados o formatador `Hazel_Bibliography_Formatter_Default` e o decorador `Hazel_Bibliography_Decorator_List`. **Nota:** Como o projeto atualmente conta somente com o tipo de documento `@book` e o exemplo abaixo somente possui saída para o livro `aho1988`. Portanto, há necessidade de inclusão de tipo de documento `@article` e atualização do exemplo.

```
$book    = $table->findDocument('aho1988');  // Consulta Qualquer do BibTeX no Banco
$article = $table->findDocument('rosa2010'); // Consulta Qualquer do BibTeX no Banco

$manager = new Hazel_Bibliography_Manager();
$manager->parseDocument($book)
        ->parseDocument($article);
/*
 * Outputs:
 * <ul>
 *     <li>AHO, A. V.;SETHI, R.;ULLMAN, J. D. (1988).
 *         Compilers: Principles, Techniques and Tools. Addison-Wesley.</li>
 * </ul>
 */
echo $manager->render();
```

Podemos criar novos objetos de formatação e decoração extendendo as classes específicas. Eles podem ser adicionados ao gerenciador através do encapsulamento.

```
$formatter = new Hazel_Bibliography_Formatter_Default();
$decorator = new Hazel_Bibliography_Decorator_List();
$manager->setFormatter($formatter)
        ->setDecorator($decorator);
```

## Finalização ##

Existem alguns problemas que devem ser considerados durante a utilização deste conjunto de classes.

  * A estrutura do documento salvo em banco de dados e utilizada pelo tradutor do gerenciador de documentos é uma sublinguagem do BibTeX original e deve seguir fielmente o padrão de captura descrito anterior. Caso o conteúdo não esteja nas normas, será atirada uma exceção com mensagem descrevendo o problema.
  * Atualmente só existe o tipo de documento `Book`. Devemos implementar outros tipo e inclusive criar os métodos que exigem a configuração de parâmetros necessários. Esta exigência é implementada no subpacote `Document` e não no `Formatter`, como anteriormente idealizado.
  * Valores descritos entre aspas duplas não devem possuir estas aspas escapadas, dado que o padrão de captura não suporta este conteúdo. Verificar o escape e captura.

Conseguimos com esta estrutura separar a lógica de armazenamento e cadastro de referências bibliográficas com `Document`, formatação conforme normas técnicas com `Formatter` e saída HTML com `Decorator`. Podemos implementar novas funcionalidades, como outros tipos de documentos, formatadores IEEE ou ABNT e decoradores em listas de descrição DL.