# Idealização #

Devido a uma necessidade de conteúdo sobre desenvolvimento em PHP utilizando Zend Framework, venho por meio deste documento registrar uma idealização de um Blog que contenha documentação especializada em criação de aplicativos e estruturas utilizando a ferramenta.
Para que isto seja possível, precisamos de um modelo de aplicativo em que os leitores estejam bem ambientados, e este deverá ser desenvolvido utilizando a biblioteca Zend Framework.

## Escolha de Modelo ##

Um Blog poderá ser construído utilizando ZF e, enquanto este está sendo desenvolvido, deverá ser utilizado para documentar a programação e tutoriais de técnicas avançadas utilizadas. Isto pode ser considerado um paradoxo pois, o aplicativo gerado somente pode ser desenvolvido concorrentemente à documentação, porém não possuímos um aplicativo completo para receber a documentação. Logo, uma primeira parte do Blog deverá ser construída até que seja possível o desenvolvimento textual.

Existem ferramentas prontas para criação de Blogs. Este projeto não visa competir com estas, mas irá utilizar muitas das suas características. Funcionalidades como _indexing_ facilitado aos sites de busca, controle de categorias e registros bibliográficos devem ser incluídos.

## Características ##

O Blog deverá ser capaz:

  * Possuir no mínimo dois módulos
    * Externo para visualização da documentação pelo leitor
    * Interno para edição dos documentos gerados
  * Controle de documentos por categoria e por etiquetas
  * Facilitar _indexing_ de sites de busca fornecendo metainformações do documento
  * Administrar autores que terão acesso ao módulo interno
  * Controlar referências bibliográficas dos documentos e formatação

Serão tratadas como necessidades primárias para foco do projeto:

  * Módulo externo deve ser padronizado segundo as normas da W3C
    * Facilidade para que leitores diversos consigam visualizar o conteúdo apresentado
  * Módulo interno pode não respeitar as padronizações da W3C
    * Facilidade em tempo de programação que trabalha com técnicas adicionais não padronizadas, como atributos de _tags_ para _Dojo Toolkit_ no estilo marcação

# Análise de Requisitos #

Para criação deste Blog, necessitamos de um local específico para armazenamento na linha de desenvolvimento deste repositório. Para isto, registramos a localização `Blog/`, subdiretório da linha principal `trunk/`, centralizando assim o código gerado.

## Estrutura Base ##

O Blog deverá primeiramente possuir uma estrutura base para receber o desenvolvimento. Conforme padronização do ZF, a estrutura padrão de projeto será utilizada. Dois módulos deverão ser desenvolvidos: `default` e `publisher`.

O módulo `default` deverá receber toda a programação de visualização externa de documentação, para leitura dos artigos, pesquisa de categorias e etiquetas, bem como seguir documentos relacionados, _feeders_ ou versões de impressão.

Já o módulo `publisher` será responsável pela administração de conteúdo relacionado à criação de artigos, fornecendo ferramentas específicas para este fim. Junto aos artigos, podemos considerar outras informações periféricas como dados do autor, controle de bibliografia, categorias, etiquetas e outras adiante descritas.

Acrescentando, o módulo `admin` deverá controlar os usuários, _logs_ de erros e outras coisas necessárias para que o sistema sobreviva.

O controle de usuários deverá ser feito por grupos hierárquicos. Teremos dois grupos de usuários: `Administradores` e `Contribuidores`. Um usuário do grupo de `Contribuidores` terá direito a trabalhar no módulo `publisher`. Já os `Administradores` poderão manipular o módulo `admin`.

## Autores e Autenticação ##

Um Blog armazena artigos que devem ser registrados por autores previamente cadastrados. Estes autores deverão entrar no aplicativo mediante credenciais. Portanto, precisamos de uma controladora de **Autores** do Blog que forneça manutenção nestes dados. São necessários dados como `nome`, `usuário`, `senha`, `ativo` e `removido`. Também devemos cadastrar a última vez que este usuário entrou no sistema. Um usuário pertence a somente um grupo de usuários.