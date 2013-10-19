Ext.define('admins.view.Logs', {
    extend: 'Ext.grid.Panel',
    
    initComponent: function() {
        this.columns = [
            { header: 'ID', dataIndex: 'logID', width: 80 },
            { header: 'Task', dataIndex: 'task' },
            { header: 'Comment', dataIndex: 'comment', flex: 1 },
            { header: 'Username', dataIndex: 'username' },
            { header: 'IP', dataIndex: 'ip' },
            { header: 'Date', dataIndex: 'date_created', xtype: 'datecolumn', format:'d/m/Y H:i:s', width: 120 }
        ];
        this.store = Ext.create('admins.store.Logs').load(); // Store + Load
        this.bbar = Ext.create('Ext.toolbar.Paging', { store: this.store, displayInfo: true });
        this.callParent(arguments);
    }
});
