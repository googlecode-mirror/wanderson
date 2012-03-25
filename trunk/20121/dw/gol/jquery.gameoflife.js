(function($){

// Iterador --------------------------------------------------------------------
    var iterator = function(mapper, callback){
        // Tamanhos
        var height = mapper.length;
        var width  = mapper[0].length;
        // Iteração
        for (var i = 0; i < height; i++) {
            for (var j = 0; j < width; j++) {
                // Chamada
                callback.call(mapper[i][j], i, j);
            }
        }
        // Encadeamento
        return this;
    };

// Jogo ------------------------------------------------------------------------
    var gameoflife = function(mapper, timestamp){
        // Atributos
        var interval = undefined;
        // Tamanhos
        var height = mapper.length;
        var width  = mapper[0].length;
        // Passo
        this.step = function(){
            // Contabilização de Vizinhos
            var counter = new Array(height);
            for (var i = 0; i < height; i++) {
                counter[i] = new Array(width);
                for (var j = 0; j < width; j++) {
                    counter[i][j] = 0;
                }
            }
            // Somador
            var plus = function(i,j){
                try {
                    counter[i][j] += 1;
                } catch (e) {}
            };
            // Iteração com Mapeamento
            iterator(mapper, function(i, j){
                // Vivo?
                if (this.alive) {
                    // Somador
                    plus(i-1,j-1); // Noroeste
                    plus(i-1,j);   // Norte
                    plus(i-1,j+1); // Nordeste
                    plus(i,j-1);   // Oeste
                    plus(i,j+1);   // Leste
                    plus(i+1,j-1); // Sudoeste
                    plus(i+1,j);   // Sul
                    plus(i+1,j+1); // Sudeste
                }
            });
            // Iteração com Mapeamento
            iterator(mapper, function(i, j){
                // Estado Atual
                if (this.alive == 1) {
                    if (counter[i][j] <= 1 || counter[i][j] >= 4) {
                        this.change();
                    }
                } else {
                    if (counter[i][j] == 3) {
                        this.change();
                    }
                }
            });
            // Encadeamento
            return this;
        };
        // Randômico
        this.random = function(){
            iterator(mapper, function(){
                if (Math.random() < 0.4) {
                    this.change();
                }
            });
        };
        // Execução
        this.run = function(){
            // Em Execução?
            if (interval != undefined) {
                // Encadeamento
                return this;
            }
            // Captura
            var self = this;
            // Intervalo
            interval = setInterval(function(){
                self.step();
            }, timestamp);
            // Encadeamento
            return this;
        };
        // Parada
        this.stop = function(){
            // Intervalo
            clearInterval(interval);
            interval = undefined;
            // Encadeamento
            return this;
        };
        // Exportação
        this.export = function(){
            // Saída
            var output = new Array(height);
            // Mapeamento
            for (var i = 0; i < height; i++) {
                output[i] = new Array(width);
                for (var j = 0; j < width; j++) {
                    output[i][j] = mapper[i][j].alive;
                }
            }
            // Converter Mapeamento
            return JSON.stringify(output);
        };
        // Importação
        this.import = function(params){
            try {
                input = JSON.parse(params.content);
                iterator(mapper, function(i, j){
                    if (input[i][j] == 0) {
                        this.change(0);
                    } else {
                        this.change(1);
                    }
                });
            } catch (e) {
                console.warn(e);
            }
            // Encadeamento
            return this;
        };
    };

// Célula ----------------------------------------------------------------------
    var cell = function(element){
        // Posição Viva?
        this.alive = 0;
        // Elemento Utilizado
        element = $(element);
        // Atribuição
        this.element = element;
        // Marcação de Célula
        var self = this;
        element.each(function(){
            this.cell = self;
        });
        // Modificar Estado
        this.change = function(alive){
            // Estado Fixo Apresentado?
            if (alive != undefined) {
                // Estado Diferente?
                if (this.alive != alive) {
                    // Modificar Estado
                    this.change();
                }
                // Encadeamento
                return this;
            }
            // Qual Estado?
            if (this.alive == 1) {
                // Vivo? Remover Classe!
                this.element.removeClass('alive');
                // Morto!
                this.alive = 0;
            } else {
                // Morto? Adicionar Classe!
                this.element.addClass('alive');
                // Vivo!
                this.alive = 1;
            }
            // Encadeamento
            return this;
        };
    };

// Inicialização ---------------------------------------------------------------
    $.fn.gameoflife = function(config, params){
        // Chamada de Método?
        if (typeof(config) == 'string') {
            var output = null;
            this.each(function(){
                // Executar Método no Elemento
                output = this['gameoflife'][config](params);
            });
            // Encadeamento
            return output;
        }
        // Configurações
        config = $.extend({
            'timestamp' : 1000,
            'width'     : 50,
            'height'    : 50
        }, config);
        // Processamento
        this.each(function(){
            // Verificar Jogo Existente
            if (typeof(this.gameoflife) == 'function') {
                // Parar Execução!
                this.gameoflife.stop();
            }
            // Construção
            var container = $(this);
            // Limpeza de Filhos
            container.empty();
            // Inicializar Campo
            var field = $('<tbody>');
            // Mapeamento de Memória
            var mapper = new Array(config.height);
            // Construção do Campo
            for (var i = 0; i < config.height; i++) {
                // Construção de Linhas
                var row = $('<tr>');
                // Mapeamento de Memória
                mapper[i] = new Array(config.width);
                // Iterador
                for (var j = 0; j < config.width; j++) {
                    // Construção de Colunas
                    var column = $('<td>');
                    // Marcação em Mapeamento
                    mapper[i][j] = new cell(column);
                    // Aplicação de Coluna
                    row.append(column);
                }
                // Aplicação de Linhas
                field.append(row);
            }
            // Aplicação de Campo
            container.append(field);
            // Callbacks
            $('td', container).bind('click', function(event){
                this.cell.change();
                return false;
            });
            // Aplicar Conteúdo
            this.gameoflife = new gameoflife(mapper, config.timestamp);
        });
        // Encadeamento
        return this;
    };
})(jQuery);

