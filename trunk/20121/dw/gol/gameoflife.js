$(function(){
    // Game of Life
    window.gameoflife = {
        // Mapeamento
        'mapper' : undefined,
        // Intervalo
        'interval' : undefined,
        // Construtor
        'build' : function(element,w,h){
            // Captura de Campo
            var container = $(element);
            // Limpeza de Filhos
            container.empty();
            // Criação de Campo
            var field = $('<tbody>');
            // Mapeamento em Memória
            this.mapper = new Array(h);
            // Construção de Campo
            for (var i = 0; i < h; i++) {
                // Construção de Linhas
                var row = $('<tr>');
                // Mapeamento em Memória
                this.mapper[i] = new Array(w);
                // Iteração
                for (var j = 0; j < w; j++) {
                    // Construção de Colunas
                    var column = $('<td>');
                    // Marcação de Mapa
                    column.attr('c', j).attr('r', i);
                    // Aplicação de Colunas
                    row.append(column);
                    // Mapeamento em Memória
                    this.mapper[i][j] = {
                        'alive'   : 0,
                        'element' : column,
                        'change'  : function(change){
                            // Modificação Fixa?
                            if (typeof(change) != 'undefined') {
                                if (this.alive != change) {
                                    this.change();
                                }
                                // Encadeamento
                                return this;
                            }
                            // Vivo?
                            if (this.alive == 1) {
                                // Remover Classe
                                this.element.removeClass('alive');
                                // Morto!
                                this.alive = 0;
                            } else {
                                // Adicionar Classe
                                this.element.addClass('alive');
                                // Vivo!
                                this.alive = 1;
                            }
                            // Encadeamento
                            return this;
                        }
                    };
                }
                // Aplicação de Linhas
                field.append(row);
            }
            // Aplicação de Campo
            container.append($('<table>').append(field));
            // Callbacks
            $('td', container).bind('click', function(event){
                var element = $(this);
                var c = element.attr('c');
                var r = element.attr('r');
                var mapped = gameoflife.mapper[r][c].change();
            });
            // Encadeamento
            return this;
        },
        // Execução
        'step' : function() {
            // Processar Campos
            var r = this.mapper.length;
            var c = this.mapper[0].length;
            // Contabilização de Vizinhos
            var counter = new Array(r);
            for (var i = 0; i < r; i++) {
                counter[i] = new Array(c);
                for (var j = 0; j < c; j++) {
                    counter[i][j] = 0;
                }
            }
            // Verificador
            var plus = function(i,j){
                try {
                    counter[i][j] += 1;
                } catch(e) {}
            }
            // Tradução de Mapa Atual
            for (var i = 0; i < r; i++) {
                for (var j = 0; j < c; j++) {
                    // Elemento Atual
                    var mapped = this.mapper[i][j];
                    // Vivo?
                    if (mapped.alive) {
                        // Mapeamento
                        plus(i-1,j-1); // Noroeste
                        plus(i-1,j);   // Norte
                        plus(i-1,j+1); // Nordeste
                        plus(i,j-1);   // Oeste
                        plus(i,j+1);   // Leste
                        plus(i+1,j-1); // Sudoeste
                        plus(i+1,j);   // Sul
                        plus(i+1,j+1); // Sudeste
                    }
                }
            }
            // Aplicar Modificações
            for (var i = 0; i < r; i++) {
                for (var j = 0; j < c; j++) {
                    // Elemento Atual
                    var mapped = this.mapper[i][j];
                    // Vivo?
                    if (mapped.alive) {
                        // Verificar Vizinhos
                        if (counter[i][j] <= 1 || counter[i][j] >= 4) {
                            // Morre de Solidão ou Superpopulação
                            mapped.change();
                        }
                    } else {
                        // Verificar Vizinhos
                        if (counter[i][j] == 3) {
                            // Torna-se Viva
                            mapped.change();
                        }
                    }
                }
            }
        },
        // Randômico
        'random' : function() {
            var r = this.mapper.length;
            var c = this.mapper[0].length;
            for (var i = 0; i < r; i++) {
                for (var j = 0; j < c; j++) {
                    if (Math.random() < 0.4) {
                        this.mapper[i][j].change();
                    }
                }
            }
        },
        // Execução
        'run' : function() {
            // Captura
            var self = this;
            // Intervalo
            this.interval = setInterval(function(){
                self.step();
            }, 100);
            // Encadeamento
            return this;
        },
        // Parada
        'stop' : function() {
            // Intervalo
            clearInterval(this.interval);
            this.interval = undefined;
            // Encadeamento
            return this;
        },
        // Exportação
        'export' : function() {
            // Mapeamento de Elementos Vivos
            var r = this.mapper.length;
            var c = this.mapper[0].length;
            var mapper = new Array(r);
            for (var i = 0; i < r; i++) {
                mapper[i] = new Array(c);
                for (var j = 0; j < c; j++) {
                    mapper[i][j] = this.mapper[i][j].alive;
                }
            }
            // Converter Mapeamento
            return JSON.stringify(mapper);
        },
        // Importação
        'import' : function(content) {
            // Tamanho de Colunas
            var r = this.mapper.length;
            var c = this.mapper[0].length;
            try {
                mapper = JSON.parse(content);
                for (var i = 0; i < r; i++) {
                    for (var j = 0; j < c; j++) {
                        if (mapper[i][j] == 0) {
                            this.mapper[i][j].change(0);
                        } else {
                            this.mapper[i][j].change(1);
                        }
                    }
                }
            } catch (e) {
                alert('Conteúdo Inválido');
            }
        }
    };
    // Callbacks
    $('.integer:input').bind('keydown', function(event){
        return [8,9,37,38,39,40,46,48,49,50,51,52,53,54,55,56,57].indexOf(event.keyCode) >= 0;
    });
    $('#config_run').click(function(){
        gameoflife.run();
        return false;
    });
    $('#config_stop').click(function(){
        gameoflife.stop();
        return false;
    });
    $('#config_random').click(function(){
        gameoflife.random();
        return false;
    });
    $('#memory_import').click(function(){
        var content = $('#memory_content').val();
        gameoflife.import(content);
        return false;
    });
    $('#memory_export').click(function(){
        var content = gameoflife.export();
        $('#memory_content').val(content);
        return false;
    });
    // Construtor
    $('form[name="config"]').bind('submit', function(event){
        // Capturas
        var columns   = $('#config_columns').val();
        var rows      = $('#config_rows').val();
        var container = $('#gameoflife');
        // Conversões
        columns = parseInt(columns);
        rows    = parseInt(rows);
        // Aplicação
        gameoflife.build(container, columns, rows);
        // Negação de Evento
        return false;
    }).trigger('submit');
});
