Ext.define('admins.view.Logs', {
    extend: 'Ext.grid.Panel',
    
    textFormat: function(value, metadata) {
        return '<div style="white-space:normal;">'+value+'</div>';
    },
    
    initComponent: function() {
        this.store = Ext.create('admins.store.Logs').load(); // Store + Load
        this.tbar = [
            Ext.create('Ext.ux.GridSearch', { columns: [ 'logID', 'classname', 'task', 'comment' ] }), '-',
            Ext.create('Ext.ux.GridExport', { csvZip: true }) 
        ];
        this.columns = [
            { header: 'ID', dataIndex: 'logID', width: 80 },
            { header: 'Classname', dataIndex: 'classname' },
            { header: 'Task', dataIndex: 'task' },
            { header: 'Comment', dataIndex: 'comment', flex: 1, renderer: this.textFormat },
            { header: 'Username', dataIndex: 'username' },
            { header: 'IP', dataIndex: 'ip' },
            { header: 'Date', dataIndex: 'date_created', xtype: 'datecolumn', format:'d/m/Y H:i:s', width: 120 }
        ];
        this.viewConfig = { enableTextSelection: true };
        this.bbar = Ext.create('Ext.toolbar.Paging', { store: this.store, displayInfo: true });
        this.callParent(arguments);
    },
    listeners: {
        afterrender: function(view, model) {
            setInterval(function() { view.store.load(); }, 60000); // actualizo la lista cada 1 minuto
        }
    }
});
