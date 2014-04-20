Ext.define('admins.view.Partners', {
    extend: 'Ext.panel.Panel',
    
    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createTabPanel(), this.createGridPanel() ];
        this.callParent(arguments);
    },
    
    createGridPanel: function() {
        var partnerStore = Ext.create('admins.store.Partners').load(); // Store + Load

        var grid = Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: partnerStore,
            tbar: [
                Ext.create('Ext.ux.GridRowInsert'), '-',
                Ext.create('Ext.ux.GridRowDelete', { form: this.config.up() }), '-',
                Ext.create('Ext.ux.GridSearch', { columns: [ 'partnerID', 'name' ] }) 
            ],
            region: 'west', // There must be a component with region: "center" in every border layout
            width: 400,
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'partnerID', width: 50 },
                { header: 'Name', dataIndex: 'name', flex: 1, editor: { allowBlank: false } },
                { header: 'Active', dataIndex: 'active', width: 44, align: 'center', renderer: Admin.getStatusIcon, editor: { xtype: 'combo', store: [ 'Y', 'N' ], allowBlank: false } },
                { header: 'Date Created', dataIndex: 'date_created', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: partnerStore, displayInfo: true }),
            listeners: {
                itemclick: {
                    scope: this,
                    fn: function(view, record, item, index, e) {
                        this.down('panel').enable(); // enable form
                        this.config.setTitle('Config - ' + record.get('name'));
                        this.admins.setTitle('Admins - ' + record.get('name'));
                        
                        this.partnersConfigStore.getProxy().extraParams = { partnerID: record.get('partnerID') }; // set partnerID
                        this.partnersConfigStore.load(); // get results from partnerID

                        this.partnersAdminsStore.getProxy().extraParams = { partnerID: record.get('partnerID') }; // set partnerID
                        this.partnersAdminsStore.load(); // get results from partnerID
                        
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
        this.partnersConfigStore = Ext.create('admins.store.PartnersConfig');
        this.partnersAdminsStore = Ext.create('admins.store.PartnersAdmins');

        this.config =  Ext.create('Ext.grid.Panel', {
            plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ],
            store: this.partnersConfigStore,
            title: 'Config',
            region: 'north',
            height: 200,
            border: false,
            columns: [
                { header: 'Name', dataIndex: 'name', width: 200 },
                { header: 'Value', dataIndex: 'value', width: 300, editor: {} },
                { header: 'Description', dataIndex: 'description', flex: 1 }
            ],
            listeners: {
                edit: function(editor, context, eOpts) {
                    context.store.sync(); // Synchronizes the store with its proxy (new, updated and deleted records)
                }
            }
        });
        
        var add_admin = Ext.create('Ext.Window', {
            title: 'Add Admin to Partner',
            width: 350,
            border: false,
            closeAction: 'hide',
            items: {
                xtype: 'form',
                url: 'index.php?_class=adminsPartnersAdmins&_method=addAdminToPartner',
                bodyStyle: 'padding:5px', // Custom CSS styles to be applied to the panel's body element
                defaultType: 'textfield',
                items: [
                    { name: 'key', fieldLabel: 'Username / E-mail', labelWidth: 120, allowBlank: false },
                    { name: 'partnerID', xtype: 'hidden' }
                ],
                bbar: ['->', {
                    text: 'Add',
                    icon: 'resources/icons/plus.png',
                    scope: this,
                    handler: function() {
                        add_admin.down('form').getForm().setValues({ partnerID: this.down('grid[region=west]').getSelectionModel().getSelection()[0].get('partnerID') });
                        if(add_admin.down('form').isValid()) {
                            add_admin.down('form').submit({
                                scope: this,
                                success: function(form, action) {
                                    this.partnersAdminsStore.reload();
                                    add_admin.hide();
                                    Admin.Msg('Admin succesfully added.', true);
                                },
                                failure: function(form, action) { Admin.Msg('Admin not found.', false); }
                            });
                        }
                        else Admin.Msg('Please complete required fields', false);
                    }
                }]
            }
        });

        this.admins =  Ext.create('Ext.grid.Panel', {
            store: this.partnersAdminsStore,
            region: 'center',
            tbar: [
                { text: 'Add', icon: 'resources/icons/plus.png', handler: function(){ add_admin.show(); }}, '-', 
                Ext.create('Ext.ux.GridRowDelete', { itemId: 'gridDeleteButton2', form: this.config.up() }), '-',
                Ext.create('Ext.ux.GridSearch', { columns: [ 'adm.adminID', 'username', 'email' ] }) 
            ],
            title: 'Admins',
            border: false,
            style: { borderTop: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'adminID', width: 50 },
                { header: 'Username', dataIndex: 'username', width: 150 },
                { header: 'E-mail', dataIndex: 'email', width: 150 },
                { header: 'Last login', dataIndex: 'last_login', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
            ],
            bbar: Ext.create('Ext.toolbar.Paging', { store: this.partnersAdminsStore, displayInfo: true }),
            listeners: {
                itemclick: {
                    scope: this,
                    fn: function(view, record, item, index, e) {
                        this.down('#gridDeleteButton2').setDisabled(false); // Enable delete button
                    }
                }    
            }
        });

        var tabs = Ext.create('Ext.panel.Panel', {
            layout: 'border',
            region: 'center', // There must be a component with region: "center" in every border layout
            border: false,
            disabled: true,
            items: [ this.config, this.admins ]
        });

        return tabs;
    }
});
