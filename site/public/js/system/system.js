dojo.provide('system');
dojo.require('dojo.parser');
dojo.require('dijit.layout.ContentPane');
dojo.require('dijit.layout.BorderContainer');

dojo.declare('system', null, {
    init: function()
    {
        dojo.query('#main').attr('dojoType','dijit.layout.BorderContainer')
            .style('width','100%').style('height','100%').style('border',0);
        dojo.query('#top').attr('dojoType','dijit.layout.ContentPane')
            .attr('region','top').style('border',0)
            .style('backgroundColor','transparent');
        dojo.query('#content').attr('dojoType','dijit.layout.ContentPane')
            .attr('region','center');
        dojo.parser.parse();
    }
});

system = new system();