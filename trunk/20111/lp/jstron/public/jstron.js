/* Prototype */
var player = function(color) {
    /* Attributes */
    this.game;
    this.color;
    this.x;
    this.y;
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
    this.setPositionX = function(x) {
        var game = this.getGame();
        if (game) {
            var width = game.getWidth();
            var step  = game.getStep();
            if (x * step >= 0 && x * step <= width - step) {
                this.x = x;
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
        return this;
    };
    this.vertical = function(size) {
        var y = this.getPositionY();
        this.setPositionY(y + size);
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
    this.play = function() {
        this.render();
        console.debug(this);
        return this;
    };
    this.onKeyBoardEvent = function(event) {
        var confirm = false;
        var player  = game.getPlayer();
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
        .renderGrid();
    window.onkeypress = this.onKeyBoardEvent;
};