Ext.define('admins.view.Accounts', {
    extend: 'Ext.panel.Panel',
    requires: ['Ext.ux.DualCheckbox'],
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createGrid(), this.createForm() ];
        this.tbar   = [
            Ext.create('Ext.ux.GridRowInsert', { grid: this.grid }), '-',
            Ext.create('Ext.ux.GridRowDelete', { grid: this.grid }), '-',
            Ext.create('Ext.ux.Search', { store: this.accountStore, columns: [ 'accountID', 'name' ] }) 
        ];
        this.callParent(arguments);
    },
    
    createGrid: function() {
        this.accountStore = Ext.create('admins.store.Accounts').load(); // Store + Load
        
        this.grid  = Ext.create('Ext.grid.Panel', {
            store: this.accountStore,
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing') ],
            region: 'center',
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'accountID', width: 50 },
                { header: 'Name', dataIndex: 'name', width: 150, editor: { allowBlank: false } },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon },
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

                        /*var rec = [{
                            Name: 'New Plant 1'
                        }];*/
                        
                       /* this.store.insert(0);
                        this.cellEditing.startEditByPosition({
                            row: 0, 
                            column: 0
                        });*/

                    }
                },
                edit: function(editor, context, eOpts) { 
                    context.store.sync();
                }           
            }
        });
        
        return this.grid;
    },
    
    createForm: function() {

        return this.form;
    }
});
