Ext.define('admins.view.Admins', {
    extend: 'Ext.panel.Panel',
    requires: ['Ext.ux.DualCheckbox'],

    // Renderers:
    getRole: function(value, metaData, record, rowIndex, colIndex, store, gridView) { // getRole from store
        var find = this.roleStore.findRecord('roleID', value, 0, false, true, true); // Finds the first matching Record in this store by a specific field value.
        return (find) ? find.get('name') : '';
    },
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createGrid(), this.createForm() ];
        this.tbar   = [
            Ext.create('Ext.ux.GridRowInsert', { grid: this.grid, form: this.form }), '-',
            Ext.create('Ext.ux.GridRowDelete', { grid: this.grid, form: this.form }), '-',
            Ext.create('Ext.ux.GridSearch', { store: this.store, columns: [ 'adminID', 'username' ] })
        ];
        this.callParent(arguments);
    },
    
    createGrid: function() {
        this.store = Ext.create('admins.store.Admins').load(); // Store + Load
        this.grid  = Ext.create('Ext.grid.Panel', {
            store: this.store,
            region: 'center', // There must be a component with region: "center" in every border layout
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'adminID', width: 50 },
                { header: 'Username', dataIndex: 'username', width: 200 },
                { header: 'E-mail', dataIndex: 'email', width: 200 },
                { header: 'Role', dataIndex: 'roleID', flex: 1, renderer: this.getRole, scope: this },
                { header: 'Superuser', dataIndex: 'superuser', width: 64, align: 'center', renderer: Admin.getStatusIcon },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon },
                { header: 'Last Login', dataIndex: 'last_login', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
            ],
            viewConfig: { enableTextSelection: true },
            bbar: Ext.create('Ext.toolbar.Paging', { store: this.store, displayInfo: true }),
            listeners: {
                itemclick: {
                    scope: this,
                    fn: function(view, record, item, index, e) {
                        this.form.enable(); // enable form
                        this.form.loadRecord(record); // load record from grid data
                        this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                    }
                }               
            }
        });
        
        return this.grid;
    },
    
    createForm: function() {
        var roles_combo = Ext.create('Ext.form.ComboBox', {
            name: 'roleID',
            fieldLabel: 'Role',
            valueField: 'roleID',
            displayField: 'name',
            emptyText: 'Select role',
            editable: false,
            queryMode: 'local', // 'remote' is typically used for "autocomplete" type inputs.
            forceSelection: true, // true to restrict the selected value to one of the values in the list, false to allow the user to set arbitrary text into the field.
            store: this.roleStore
        });

        var form_handler = function() {
            if(this.form.isValid()) {
                this.form.submit({
                    scope: this,
                    success: function(form, action) {
                        this.store.load({ // Use reload() if callback is not needed
                            scope: this,
                            callback: function(records, operation, success) {
                                var index = this.store.findExact('adminID', form.getValues()['adminID']); // Search modified row grid position
                                this.grid.getSelectionModel().select(Math.max(0, index)); // Select modified row (need "0" for new inserts)
                                this.grid.fireEvent('itemclick', this.grid, this.grid.getSelectionModel().getLastSelected()); // Keep new inserted id
                            }
                        });
                        Admin.Msg(Admin.t('Record has been saved successfully'), true);
                    },
                    failure: function(form, action) { Admin.Msg('An error ocurred.', false); }
                });
            }
            else Admin.Msg('Please complete required fields', false);
        }
    
        this.form = Ext.create('Ext.form.Panel', {
            url: 'index.php?_class=adminsAdmin&_method=extSave',
            region: 'east',
            border: false,
            disabled: true,
            bodyStyle: 'padding:5px', // Custom CSS styles to be applied to the panel's body element
            items: [{
                title: 'Info',
                xtype: 'fieldset',
                defaultType: 'textfield',
                items: [
                    { name: 'username', fieldLabel: 'Username', allowBlank: false },
                    { name: 'password', fieldLabel: 'Password', inputType: 'password' },
                    { name: 'email', fieldLabel: 'E-mail', vtype: 'email' }, // vtype applies email validation rules to this field
                    { name: 'firstname', fieldLabel: 'First Name' },
                    { name: 'lastname', fieldLabel: 'Last Name' },
                      roles_combo,
                    { name: 'superuser', fieldLabel: 'Superuser', xtype: 'dualcheckbox' },
                    { name: 'active', fieldLabel: 'Active', xtype: 'dualcheckbox' },
                    { name: 'adminID', xtype: 'hidden' }
                ]
            }],
            bbar: ['->', {
                text: Admin.t('Save'),
                icon: 'resources/icons/disk-return-black.png',
                height: 24,
                scope: this,
                handler: form_handler
            }]
        });

        return this.form;
    }
});
