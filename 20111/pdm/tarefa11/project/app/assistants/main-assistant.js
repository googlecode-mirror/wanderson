function MainAssistant() {}
MainAssistant.prototype.setup = function() {};
MainAssistant.prototype.activate = function(event) {};
MainAssistant.prototype.deactivate = function(event) {};
MainAssistant.prototype.cleanup = function(event) {};

/* Javascript Tron ---------------------------------------------------------- */

/**
 * Javascript Tron
 * @author Wanderson Henrique Camargo Rosa
 */
function jstron(field) {
	/**
	 * Campo de Jogo
	 * @var Canvas
	 */
	this.field = null;
	/**
	 * Mapeamento do Campo de Jogo
	 */
	this.mapper = null;

	/* Construção */
	this.setField(field);
}
/*
 * Estrutura de Protótipo
 */
jstron.prototype = {
	/**
	 * Configura o Campo de Jogo
	 * @param Canvas field Elemento para Configuração
	 * @return jstron Próprio Objeto para Encadeamento
	 */
	setField : function(field) {
		this.field = field;
		return this;
	},
	/**
	 * Informa o Campo de Jogo
	 * @return Canvas Elemento Solicitado
	 */
	getField : function() {
		return this.field;
	},
	/**
	 * Configura o Tamanho Horizontal do Campo de Jogo
	 * @param int width Elemento para Configuração
	 * @return jstron Próprio Objeto para Encadeamento
	 */
	setWidth : function(width) {
		this.getField().width = width;
		return this;
	},
	/**
	 * Informa o Tamanho Horizontal do Campo de Jogo
	 * @return int Elemento Solicitado
	 */
	getWidth : function() {
		return this.getField().width;
	},
	/**
	 * Configura o Tamanho Vertical do Campo de Jogo
	 * @param int height Elemento para Configuração
	 * @return jstron Próprio Objeto para Encadeamento
	 */
	setHeight : function(height) {
		this.getField().height = height;
		return this;
	},
	/**
	 * Informa o Tamanho Vertical do Campo de Jogo
	 * @return int Elemento Solicitado
	 */
	getHeight : function() {
		return this.getField().height;
	},
	/**
	 * Construção do Campo de Jogo
	 * @return jstron Próprio Objeto para Encadeamento
	 */
	build : function() {
		/* Informações */
		var width  = this.getWidth();
		var height = this.getHeight();
		var step   = 10; // Tamanho do Bloco
		/* Cálculos de Blocos */
		var x = width / step;
		var y = height / step;
		/* Laço de Preenchimento */
		this.mapper = new array(x);
		for (i = 0; i < width; i++) {
			mapper[i] = new array(y);
			for (j = 0; j < height; j++) {
				this.mapper[i][j] = false; // Campos não Ocupados
			}
		}
		return this;
	},
	/**
	 * Verifica se Existe Determinada Posição
	 * @param int x Posição Horizontal
	 * @param int y Posição Vertical
	 * @return bool Confirmação de Existência
	 */
	_check : function(x, y) {
		return typeof(this.mapper[x]) != 'undefined' && typeof(this.mapper[x][y]) != 'undefined';
	},
	/**
	 * Preenche uma Determinada Posição no Mapa
	 * @param int x Posição Horizontal
	 * @param int y Posição Vertical
	 * @return jstron Próprio Objeto para Encadeamento
	 */
	fill : function(x, y) {
		if (this._check(x, y)) {
			this.mapper[x][y] = true;
		}
		return this;
	},
	/**
	 * Verifica se uma Posição Está Preenchida
	 * @param int x Posição Horizontal
	 * @param int y Posição Vertical
	 * @return bool Confirmação de Preenchimento
	 */
	isFilled : function(x, y) {
		return this._check(x, y) && this.mapper[x][y];
	}
};

/* Javascript Tron Player --------------------------------------------------- */

/**
 * Jogador do Javascript Tron
 * @author Wanderson Henrique Camargo Rosa
 */
function jsplayer(game) {
	/**
	 * Referência ao Jogo
	 * @var jstron
	 */
	this.game;

	/* Construção */
	this.setGame(game);
}

/*
 * Estrutura do Protótipo
 */
jsplayer.prototype = {
	/**
	 * Configura a Referência ao Jogo
	 * @param jstron game Elemento para Configuração
	 * @return jsplayer Próprio Objeto para Encadeamento
	 */
	setGame : function(game) {
		this.game = game;
		return this;
	},
	/**
	 * Informa a Referência ao Jogo
	 * @return jstron Elemento Solicitado
	 */
	getGame : function() {
		return this.game;
	}
};