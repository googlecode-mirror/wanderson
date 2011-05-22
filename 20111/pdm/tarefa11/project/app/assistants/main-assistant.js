function MainAssistant() {}
MainAssistant.prototype.setup = function() {
    /* Configurações de Tela */
    this.controller.setupWidget('clear', {}, {
        label : 'Clear'
    });
    /* Eventos */
    Mojo.Event.listen(this.controller.get('clear'),
        Mojo.Event.tap, this.handleButtonPress.bind(this)
    );
    /* Captura de Elementos */
    var field  = this.controller.get('field');
    var game   = new jstron.field(field);
    var player = new jstron.player();
    /* Cores */
    var white  = 255 << 16 | 255 << 8 | 255;
    var black  = 0;
    var red    = 255;
    var green  = 255 << 8;
    var blue   = 255 << 16;
    /* Configurações */
    game.setBgColor(white);
    game.setFgColor(black);
    player.setColor(red|green);
    game.setPlayerA(player);
    /* Inicialização do Jogo */
    window.game = game;
    window.onkeypress = function(event) {
        window.game.onKeyPress(event);
    }
    game.clear();
    game.play();
};
MainAssistant.prototype.handleButtonPress = function(event){
    var game   = window.game;
    var player = game.getPlayerA();
    game.stop();
    player.setX(0).setY(0)
        .setColor(255 << 8 | 255)
        .direction = 'right'; // yellow
    game.clear();
    game.play();
};
MainAssistant.prototype.activate = function(event) {};
MainAssistant.prototype.deactivate = function(event) {};
MainAssistant.prototype.cleanup = function(event) {};

/**
 * Javascript Tron
 * @author Wanderson Henrique Camargo Rosa
 */

/* Namespace */
var jstron = function() {};

// -----------------------------------------------------------------------------

/**
 * Classe Campo de Batalha
 * @author Wanderson Henrique Camargo Rosa
 */
jstron.field = function(canvas) {
    this.setCanvas(canvas);
};
/* Prototipação */
jstron.field.prototype = {
    /* Atributos */
    canvas    : undefined,
    blockSize : 10,
    bgColor   : 0,
    fgColor   : 0,
    movement  : undefined,
    playerA   : undefined,
    mapper    : undefined,
    /* Construtor */
    constructor : jstron.field,
    /* Configuração do Canvas */
    setCanvas : function(canvas) {
        this.canvas = canvas;
        return this;
    },
    /* Configuração da Largura */
    setWidth : function(width) {
        this.getCanvas().width = width;
        return this;
    },
    /* Configuração da Altura */
    setHeight : function(height) {
        this.getCanvas().height = height;
        return this;
    },
    /* Configuração do Tamanho do Bloco */
    setBlockSize : function(size) {
        this.blockSize = size;
        return this;
    },
    /* Configuração da Cor de Fundo */
    setBgColor : function(bgColor) {
        this.bgColor = bgColor;
        return this;
    },
    /* Configuração da Cor de Desenho */
    setFgColor : function(fgColor) {
        this.fgColor = fgColor;
        return this;
    },
    /* Configuração do Primeiro Jogador */
    setPlayerA : function(playerA) {
        playerA.setField(this);
        this.playerA = playerA;
        return this;
    },
    /* Informação do Canvas */
    getCanvas : function() {
        return this.canvas;
    },
    /* Informação da Largura */
    getWidth : function() {
        return this.getCanvas().width;
    },
    /* Informação da Altura */
    getHeight : function() {
        return this.getCanvas().height;
    },
    /* Informação do Tamanho do Bloco */
    getBlockSize : function() {
        return this.blockSize;
    },
    /* Informação da Cor de Fundo */
    getBgColor : function() {
        return this.bgColor;
    },
    /* Informação da Cor de Desenho */
    getFgColor : function() {
        return this.fgColor;
    },
    /* Informação do Primeiro Jogador */
    getPlayerA : function() {
        return this.playerA;
    },
    /* Desenha o Campo no Canvas */
    draw : function() {
        /* Captura de Elementos */
        var size    = this.getBlockSize();
        var width   = this.getWidth();
        var height  = this.getHeight();
        var bgcolor = this.getBgColor();
        var fgcolor = this.getFgColor();
        var canvas  = this.getCanvas();
        var playerA = this.getPlayerA();
        /* Desenho do Fundo */
        canvas.style.backgroundColor = this.transformColor(bgcolor);
        /* Desenho da Grade */
        var context = canvas.getContext('2d');
        context.lineWidth = 1;
        context.strokeStyle = this.transformColor(fgcolor);
        /* Linhas Horizontais */
        for (i = size; i < height; i = i + size) {
            context.beginPath();
            context.moveTo(0, i);
            context.lineTo(width, i);
            context.stroke();
        }
        /* Linhas Verticais */
        for (i = size; i < width; i = i + size) {
            context.beginPath();
            context.moveTo(i, 0);
            context.lineTo(i, height);
            context.stroke();
        }
        /* Jogadores */
        if (playerA) playerA.draw();
        return this;
    },
    /* Construção do Mapeamento */
    build : function() {
        /* Captura de Elementos */
        var size   = this.getBlockSize();
        var width  = this.getWidth();
        var height = this.getHeight();
        /* Quantidade de Posições */
        var x = width / size;
        var y = height / size;
        /* Construção do Mapeamento */
        var mapper = new Array(x);
        for (i = 0; i < x; i++) {
            mapper[i] = new Array(y);
            for (j = 0; j < y; j++) {
                /* Posicionamento X e Y */
                mapper[i][j] = false;
            }
        }
        this.mapper = mapper;
        return this;
    },
    /* Verifica Existência do Bloco */
    _isBlock : function(x, y) {
        var m = this.mapper;
        return typeof(m) != 'undefined' && 
            typeof(m[x]) != 'undefined' && typeof(m[x][y]) != 'undefined';
    },
    /* Preenche um Bloco no Campo */
    fill : function(x, y, color) {
        if (this._isBlock(x, y)) {
            /* Preenchido no Mapeamento */
            this.mapper[x][y] = true;
            /* Preenchimento de Cores */
            var size    = this.getBlockSize();
            var context = this.getCanvas().getContext('2d');
            context.fillStyle = this.transformColor(color);
            context.fillRect(x * size, y * size, size, size);
        }
        return this;
    },
    /* Verifica se o Bloco está Preenchido */
    isFilled : function(x, y) {
        return this._isBlock(x, y) && this.mapper[x][y] || !this._isBlock(x, y);
    },
    /* Transformação de Cores */
    transformColor : function(color) {
        var red   = color & 0xFF;
        var green = color >> 8 & 0xFF;
        var blue  = color >> 16 & 0xFF;
        return 'rgb('+red+','+green+','+blue+')';
    },
    /* Movimentação de Jogadores */
    move : function() {
        /* Jogador A */
        var playerA = this.getPlayerA();
        /* Testes */
        if (playerA) playerA.move();
        else alert('teste');
    },
    /* Início do Jogo */
    play : function() {
        this.stop();
        /* TODO Campo Temporário */
        window.jstron.field.temp = this;
        /* Movimentação de Personagens */
        this.movement = window.setInterval(function() {
            window.jstron.field.temp.move();
        }, 250);
    },
    /* Paraliza o Jogo */
    stop : function() {
        window.clearInterval(this.movement);
    },
    /* Movimentação de Jogadores */
    move : function() {
        /* Teste sobre Movimentos */
        var result = true;
        /* Captura de Jogadores */
        var playerA = this.getPlayerA();
        /* Execução do Movimento */
        if (playerA) {
            result = result && playerA.move();
            playerA.draw();
        }
        /* Análise do Resultado */
        if (!result) this.stop();
    },
    /* Limpa os Resultados */
    clear : function() {
        /* Captura de Elementos */
        var width  = this.getWidth();
        var height = this.getHeight();
        /* Limpeza da Tela */
        var context = this.getCanvas().getContext('2d');
        context.clearRect(0, 0, width, height);
        /* Reconstrução dos Valores */
        this.stop(); this.build().draw();
    },
    /* Estado do Deslocamento dos Jogadores */
    onKeyPress : function(event) {
        /* Captura de Jogadores */
        var playerA = this.getPlayerA();
        /* Execução do Movimento */
        if (playerA) playerA.onKeyPress(event);
    }
}

// -----------------------------------------------------------------------------

/**
 * Javascript Tron Jogador
 * @author Wanderson Henrique Camargo Rosa
 */
jstron.player = function() {}
/* Prototipação */
jstron.player.prototype = {
    /* Atributor */
    field     : undefined,
    x         : 0,
    y         : 0,
    direction : 'right',
    color     : 0,
    /* Construtor */
    constructor : jstron.player,
    /* Configuração do Campo de Batalha */
    setField : function(field) {
        this.field = field;
        return this;
    },
    /* Configuração da Posição Horizontal */
    setX : function(x) {
        this.x = x;
        return this;
    },
    /* Configuração da Posição Vertical */
    setY : function(y) {
        this.y = y;
        return this;
    },
    /* Configuração da Direção do Deslocamento */
    setDirection : function(direction) {
        var current = this.getDirection();
        var result =
            current == 'left' && direction != 'right' ||
            current == 'right' && direction != 'left' ||
            current == 'up' && direction != 'down' ||
            current == 'down' && direction != 'up';
        if (result) this.direction = direction;
        return this;
    },
    /* Configuração da Cor do Jogador */
    setColor : function(color) {
        this.color = color;
        return this;
    },
    /* Informação do Campo de Batalha */
    getField : function() {
        if (typeof(this.field) == 'undefined') {
            throw "I'm without a field!";
        }
        return this.field;
    },
    /* Informação da Posição Horizontal */
    getX : function() {
        return this.x;
    },
    /* Informação da Posição Vertical */
    getY : function() {
        return this.y;
    },
    /* Informação da Direção do Deslocamento */
    getDirection : function() {
        return this.direction;
    },
    /* Informação da Cor do Jogador */
    getColor : function() {
        return this.color;
    },
    /* Informação da Cor Inversa do Jogador */
    getColorInverse : function() {
        /* Captura de Cor */
        var color = this.getColor();
        /* Inversão de Cores */
        return color ^ 16777215;
    },
    /* Tratamento de Teclado para Sobrescrita */
    onKeyPress : function(event) {
        switch (event.keyCode) {
            case 97: /* Left */
                this.setDirection('left');
                break;
            case 119: /* Up */
                this.setDirection('up');
                break;
            case 100: /* Right */
                this.setDirection('right');
                break;
            case 115: /* Down */
                this.setDirection('down');
                break;
        }
    },
    /* Movimentação */
    move : function() {
        /* Captura de Elementos */
        var x = this.getX();
        var y = this.getY();
        var field     = this.getField();
        var direction = this.getDirection();
        /* Direções para Deslocamento */
        var hor = 0; var ver = 0;
        /* Processamento do Deslocamento */
        switch (direction) {
            case 'right':
                hor = 1;
                break;
            case 'left':
                hor = -1;
                break;
            case 'up':
                ver = -1;
                break;
            case 'down':
                ver = 1;
                break;
        }
        /* Verificação do Deslocamento */
        var result = !field.isFilled(x + hor, y + ver);
        if (result) {
            /* Efetua o Movimento */
            this.setX(x + hor).setY(y + ver);
        } else {
            /* Não Executa Movimento */
            this.setColor(this.getColorInverse());
        }
        return result;
    },
    /* Renderização do Jogador */
    draw : function() {
        /* Captura de Elementos */
        var x = this.getX();
        var y = this.getY();
        var color = this.getColor();
        /* Preenchimento da Posição */
        this.getField().fill(x, y, color);
        return this;
    }
};