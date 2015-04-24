Ext.define('admins.view.Logs', {
    extend: 'Ext.grid.Panel',
    
    textFormat: function(value, metadata) {
        return '<div style="white-space:normal;">'+value+'</div>';
    },
    
    initComponent: function() {
        
        var admins_combo = Ext.create('Ext.form.ComboBox', {
            width: 250,
            name: 'adminID',
            valueField: 'adminID',
            displayField: 'username',
            emptyText: Admin.t('Users')+'...',
            queryMode: 'local', // 'remote' is typically used for "autocomplete" type inputs.
            forceSelection: true, // true to restrict the selected value to one of the values in the list, false to allow the user to set arbitrary text into the field.
            store: Ext.create('admins.store.AdminsList').load(),
            trigger1Cls: 'x-form-clear-trigger',
            trigger2Cls: 'x-form-trigger',
            onTrigger1Click: Ext.bind(this.clear, this, 'adminID', true),
            listeners: { scope: this, select: this.onSelectArea }
        });
        
        this.store = Ext.create('admins.store.Logs').load(); // Store + Load
        this.tbar = [
            Ext.create('Ext.ux.GridSearch', { columns: [ 'logID', 'classname', 'task', 'comment' ] }), 
            Admin.t('Date from'), {
                xtype: 'datefield',
                name: 'date_from',
                format: 'd/m/Y',
                listeners: {
                    scope: this,
                    change: function(me, newValue, oldValue, eOpts) {
                        if(me.value && isNaN(me.value.length)) {
                            var date = Ext.Date.format(new Date(newValue), 'Y-m-d');
                            this.store.getProxy().extraParams.date_from = date;
                            this.store.load();
                        } else if(!me.value) {
                            delete(this.store.getProxy().extraParams['date_from']);
                            this.store.load();
                        }
                    }
                }
            }, Admin.t('Date to'), {
                xtype: 'datefield',
                name: 'date_to',
                format: 'd/m/Y',
                listeners: {
                    scope: this,
                    change: function(me, newValue, oldValue, eOpts) {
                        if(me.value && isNaN(me.value.length)) {
                            var date = Ext.Date.format(new Date(newValue), 'Y-m-d');
                            this.store.getProxy().extraParams.date_to = date;
                            this.store.load();
                        } else if(!me.value) {
                            delete(this.store.getProxy().extraParams['date_to']);
                            this.store.load();
                        }
                    }
                }
            }, 
            Admin.t('User'), admins_combo,
            '|', Ext.create('Ext.ux.GridExport', { csvZip: true }) 
        ];
        this.columns = [
            { header: 'ID', dataIndex: 'logID', width: 80 },
            { header: 'Classname', dataIndex: 'classname' },
            { header: 'Task', dataIndex: 'task' },
            { header: 'Comment', dataIndex: 'comment', flex: 1, renderer: this.textFormat },
            { header: Admin.t('User'), dataIndex: 'username' },
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
    },
    
    // Selects - Store reload:
    onSelectArea: function(combo, records, eOpts) {
        this.store.getProxy().extraParams[combo.name] = combo.getValue(); // Add extra param
        this.store.reload(); // Reload
    },
    
    // Clear comboboxes:
    clear: function(obj, name) {
        this.down('combobox[name='+name+']').clearValue();
        
        delete(this.store.getProxy().extraParams[name]);
        this.store.reload(); // Reload
    }
});
