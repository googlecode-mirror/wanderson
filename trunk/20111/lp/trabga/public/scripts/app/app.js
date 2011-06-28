dojo.provide('app');
// Pacotes
dojo.require('dijit.layout.ContentPane');
dojo.require('dijit.form.Form');
dojo.require('dijit.form.Button');
dojo.require('dijit.form.TextBox');
dojo.require('dijit.form.Textarea');
// Declaração
dojo.declare('app', null, {
    _baseUrl : '/artigos',
    baseUrl : function(address) {
        return this._baseUrl + address;
    }
});

// Start System
var sys = new app();

// Ready
dojo.ready(function(){

    // Menu Lateral - Abrir Artigo
    dojo.connect(dijit.byId('documents'), 'onClick', function(item){
        if (!item.root) {
            var content = null;
            var idartigo = 'artigo' + item.idartigo;
            var container = dijit.byId('tab_container');
            dojo.forEach(container.getChildren(), function(element){
                if (element.attr('id') == idartigo) {
                    content = element;
                }
            });
            if (content == null) {
                content = new dijit.layout.ContentPane({
                    id : idartigo,
                    title : item.titulo,
                    closable : true,
                    onDownloadEnd : function(event) {
                        dojo.query(dojo.byId(idartigo)).query('form').connect('onsubmit', function(event){
                            dojo.stopEvent(event);
                            dojo.xhrPost({
                                form : this
                            });
                        });
                    }
                });
                container.addChild(content);
            }
            container.selectChild(content);
            content.attr('href', sys.baseUrl('/artigo/edit/idartigo/'+item.idartigo));
        }
    });

});