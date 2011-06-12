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

dojo.require('dijit.form.Form');
dojo.require('dijit.form.TextBox');
dojo.require('dijit.form.Textarea');
dojo.require('dijit.form.Button');

dojo.require('dijit.Toolbar');
dojo.require('dijit.Dialog');

// Estrutura de Classe
dojo.declare('app', null, {
    menu : null,
    tabber : null,
    dialog : null,
    console : null,
    toolbar : null,
    document : null,
    constructor : function() {
        this.menu     = new app.menu();
        this.tabber   = new app.tabber();
        this.dialog   = new app.dialog();
        this.toolbar  = new app.toolbar();
        this.console  = new app.console();
        this.document = new app.document();
        // Criação de Artigo
        
    },
    start : function() {
        this.console.clear();
    }
});

// Estrutura de Classe
dojo.declare('app.menu', null, {
    container : null,
    constructor : function() {
        // Painel de Documentos
        var container = dijit.byId('layout-docs');
        dojo.connect(container, 'onDownloadEnd', function(){
            dojo.query('#layout-docs a').forEach(function(element){
                dojo.connect(element, 'onclick', function(event){
                    dojo.stopEvent(event);
                    system.tabber.open(element.text, element.href);
                });
            });
        });
        container.setHref('artigo/service');
        // Anexos
        this.container = container;
    },
    load : function() {
        this.container.refresh();
    }
});

// Estrutura de Classe
dojo.declare('app.tabber', null, {
    container : null,
    constructor : function() {
        // Container de Tabs
        var container = dijit.byId('layout-tabcontainer');
        // Anexos
        this.container = container;
    },
    // Abrir uma Nova Aba
    open : function(title, address) {
        // Pesquisar Aba
        var tab = null;
        var children = this.container.getChildren();
        dojo.forEach(children, function(element){
            if (element.attr('href') == address) {
                tab = element;
            }
        });
        if (tab == null) {
            tab = new dijit.layout.ContentPane({
                href : address,
                title : title,
                closable : true
            });
            this.container.addChild(tab);
            dojo.connect(tab, 'onDownloadEnd', function(){
                var forms = dojo.query(tab.domNode).query('form');
                forms.connect('onsubmit', function(event){
                    dojo.stopEvent(event);
                    system.document.submit(this);
                });
            });
        }
        this.container.selectChild(tab);
    }
});

dojo.declare('app.document', null, {
    constructor : function() {},
    // Envia um Artigo
    submit : function(form) {
        dojo.xhrPost({
            form : form,
            handleAs : 'json',
            load : function(data) {
                dojo.forEach(data.messages, function(message){
                    system.console.print(message);
                });
            }
        });
    }
});

dojo.declare('app.console', null, {
    container : null,
    constructor : function() {
        // Componente para Saída de Mensagens
        this.container = dijit.byId('layout-output');
    },
    clear : function() {
        dojo.empty(this.container.id);
    },
    print : function(message) {
        var node = this.container.domNode;
        var div  = dojo.doc.createElement('div');
        dojo.attr(div, 'innerHTML', message);
        dojo.place(div, node);
    }
});

dojo.declare('app.toolbar', null, {
    newpage : null,
    constructor : function() {
        // Botão de Novo Artigo
        newpage = dijit.byId('toolbar-newpage');
        // Estilos
        newpage.attr('iconClass', 'dijitEditorIcon dijitEditorIconNewPage');
        dojo.connect(newpage, 'onClick', function(event){
            dojo.stopEvent(event);
            system.dialog.create();
        });
        // Anexos
        this.newpage = newpage;
    }
});

dojo.declare('app.dialog', null, {
    elements : {
        create : null
    },
    constructor : function() {},
    create : function() {
        if (this.elements.create == null) {
            var dialog = new dijit.Dialog({
                title : 'Novo Artigo',
                href : 'artigo/create'
            });
            dojo.connect(dialog, 'onDownloadEnd', function() {
                var forms = dojo.query(this.domNode).query('form');
                forms.connect('onsubmit', function(event){
                    dojo.stopEvent(event);
                    dojo.xhrPost({
                        form : this,
                        handleAs : 'json',
                        load : function(data) {
                            system.dialog.elements.create.destroyRecursive();
                            system.dialog.elements.create = null;
                            system.menu.load();
                            system.tabber.open(data.titulo, 'artigo/edit/idartigo/'+data.idartigo);
                        }
                    });
                });
            });
            console.log(this);
            this.elements.create = dialog;
        }
        this.elements.create.show();
    }
});

var system;
dojo.addOnLoad(function(){
    system = new app();
    system.start();
});