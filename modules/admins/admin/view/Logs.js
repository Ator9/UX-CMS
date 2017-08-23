Ext.define('admins.view.Logs', {
    extend: 'Ext.grid.Panel',
    
    config: {
        module: 'admins',
        phpclass: 'adminsLog',
        primaryID: 'logID'
    },
    
    // Renderers:
    textFormat: function(value, metadata) {
        return '<div style="white-space:normal">'+value+'</div>';
    },
    
    initComponent: function() {
        
        var admins_combo = Ext.create('Ext.ux.ComboBox', {
            name: 'adminID',
            valueField: 'adminID',
            displayField: 'username',
            store: Ext.create('admins.store.AdminsList').load(),
        });
        
        this.store = Ext.create(this.self.getName().replace('view','store')).load(); // Store + Load
        this.tbar = [
            Ext.create('Ext.ux.GridSearch', { columns: [ this.primaryID, 'classname', 'task', 'comment' ] }), 
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
            { header: Admin.t('ID'), dataIndex: 'logID', width: 80 },
            { header: Admin.t('Classname'), dataIndex: 'classname' },
            { header: Admin.t('Task'), dataIndex: 'task' },
            { header: Admin.t('Comment'), dataIndex: 'comment', flex: 1, renderer: this.textFormat },
            { header: Admin.t('User'), dataIndex: 'username' },
            { header: Admin.t('IP'), dataIndex: 'ip' },
            { header: Admin.t('Date'), dataIndex: 'date_created', xtype: 'datecolumn', format:'d/m/Y H:i:s', width: 120 }
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
