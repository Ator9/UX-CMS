Ext.define('admins.view.Accounts', {
    extend: 'Ext.panel.Panel',
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createTabPanel(), this.createGridPanel() ];
        this.callParent(arguments);
    },
    
    createGridPanel: function() {
        var accountStore = Ext.create('admins.store.Accounts').load(); // Store + Load

        var grid = Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: accountStore,
            tbar: [
                Ext.create('Ext.ux.GridRowInsert'), '-',
                Ext.create('Ext.ux.GridRowDelete', { form: this.form }), '-',
                Ext.create('Ext.ux.GridSearch', { columns: [ 'accountID', 'name' ] }) 
            ],
            region: 'west', // There must be a component with region: "center" in every border layout
            width: 400,
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'accountID', width: 50 },
                { header: 'Name', dataIndex: 'name', flex: 1, editor: { allowBlank: false } },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon, editor: { xtype: 'combo', store: [ 'Y', 'N' ], allowBlank: false } },
                { header: 'Date Created', dataIndex: 'date_created', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: accountStore, displayInfo: true }),
            listeners: {
                itemclick: {
                    scope:this,
                    fn: function(view, record, item, index, e) {
                        this.form.enable(); // enable form
                        this.form.setTitle('Config - ' + record.get('name'));
                        
                        this.accountsConfigStore.getProxy().extraParams = { accountID: record.get('accountID') }; // set accountID
                        this.accountsConfigStore.load(); // get results from accountID
                        this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                    }
                },
                edit: function(editor, context, eOpts) { 
                    context.store.sync(); // Synchronizes the store with its proxy (new, updated and deleted records)
                }           
            }
        });
        
        return grid;
    },
    
    createTabPanel: function() {
        this.accountsConfigStore = Ext.create('admins.store.AccountsConfig');

        this.form =  Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: this.accountsConfigStore,
            title: 'Config',
            border: false,
            region: 'center', // There must be a component with region: "center" in every border layout
            columns: [
                { header: 'Name', dataIndex: 'name', width: 200 },
                { header: 'Value', dataIndex: 'value', width: 300, editor: { } },
                { header: 'Description', dataIndex: 'description', flex: 1 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: this.accountsConfigStore, displayInfo: true }),
            listeners: {
                edit: function(editor, context, eOpts) {
                    context.store.sync(); // Synchronizes the store with its proxy (new, updated and deleted records)
                }
            }
        });

        return this.form;
    }
});
