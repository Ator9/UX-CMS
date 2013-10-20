Ext.define('admins.view.Roles', {
    extend: 'Ext.panel.Panel',

    initComponent: function() {
        this.layout = 'border'; // Any Container using the Border layout must have a child item with region: 'center'
        this.items  = [ this.createGrid(), this.createForm() ];
        this.tbar   = [
            Ext.create('Ext.ux.GridRowInsert', { grid: this.grid, form: this.form }), '-',
            Ext.create('Ext.ux.GridRowDelete', { grid: this.grid, form: this.form })
        ];
        this.callParent(arguments);
    },
    
    createGrid: function() {
        this.grid  = Ext.create('Ext.grid.Panel', {
            store: this.store,
            region: 'center',
            border: false,
            style: { borderRight: '1px solid #99bce8' }, // A custom style specification to be applied to this component's Element
            columns: [
                { header: 'ID', dataIndex: 'roleID', width: 50 },
                { header: 'Name', dataIndex: 'name', width: 200 },
                { header: 'Permission', dataIndex: 'permission', flex: 1 }
            ],
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

        this.getModulePerms = function() {
            var items = [];
            
            for(var i=0; i<13; i++) {
                items.push({ fieldLabel: 'Admin', xtype: 'displayfield', labelWidth: 200, labelStyle: 'font-weight:700' });
                items.push({ fieldLabel: 'Read', name: 'read', labelAlign: 'right', labelWidth: 60 });
                items.push({ fieldLabel: 'Write', name: 'write', labelAlign: 'right', labelWidth: 60 });
            }
            return items;
        };
    
        this.form = Ext.create('Ext.form.Panel', {
            url: '1nit.php?_class=AdminsRoles&_method=extSave',
            region: 'east',
            autoScroll: true, // true to show scroll bars automatically when necessary
            border: false,
            width: 400,
            disabled: true,
            bodyStyle: 'padding:5px', // Custom CSS styles to be applied to the panel's body element
            items: [{
                title: 'Info',
                xtype: 'fieldset',
                defaultType: 'textfield',
                items: [
                    { name: 'name', fieldLabel: 'Name', allowBlank: false },
                    { name: 'roleID', xtype: 'hidden' }
                ]
            },{
                title: 'Módulos',
                layout: { type: 'table', columns: 3 },
                bodyStyle: 'padding:5px', // Custom CSS styles to be applied to the panel's body element
                defaultType: 'dualcheckbox',
                items: this.getModulePerms()
            }],
            bbar: ['->', {
                text: 'Save',
                icon: 'resources/icons/disk-return-black.png',
                height: 24,
                scope: this,
                handler: function() {
                    if(this.form.isValid()) {
                        this.form.submit({
                            scope: this,
                            success: function(form, action) {
                                this.store.load({ // Use reload() if callback is not needed
                                    scope: this,
                                    callback: function(records, operation, success) {
                                        var index = this.store.findExact('roleID', form.getValues()['roleID']); // Search modified row grid position
                                        this.grid.getSelectionModel().select(Math.max(0, index)); // Select modified row (need "0" for new inserts)
                                        this.grid.fireEvent('itemclick', this.grid, this.grid.getSelectionModel().getLastSelected()); // Keep new inserted id
                                    }
                                });
                                Ext.Msg.show({
                                    title: 'OK :)',
                                    msg: 'Record saved succesfully.',
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.Msg.INFO
                                });
                            },
                            failure: function(form, action) {
                                Ext.Msg.show({
                                    title: 'Error :(',
                                    msg: 'An error ocurred.',
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.Msg.ERROR
                                });
                            }
                        });
                    }
                    else {
                        Ext.Msg.show({
                            title: 'Error :(',
                            msg: 'Please complete required fields',
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.ERROR
                        });
                    }
                }
            }]
        });

        return this.form;
    }
});
