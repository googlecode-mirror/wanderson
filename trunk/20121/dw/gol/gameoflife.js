$(function(){
    // Captura do Jogo
    var gol = $('#gameoflife');
    // Caixas com Inteiros
    $('.integer:input').bind('keydown', function(event){
        return [8,9,37,38,39,40,46,48,49,50,51,52,53,54,55,56,57,58].indexOf(event.keyCode) >= 0;
    });
    // Gerador de Mapas
    $('form[name="config"]').bind('submit', function(event){
        // Capturar Informações
        var height    = $('#config_rows').val();
        var width     = $('#config_columns').val();
        var timestamp = $('#config_interval').val();
        // Conversões
        height    = parseInt(height);
        width     = parseInt(width);
        timestamp = parseInt(timestamp);
        // Inicializar Jogo da Vida
        gol.gameoflife({
            'height'    : height,
            'width'     : width,
            'timestamp' : timestamp
        });
        // Cancelar Evento
        return false;
    });
    // Inicializar Jogo
    $('#config_run').bind('click', function(event){
        // Inicializar Jogo
        gol.gameoflife('run');
        // Cancelar Evento
        return false;
    });
    // Finalizar Jogo
    $('#config_stop').bind('click', function(event){
        // Finalizar Jogo
        gol.gameoflife('stop');
        // Cancelar Evento
        return false;
    });
    // Randomizar Campo
    $('#config_random').bind('click', function(event){
        // Randomizar
        gol.gameoflife('random');
        // Cancelar Evento
        return false;
    });
    // Memória
    $('#memory_import').bind('click', function(event){
        // Capturar Conteúdo
        var content = $('#memory_content').val();
        // Importar Conteúdo
        gol.gameoflife('import', {
            'content' : content
        });
        // Cancelar Evento
        return false;
    });
    $('#memory_export').bind('click', function(event){
        // Exportar Conteúdo
        var content = gol.gameoflife('export');
        // Aplicar Conteúdo
        $('#memory_content').val(content);
        // Cancelar Evento
        return this;
    });
});

