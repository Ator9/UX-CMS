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

    showOptions: true, // Shows a window to display csv options

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
        var export_url = store.getProxy().api.read+sorters+extraParams+'&csvExport=Y';

        if(this.showOptions) this.getOptions(export_url);
        else  window.location = export_url+'&csvName='+this.csvName+'&csvZip='+this.csvZip+'&csvDelimiter='+this.csvDelimiter;
    },

    initComponent: function() {
        this.callParent(arguments);
    },

    getOptions: function(export_url) {
        var wininfo = Ext.create('Ext.Window', {
            title: 'CSV',
            width: 300,
            border: true,
            bodyStyle: 'padding: 5px',
            closeAction: 'hide',
            modal: true,
            items:  [
                { fieldLabel: Admin.t('Name'), xtype: 'textfield', value: this.csvName },
                { fieldLabel: Admin.t('Delimiter'), xtype: 'combo', store: [ ';', ',' ], value: this.csvDelimiter },
                { fieldLabel: Admin.t('ZIP'), xtype: 'combo', store: [ true, false ], value: this.csvZip }
            ],
            bbar: ['->', {
                text: Admin.t('Export'),
                icon: 'resources/icons/table-export.png',
                handler: function() {
                    var csvName = this.up().up().items.items[0].value;
                    var csvDelimiter = this.up().up().items.items[1].value;
                    var csvZip = this.up().up().items.items[2].value;

                    window.location = export_url+'&csvName='+csvName+'&csvZip='+csvZip+'&csvDelimiter='+csvDelimiter;
                }
            }]
        }).show();

        return wininfo;
    }
});
