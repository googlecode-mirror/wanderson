<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Game of Life - John Conway | Wanderson Camargo</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="jquery.gameoflife.js"></script>
        <script type="text/javascript" src="gameoflife.js"></script>
        <link type="text/css" rel="stylesheet" href="gameoflife.css"/>
    </head>
    <body>
        <h1>John Conway's Game of Life</h1>
        <h2>por Wanderson Henrique Camargo Rosa</h2>
        <p>
            Olá! Este programa visa apresentar a primeira aplicação prática da
            disciplina de Desenvolvimento Web 2012/1 da Unisinos. Este programa
            exemplifica uma aplicação do "Jogo da Vida", um autômato celular
            desenvolvido pelo matemático John Conway na Universidade de
            Cambridge em 1970.
        </p>
        <p>
            Este jogo consiste num conjunto de células que, baseadas em poucas
            regras matemáticas, podem viver, morrer ou multiplicar-se.
            Dependendo do estado inicial, as células podem formar padrões. O
            jogo baseia-se nas seguintes regras:
        </p>
        <ul>
            <li>Células Vivas
                <ul>
                    <li>Cada célula com 1 ou nenhum vizinho morre de solidão;</li>
                    <li>Cada célula com 4 ou mais vizinhos morre com superpopulação; e</li>
                    <li>Cada célula com 2 ou 3 vizinhos sobrevive.</li>
                </ul>
            </li>
            <li>Células Mortas
                <ul>
                    <li>Cada célula com 3 vizinhos renasce.</li>
                </ul>
            </li>
        </ul>
        <p>
            Portanto, cada célula interage com seus 8 vizinhos, tanto na
            horizontal, vertical e diagonal. O padrão inicial sempre é
            alimentado ao sistema. Alguns padrões podem ser aplicados em
            qualquer região do ambiente e gerar formas que são consideradas como
            vidas permanentes.
        </p>
        <p>
            Para auxiliar nos testes, foram desenvolvidas algumas ferramentas
            buscando automatizar a criação do estado inicial do autômato. No
            formulário de configurações, podemos configurar a quantidade de
            colunas e de linhas que serão utilizadas no ambiente. Também temos a
            configuração para o intervalo de transição entre estados em
            milissegundos. Após apresentar as configurações necessárias, devemos
            gerar o campo, que será adicionado logo abaixo.
        </p>
        <p>
            Você pode utilizar o <i>mouse</i> para criar as sua estrutura
            preferida, clicando sobre as células do campo. Caso queira gerar um
            padrão randômico, basta pressionar o botão com este nome para
            preencher de forma aleatória as células. Para inicializar a
            simulação, pressione o botão inicial e para finalizar, pressione o
            botão parar. Lembre-se que para gerar outro campo é necessário
            utilizar o botão de gerar campo.
        </p>
        <p>
            Buscando tornar a tarefa mais simples, você pode salvar o estado do
            campo atual utilizando o bloco de memória. Para exportar um estado,
            pressione o botão exportar e copie a estrutura gerada dentro do
            conteúdo. Para importar, basta colocar uma estrutura exportada no
            campo de conteúdo e utilizar o botão importar.
        </p>
        <div class="columns2">
            <form name="config" action="#" method="get">
                <fieldset>
                    <legend>Configurações</legend>
                    <dl>
                        <dt><label for="config_columns">Número de Colunas</label></dt>
                        <dd><input id="config_columns" type="text" name="config_columns" class="integer" value="50"/></dd>
                        <dt><label for="config_rows">Número de Linhas</label></dt>
                        <dd><input id="config_rows" type="text" name="config_rows" class="integer" value="20"/></dd>
                        <dt><label for="config_rows">Tempo em Milissegundos</label></dt>
                        <dd><input id="config_interval" type="text" name="config_interval" class="integer" value="100"/></dd>
                        <dt>Ações</dt>
                        <dd>
                            <button type="submit">Gerar Campo</button>
                        </dd>
                    </dl>
                </fieldset>
            </form>
            <form name="memory" action="#" method="get">
                <fieldset>
                    <legend>Memória</legend>
                    <dl>
                        <dt><label for="memory_content">Conteúdo</label></dt>
                        <dd><textarea id="memory_content" name="memory_content"></textarea></dd>
                        <dt>Ações</dt>
                        <dd>
                            <button id="memory_import" type="button">Importar</button>
                            <button id="memory_export" type="button">Exportar</button>
                        </dd>
                    </dl>
                </fieldset>
            </form>
        </div>
        <form name="field">
            <fieldset>
                <legend>Campo</legend>
                <dl>
                    <dt>Ações</dt>
                    <dd>
                        <button type="button" id="config_run">Iniciar</button>
                        <button type="button" id="config_stop">Parar</button>
                        <button type="button" id="config_random">Randômico</button>
                    </dd>
                </dl>
                <div id="gameoflife">&nbsp;</div>
            </fieldset>
        </form>
        <h2>Padrões Básicos</h2>
        <p>
            Para aplicar os padrões básicos, você pode efetuar um duplo clique
            nos conteúdos abaixo e estes serão copiados para a área de memória.
            Após, basta selecionar a opção importar. Os padrões são pequenas
            estruturas consideradas vivas dentro do campo, que permanecem em
            laço de repetição até que encontrem outras formas de vida.
        </p>
        <dl>
            <dt>Glider</dt>
            <dd>
<pre>
[[0,1,0],[0,0,1],[1,1,1]]
</pre>
            </dd>
            <dt>Lightweight Spaceship (LWSS)</dt>
            <dd>
<pre>
[[0,0,0,0,0,0,0,0],[0,0,1,1,1,1,1,0],[0,1,0,0,0,0,1,0],[0,0,0,0,0,0,1,0],[0,1,0,0,0,1,0,0],[0,0,0,0,0,0,0,0]]
</pre>
            </dd>
            <dt>Glider Gun</dt>
            <dd>
<pre>
[[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0],
[0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0],
[0,1,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,1,1,0,0,0,0,0,0,0,0,1,0,0,0,1,0,1,1,0,0,0,0,1,0,1,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]]
</pre>
            </dd>
        </dl>
        <h3>Notas</h3>
        <p>
            Este aplicativo foi testado em ambientes Linux, nos navegadores
            Mozilla Firefox 11 e Google Chromium 17. Nenhum teste foi executado
            sobre o Microsoft Internet Explorer; nem queremos que seja testado
            nele ;)
        </p>
        <h3>Referências</h3>
        <ul>
            <li><a href="http://en.wikipedia.org/wiki/Conway%27s_Game_of_Life">Conway's Game of Life</a> na Wikipédia;</li>
            <li><a href="http://www.bitstorm.org/gameoflife/">John Conway's Game of Life</a> na Bitstorm;</li>
            <li><a href="http://www.youtube.com/watch?v=XcuBvj0pw-E">Amazing Game of Life Demo</a> no Youtube; e</li>
            <li><a href="http://rendell-attic.org/gol/tm.htm">A Turing Machine in Conway's Game of Life</a> por Paul Rendell.</li>
        </ul>
    </body>
</html>

