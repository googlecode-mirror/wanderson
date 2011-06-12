/**
 * Application Dojo Module
 * @author Wanderson Henrique Camargo Rosa
 */
dojo.provide('app');
// Dependências
dojo.require('dijit.layout.BorderContainer');
dojo.require('dijit.layout.ContentPane');
dojo.require('dijit.layout.TabContainer');
dojo.require('dijit.layout.AccordionContainer');

// Estrutura de Classe
dojo.declare('app', null, {
    constructor : function() {
        this.menu = new app.menu();
    }
});

// Estrutura de Classe
dojo.declare('app.menu', null, {
    container : null,
    constructor : function() {
        // Anexos
        this.container = dijit.byId('layout-docs');
    },
    load : function() {
    }
});