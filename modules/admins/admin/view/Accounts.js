Ext.define('admins.view.Accounts', {
    extend: 'Ext.panel.Panel',
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createGrid(), this.createForm() ];
        this.callParent(arguments);
    },
    
    createGrid: function() {
        this.accountStore = Ext.create('admins.store.Accounts').load(); // Store + Load
        
        this.grid  = Ext.create('Ext.grid.Panel', {
            store: this.accountStore,
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            tbar: [
                Ext.create('Ext.ux.GridRowInsert'), '-',
                Ext.create('Ext.ux.GridRowDelete'), '-',
                Ext.create('Ext.ux.GridSearch', { store: this.accountStore, columns: [ 'accountID', 'name' ] }) 
            ],
            region: 'center', // There must be a component with region: "center" in every border layout
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'accountID', width: 50 },
                { header: 'Name', dataIndex: 'name', width: 150, editor: { allowBlank: false } },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon, editor: { xtype: 'combo', store: [ 'Y', 'N' ], allowBlank: false } },
                { header: 'Date Created', dataIndex: 'date_created', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: this.accountStore, displayInfo: true }),
            listeners: {
                itemclick: {
                    scope: this,
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
        
        return this.grid;
    },
    
    createForm: function() {

        return this.form;
    }
});
