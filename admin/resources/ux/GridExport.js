/**
 * Grid Export plugin
 *
 * @author Sebastián Gasparri
 * @version 14/11/2013 19:45:14 
 *
 * Usage: 
 * Ext.create('Ext.ux.GridExport', { store: this.store })
 * Ext.create('Ext.ux.GridExport', { store: this.store, columns: [ 'adminID', 'username' ] })
 *
 */
 
Ext.define('Ext.ux.GridExport', {
    extend: 'Ext.button.Button',

    text: 'Export',
    icon: 'resources/icons/table-export.png',
    
    csvName: 'csv_export',
    csvZip: false,

    handler: function() {
        var store       = this.store;
        var sorters     = '&sort='+store.getSorters()[0].property+'&dir='+store.getSorters()[0].direction;
        var extraParams = '&'+Ext.urlEncode(store.getProxy().extraParams);
        
        var url = store.getProxy().api.read+sorters+extraParams+'&csvExport=Y&csvName='+this.csvName+'&csvZip='+this.csvZip;
        window.location = url;
    },
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
