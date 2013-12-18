Ext.define('admins.view.Accounts', {
    extend: 'Ext.panel.Panel',
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createGridPanel(), this.createTabPanel() ];
        this.callParent(arguments);
    },
    
    createGridPanel: function() {
        var accountStore = Ext.create('admins.store.Accounts').load(); // Store + Load
        
        var grid = Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: accountStore,
            tbar: [
                Ext.create('Ext.ux.GridRowInsert'), '-',
                Ext.create('Ext.ux.GridRowDelete'), '-',
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
                    fn: function(view, record, item, index, e) {
                        this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                        /*
                        this.form.enable(); // enable form
                        this.form.loadRecord(record); // load record from grid data
                        this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                        */

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

        var accountsConfig = Ext.create('admins.store.AccountsConfig').load(); // Store

        var config = Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: accountsConfig,
            title: 'Configs',
            border: false,
            columns: [
                { header: 'Name', dataIndex: 'name', width: 200 },
                { header: 'Value', dataIndex: 'value', width: 300, editor: { } },
                { header: 'Description', dataIndex: 'description', flex: 1 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: accountsConfig, displayInfo: true }),
            listeners: {
                edit: function(editor, context, eOpts) {
                    context.store.sync(); // Synchronizes the store with its proxy (new, updated and deleted records)
                }
            }
        });


/*
        var users = Ext.create('Ext.grid.Panel', {
            //store: accountStore,
            title: 'Users',
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            region: 'west', // There must be a component with region: "center" in every border layout
            border: false,
            columns: [
                { header: 'ID', dataIndex: 'accountID', width: 50 },
                { header: 'Name', dataIndex: 'name', flex: 1, editor: { allowBlank: false } },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon, editor: { xtype: 'combo', store: [ 'Y', 'N' ], allowBlank: false } }
            ],
            listeners: {
                itemclick: {
                    scope: this,
                    fn: function(view, record, item, index, e) {
                        this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                    }
                },
                edit: function(editor, context, eOpts) { 
                    context.store.sync(); // Synchronizes the store with its proxy (new, updated and deleted records)
                }           
            }
        });*/
    
        var tabs = Ext.create('Ext.tab.Panel', {
            region: 'center', // There must be a component with region: "center" in every border layout
            border: false,
            items: [ config ]
        });
        
        return tabs;
    }
});
