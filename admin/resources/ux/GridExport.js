/**
 * Grid Export plugin
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage: 
 * Ext.create('Ext.ux.GridExport') // Automatic store set
 * Ext.create('Ext.ux.GridExport', { store: this.store })
 *
 */
 
Ext.define('Ext.ux.GridExport', {
    extend: 'Ext.button.Button',

    text: Admin.t('Export'),
    icon: 'resources/icons/table-export.png',
    
    csvName: 'csv_export',
    csvDelimiter: ';',
    csvZip: false,

    handler: function() {
        if(!this.store) this.store = this.up('grid').getStore(); // Uses grid store if not set

        var store  = this.store;

        var sort  = (Ext.getVersion().getMajor() >= 5) ? store.getSorters().items[0].getProperty() : store.getSorters()[0].property;
        var dir   = (Ext.getVersion().getMajor() >= 5) ? store.getSorters().items[0].getDirection() : store.getSorters()[0].direction;

        var sorters     = '&sort='+sort+'&dir='+dir;
        var extraParams = '&'+Ext.urlEncode(store.getProxy().extraParams);
        
        var url = store.getProxy().api.read+sorters+extraParams+'&csvExport=Y&csvName='+this.csvName+'&csvZip='+this.csvZip+'&csvDelimiter='+this.csvDelimiter;
        window.location = url;
    },
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
