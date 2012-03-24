<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Game of Life - John Conway | Wanderson Camargo</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="gameoflife.js"></script>
        <link type="text/css" rel="stylesheet" href="gameoflife.css"/>
    </head>
    <body>
        <h1>John Conway's Game of Life</h1>
        <h2>por Wanderson Henrique Camargo Rosa</h2>
        <form name="config" action="#" method="get">
            <fieldset>
                <legend>Configurações</legend>
                <dl>
                    <dt><label for="config_columns">Número de Colunas</label></dt>
                    <dd><input id="config_columns" type="text" name="config_columns" class="integer" value="50"/></dd>
                    <dt><label for="config_rows">Número de Linhas</label></dt>
                    <dd><input id="config_rows" type="text" name="config_rows" class="integer" value="50"/></dd>
                    <dt>Ações</dt>
                    <dd><button type="submit">Gerar Mapa</button></dd>
                    <dd><button type="button" id="config_random">Randômico</button></dd>
                    <dd><button type="button" id="config_run">Iniciar</button></dd>
                    <dd><button type="button" id="config_stop">Parar</button></dd>
                </dl>
            </fieldset>
        </form>
        <div id="gameoflife">&nbsp;</div>
        <form name="memory" action="#" method="get">
            <fieldset>
                <legend>Memória</legend>
                <dl>
                    <dt><label for="memory_content">Conteúdo</label></dt>
                    <dd><textarea id="memory_content" name="memory_content"></textarea></dd>
                    <dt>Ações</dt>
                    <dd><button id="memory_import" type="button">Importar</button></dd>
                    <dd><button id="memory_export" type="button">Exportar</button></dd>
                </dl>
            </fieldset>
        </form>
    </body>
</html>

