/**
 * Protótipo Jogador
 * @param color Cor do Jogador
 */
var player = function(color)
{
    /**
     * Referência para o Jogo
     */
    this.game;

    /**
     * Cor do Jogador
     */
    this.color;

    /**
     * Posição no Campo do Jogo na Hozizontal
     */
    this.x;

    /**
     * Posição no Campo do Jogo na Vertical
     */
    this.y;

    /**
     * Verificação de Objeto Quebrado
     * Impossível Continuar Movimentação
     */
    this.broken;

    /**
     * Verificação de Objeto Movimentado
     * Utilizado para Evitar Deslocamento em Blocos Não Sequenciais
     */
    this.moved;

    /**
     * Direção do Movimento Atual
     * Possíveis Valores: stop,left,right,up,down
     */
    this.direction;

    /**
     * Encapsulamento
     * Configuração da Referência ao Jogo
     */
    this.setGame = function(game) {
        var x = this.getPositionX();
        var y = this.getPositionY();
        game.fill(x,y);
        this.game = game;
        return this;
    };

    /**
     * Encapsulamento
     * Informação na Referência ao Jogo
     */
    this.getGame = function() {
        return this.game;
    };

    /**
     * Encapsulamento
     * Configuração da Cor do Jogador
     */
    this.setColor = function(color) {
        this.color = color;
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Cor do Jogador
     */
    this.getColor = function() {
        return this.color;
    };

    /**
     * Encapsulamento
     * Configuração da Verificação de Objeto Quebrado
     */
    this.setBroken = function(broken) {
        this.broken = broken;
        /* Auxilio Visual - Deve Sofrer Modificações */
        if (broken) this.setColor('#000');
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Verficiação de Objeto Quebrado
     */
    this.getBroken = function() {
        return this.broken;
    };

    /**
     * Encapsulamento
     * Configuração da Verificação de Objeto Movimentado
     */
    this.setMoved = function(moved) {
        this.moved = moved;
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Verificação de Objeto Movimentado
     */
    this.getMoved = function() {
        return this.moved;
    };

    /**
     * Encapsulamento
     * Configuração da Direção Atual de Movimento
     * Possíveis Valores: stop,left,right,up,down
     */
    this.setDirection = function(direction) {
        var current = this.getDirection();
        switch (direction) {
        case 'stop':
        case 'left':
        case 'up':
        case 'right':
        case 'down':
            var confirm = 
                current == 'right' && direction != 'left'  ||
                current == 'left'  && direction != 'right' ||
                current == 'up'    && direction != 'down'  ||
                current == 'down'  && direction != 'up'    ||
                current == 'stop'  || current == undefined;
            if (confirm) this.direction = direction;
            break;
        default:
            this.direction = 'stop';
        }
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Direção Atual de Movimento
     */
    this.getDirection = function() {
        return this.direction;
    };

    /**
     * Movimenta o Jogador
     * Desloca o Objeto de Acordo com a Direção Atual
     */
    this.move = function() {
        var direction = this.getDirection();
        if (!this.getBroken()) {
            switch (direction) {
            case 'left':
                this.left();
                break;
            case 'right':
                this.right();
                break;
            case 'up':
                this.up();
                break;
            case 'down':
                this.down();
                break;
            }
        }
        return this;
    };

    /**
     * Encapsulamento
     * Configuração da Posição Atual na Horizontal
     * Número do Bloco de Acordo com Mapeamento do Jogo
     */
    this.setPositionX = function(x) {
        var game = this.getGame();
        if (game) {
            this.x = x;
        } else {
            this.x = 0;
        }
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Posição Atual na Horizontal
     */
    this.getPositionX = function() {
        return this.x;
    };

    /**
     * Encapsulamento
     * Configuração da Posição Atual na Vertical
     * Número do Bloco de Acordo com Mapeamento do Jogo
     */
    this.setPositionY = function(y) {
        var game = this.getGame();
        if (game) {
            this.y = y;
        } else {
            this.y = 0;
        }
        return this;
    };

    /**
     * Encapsulamento
     * Informação da Posição Atual na Vertical
     */
    this.getPositionY = function() {
        return this.y;
    };

    /**
     * Deslocamento Quantitativo Horizontal
     * Método Utilizado como Protegido pelo Protótipo
     */
    this.horizontal = function(size) {
        if (!this.getMoved()) {
            var x = this.getPositionX();
            this.setPositionX(x + size);
            if (this.isBlocked()) {
                this.setBroken(true);
                this.getGame().stop();
                x = this.getPositionX();
                this.setPositionX(x - size);
            } else {
                this.fill();
                this.setMoved(true);
            }
        }
        return this;
    };

    /**
     * Deslocamento Quantitativo Vertical
     * Método Utilizado como Protegido pelo Protótipo
     */
    this.vertical = function(size) {
        if (!this.getMoved()) {
            var y = this.getPositionY();
            this.setPositionY(y + size);
            if (this.isBlocked()) {
                this.setBroken(true);
                this.getGame().stop();
                y = this.getPositionY();
                this.setPositionY(y - size);
            } else {
                this.fill();
                this.setMoved(true);
            }
        }
        return this;
    };

    /**
     * Preenchimento do Bloco Atual
     * Busca a Referência do Jogo, Informando Posição Já Utilizada
     */
    this.fill = function() {
        var x = this.getPositionX();
        var y = this.getPositionY();
        var g = this.getGame();
        if (g) g.fill(x,y);
        return this;
    };

    /**
     * Deslocamento Sequencial Horizontal
     * Movimentação de Bloco Único para Direita
     */
    this.right = function() {
        this.horizontal(1);
        return this;
    };

    /**
     * Deslocamento Sequencial Horizontal
     * Movimentação de Bloco Único para Esquerda
     */
    this.left = function() {
        this.horizontal(-1);
        return this;
    };

    /**
     * Deslocamento Sequencial Vertical
     * Movimentação de Bloco Único para Cima
     */
    this.up = function() {
        this.vertical(-1);
        return this;
    };

    /**
     * Deslocamento Sequencial Vertical
     * Movimentação de Bloco Único para Baixo
     */
    this.down = function() {
        this.vertical(1);
        return this;
    };

    /**
     * Verifica se o Bloco Atual Já Foi Utilizado
     * Acessa Referência ao Jogo, Buscando Informações de Mapeamento
     */
    this.isBlocked = function() {
        var confirm = true;
        var game = this.getGame();
        if (game) {
            var x = this.getPositionX();
            var y = this.getPositionY();
            confirm = game.isFilled(x,y);
        }
        return confirm;
    };

    /**
     * Renderização do Objeto
     * Desenha o Jogador no Campo de Jogo
     */
    this.render = function() {
        var game = this.getGame();
        if (game) {
            var step = game.getStep();
            var x = this.getPositionX() * step;
            var y = this.getPositionY() * step;
            var context = game.getField().getContext('2d');
            context.fillStyle = this.getColor();
            context.fillRect(x,y,step,step);
            this.setMoved(false);
        }
        return this;
    };

    /* Construção */
    this.setGame(game).setColor(color)
        .setPositionX(0).setPositionY(0)
        .setMoved(false).setDirection('stop');
};

/**
 * Protótipo Jogo
 * @param field Campo de Jogo do Tipo Canvas
 */
var jstron = function(field)
{
    /**
     * Campo de Jogo do Tipo Canvas
     */
    this.field;

    /**
     * Cor da Grade
     */
    this.gridColor;

    /**
     * Quantidade de Pixels para Passo Único
     */
    this.step;

    /**
     * Referência ao Jogador
     */
    this.player1;

    /**
     * Referência ao Jogador
     */
    this.player2;

    /**
     * Mapa para Controle de Blocos
     * Posicionamentos de Jogadores
     */
    this.map;

    /**
     * Encapsulamento
     * Configura o Campo de Jogo
     */
    this.setField = function(field) {
        this.field = field;
        return this;
    };

    /**
     * Encapsulamento
     * Informa o Campo de Jogo
     */
    this.getField = function() {
        return this.field;
    };

    /**
     * Encapsulamento
     * Configura o Tamanho Horizontal do Campo de Jogo
     */
    this.setWidth = function(width) {
        this.field.width = width;
        return this;
    };

    /**
     * Encapsulamento
     * Informa o Tamanho Horizontal do Campo de Jogo
     */
    this.getWidth = function() {
        return this.field.width;
    };

    /**
     * Encapsulamento
     * Configura o Tamanho Vertical do Campo de Jogo
     */
    this.setHeight = function(height) {
        this.field.height = height;
        return this;
    };

    /**
     * Encapsulamento
     * Informa o Tamanho Vertical do Campo de Jogo
     */
    this.getHeight = function() {
        return this.field.height;
    };

    /**
     * Encapsulamento
     * Configura a Quantidade de Pixels para Deslocamento Único
     */
    this.setStep = function(step) {
        this.step = step;
        return this;
    };

    /**
     * Encapsulamento
     * Informa a Quantidade de Pixels para Deslocamento Único
     */
    this.getStep = function() {
        return this.step;
    };

    /**
     * Encapsulamento
     * Configura a Cor da Grade de Orientação
     */
    this.setGridColor = function(color) {
        this.gridColor = color;
        return this;
    };

    /**
     * Encapsulamento
     * Informa a Cor da Grade de Orientação
     */
    this.getGridColor = function() {
        return this.gridColor;
    };

    /**
     * Encapsulamento
     * Configura a Referência ao Objeto Jogador
     */
    this.setPlayer1 = function(player) {
        player.setGame(this);
        this.player1 = player;
        return this;
    };

    /**
     * Encapsulamento
     * Informa a Referência ao Objeto Jogador
     */
    this.getPlayer1 = function() {
        return this.player1;
    };

    /**
     * Encapsulamento
     * Configura a Referência ao Objeto Jogador
     */
    this.setPlayer2 = function(player) {
        player.setGame(this);
        this.player2 = player;
        return this;
    };

    /**
     * Encapsulamento
     * Informa a Referência ao Objeto Jogador
     */
    this.getPlayer2 = function() {
        return this.player2;
    };

    /**
     * Renderização
     * Desenha a Grade de Orientação no Campo de Jogo
     */
    this.renderGrid = function() {
        /* Tamanho do Campo */
        var width  = this.getWidth();
        var height = this.getHeight();
        var step   = this.getStep();
        /* Desenho */
        var context = this.field.getContext('2d');
        context.lineWidth = 1;
        context.strokeStyle = this.getGridColor();
        for (i = 0; i < width; i = i + step) {
            context.beginPath();
            context.moveTo(i, 0);
            context.lineTo(i, height);
            context.stroke();
        }
        for (i = 0; i < height; i = i + step) {
            context.beginPath();
            context.moveTo(0, i);
            context.lineTo(width, i);
            context.stroke();
        }
        return this;
    };

    /**
     * Renderização Completa
     * Desenha o Objeto Jogador no Campo de Jogo
     */
    this.render = function() {
        p1 = this.getPlayer1(); if (p1) p1.render();
        p2 = this.getPlayer2(); if (p2) p2.render();
    };

    /**
     * Construção do Mapeamento do Jogo
     * Cria a Estrutura para Controle de Blocos Já Preenchidos
     */
    this.buildMap = function() {
        var step   = this.getStep();
        var width  = this.getWidth();
        var height = this.getHeight();
        var x = width / step;
        var y = height / step;
        this.map = new Array(x);
        for (i = 0; i < x; i++) {
            this.map[i] = new Array(y);
            for (j = 0; j < y; j++) {
                this.map[i][j] = false;
            }
        }
        return this;
    };

    /**
     * Preenche um Bloco no Mapeamento
     */
    this.fill = function(x,y) {
        if (typeof(this.map[x]) != 'undefined' &&
            typeof(this.map[x][y]) != 'undefined') {
            this.map[x][y] = true;
        }
        return this;
    };

    /**
     * Verifica se um Bloco Já Foi Utilizado no Mapeamento
     */
    this.isFilled = function(x,y) {
        /* Sempre Preenchido Inclusive Fora do Intervalo */
        var confirm = true;
        if (typeof(this.map[x]) != 'undefined' &&
            typeof(this.map[x][y]) != 'undefined') {
            confirm = this.map[x][y];
        }
        return confirm;
    };

    /**
     * Execução Principal do Jogo
     * Inicialização do Contador para Movimentação do Jogador
     * Captura de Teclas para Troca de Direcionamentos do Jogador
     */
    this.play = function() {
        window.onkeypress = function(event){
            game.onKeyBoardEvent(event);
        };
        this.interval = window.setInterval(function(){
            game.onInterval();
        }, 50);
        return this;
    };

    /**
     * Termina a Execução Principal do Jogo
     * Finaliza o Contador para Movimentação do Jogador
     * Limpa a Captura de Teclas para Direcionamento do Jogador
     */
    this.stop = function() {
        window.onkeypress = function(){};
        window.clearInterval(this.interval);
        window.setTimeout(function(){
            game.render();
        }, 50);
    };

    /**
     * Tratamento de Teclas
     * Modifica a Direção do Jogador no Ambiente
     */
    this.onKeyBoardEvent = function(event) {
        var confirm = false;
        /* Primeiro Jogador */
        var player1 = this.getPlayer1();
        switch (event.keyCode) {
        case 37: /* Left */
            player1.setDirection('left');
            confirm = true;
            break;
        case 38: /* Up */
            player1.setDirection('up');
            confirm = true;
            break;
        case 39: /* Right */
            player1.setDirection('right');
            confirm = true;
            break;
        case 40: /* Down */
            player1.setDirection('down');
            confirm = true;
            break;
        }
        /* Segundo Jogador */
        var player2 = this.getPlayer2();
        switch (event.charCode) {
        case 97: /* A: Left */
            player2.setDirection('left');
            confirm = true;
            break;
        case 119: /* W: Up */
            player2.setDirection('up');
            confirm = true;
            break;
        case 100: /* D: Right */
            player2.setDirection('right');
            confirm = true;
            break;
        case 115: /* S: Down */
            player2.setDirection('down');
            confirm = true;
            break;
        }
        if (confirm) {
            /* Previne Execução Padrão da Tecla Pressionada */
            event.preventDefault();
        }
        console.debug(event);
        return true;
    };

    /**
     * Execução Sequencial
     * Movimenta o Jogador no Campo de Jogo
     */
    this.onInterval = function() {
        /* Variável Externa - Deve ser Modificado */
        this.render();
        p1 = game.getPlayer1(); if (p1) p1.move();
        p2 = game.getPlayer2(); if (p2) p2.move();
    };

    /* Construtor */
    this.setField(field)
        .setWidth(800).setHeight(450).setStep(10)
        .setGridColor('#efefef')
        .renderGrid().buildMap();
};
