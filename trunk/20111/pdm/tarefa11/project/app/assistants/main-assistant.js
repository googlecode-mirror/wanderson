function MainAssistant() {}
MainAssistant.prototype.setup = function() {
	/* Capturas */
	var jt = new jstron();
	var jf = this.controller.get('jsfield');
	/* Configurações */
	jf.style.backgroundColor = '#000';
	jt.setField(jf);
	jt.setWidth(240);
	jt.setHeight(180);
	/* Anexos */
	this.jstron = jt;
};
MainAssistant.prototype.activate = function(event) {};
MainAssistant.prototype.deactivate = function(event) {};
MainAssistant.prototype.cleanup = function(event) {};

/* Javascript Tron -----------------------------------------------------------*/

/**
 * Javascript Tron
 * @author Wanderson Henrique Camargo Rosa
 */
function jstron() {}
/**
 * Protótipo de Construção
 */
jstron.prototype = {
	/**
	 * Configura o Campo de Batalha
	 * @param field Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	setField : function(field) {
		this.field = field;
		return this;
	},
	/**
	 * Informa o Campo de Batalha
	 * @return Elemento Solicitado
	 */
	getField : function() {
		return this.field;
	},
	/**
	 * Configura o Tamanho Horizontal do Campo
	 * @param width Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	setWidth : function(width) {
		this.getField().width = width;
		return this;
	},
	/**
	 * Informa o Tamanho Horizontal do Campo
	 * @return Elemento Solicitado
	 */
	getWidth : function() {
		return this.getField().width;
	},
	/**
	 * Configura o Tamanho Vertical do Campo
	 * @param height Elemento para Configuração
	 * @return Próprio Objeto para Encadeamento
	 */
	setHeight : function(height) {
		this.getField().height = height;
		return this;
	},
	/**
	 * Informa o Tamanho Horizontal do Campo
	 * @return Elemento Solicitado
	 */
	getHeight : function() {
		return this.getField().height;
	}
}
