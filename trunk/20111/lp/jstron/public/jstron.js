/* Prototype */
var player = function(color) {
    /* Attributes */
    this.game;
    this.color;
    this.x;
    this.y;
    this.broken;
    /* Methods */
    this.setGame = function(game) {
        this.game = game;
        return this;
    };
    this.getGame = function() {
        return this.game;
    };
    this.setColor = function(color) {
        this.color = color;
        return this;
    };
    this.getColor = function() {
        return this.color;
    };
    this.setBroken = function(broken) {
        this.broken = broken;
        if (broken) this.setColor('#000'); /* Auxilio Visual */
        return this;
    };
    this.getBroken = function() {
        return this.broken;
    };
    this.setPositionX = function(x) {
        var game = this.getGame();
        if (game) {
            var width = game.getWidth();
            var step  = game.getStep();
            if (x * step >= 0 && x * step <= width - step) {
                this.x = x;
            } else {
                this.setBroken(true);
            }
        } else {
            this.x = 0;
        }
        return this;
    };
    this.getPositionX = function() {
        return this.x;
    };
    this.setPositionY = function(y) {
        var game = this.getGame();
        if (game) {
            var height = game.getHeight();
            var step   = game.getStep();
            if (y * step >= 0 && y * step <= height - step) {
                this.y = y;
            } else {
                this.setBroken(true);
            }
        } else {
            this.y = 0;
        }
        return this;
    };
    this.getPositionY = function() {
        return this.y;
    };
    this.horizontal = function(size) {
        var x = this.getPositionX();
        this.setPositionX(x + size);
        if (this.isBlocked()) {
            this.setBroken(true);
            x = this.getPositionX();
            this.setPositionX(x - size);
        } else {
            this.fill();
        }
        return this;
    };
    this.vertical = function(size) {
        var y = this.getPositionY();
        this.setPositionY(y + size);
        if (this.isBlocked()) {
            this.setBroken(true);
            y = this.getPositionY();
            this.setPositionY(y - size);
        } else {
            this.fill();
        }
        return this;
    };
    this.fill = function() {
        var x = this.getPositionX();
        var y = this.getPositionY();
        var g = this.getGame();
        if (g) g.fill(x,y);
        return this;
    };
    this.right = function() {
        this.horizontal(1);
        return this;
    };
    this.left = function() {
        this.horizontal(-1);
        return this;
    };
    this.up = function() {
        this.vertical(-1);
        return this;
    };
    this.down = function() {
        this.vertical(1);
        return this;
    };
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
    this.render = function() {
        var game = this.getGame();
        if (game) {
            var step = game.getStep();
            var x = this.getPositionX() * step;
            var y = this.getPositionY() * step;
            var context = game.getField().getContext('2d');
            context.fillStyle = this.getColor();
            context.fillRect(x,y,step,step);
        }
        return this;
    };
    /* Constructor */
    this.setGame(game).setColor(color)
        .setPositionX(0).setPositionY(0);
};
/* Prototype */
var jstron = function(field) {
    /* Attributes */
    this.field;
    this.gridColor;
    this.step;
    this.player;
    this.map;
    /* Methods */
    this.setField = function(field) {
        this.field = field;
        return this;
    };
    this.getField = function() {
        return this.field;
    };
    this.setWidth = function(width) {
        this.field.width = width;
        return this;
    };
    this.getWidth = function() {
        return this.field.width;
    };
    this.setHeight = function(height) {
        this.field.height = height;
        return this;
    };
    this.getHeight = function() {
        return this.field.height;
    };
    this.setStep = function(step) {
        this.step = step;
        return this;
    };
    this.getStep = function() {
        return this.step;
    };
    this.setGridColor = function(color) {
        this.gridColor = color;
        return this;
    };
    this.getGridColor = function() {
        return this.gridColor;
    };
    this.setPlayer = function(player) {
        player.setGame(this);
        this.player = player;
        return this;
    };
    this.getPlayer = function() {
        return this.player;
    };
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
    this.render = function() {
        this.getPlayer().render();
    };
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
    this.fill = function(x,y) {
        if (typeof(this.map[x][y]) != 'undefined') {
            this.map[x][y] = true;
        }
        return this;
    };
    this.isFilled = function(x,y) {
        var confirm = false;
        if (typeof(this.map[x][y]) != 'undefined') {
            confirm = this.map[x][y];
        }
        return confirm;
    };
    this.play = function() {
        this.render();
        console.debug(this);
        return this;
    };
    this.onKeyBoardEvent = function(event) {
        var confirm = false;
        var player  = game.getPlayer(); /* Variável Externa */
        switch (event.keyCode) {
        case 37: /* Left */
            player.left();
            confirm = true;
            break;
        case 38: /* Up */
            player.up();
            confirm = true;
            break;
        case 39: /* Right */
            player.right();
            confirm = true;
            break;
        case 40: /* Down */
            player.down();
            confirm = true;
            break;
        }
        if (confirm) {
            player.render();
            event.preventDefault();
        }
        return true;
    };
    /* Constructor */
    this.setField(field)
        .setWidth(800).setHeight(450).setStep(10)
        .setGridColor('#efefef')
        .renderGrid().buildMap();
    window.onkeypress = this.onKeyBoardEvent;
};