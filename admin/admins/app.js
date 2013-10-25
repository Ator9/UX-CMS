Ext.define('admins.app', {
    extend: 'Ext.tab.Panel',
    
    initComponent: function() {
        var roleStore = Ext.create('admins.store.Roles').load(); // Shared store: try to avoid filters (pageSize/restrictions)
        
        this.title = '';
        this.items = [
            Ext.create('admins.view.Admins', { title: 'Admins', roleStore: roleStore }),
            Ext.create('admins.view.Roles', { title: 'Roles', store: roleStore }),
            Ext.create('admins.view.Logs', { title: 'Logs' }),
            Ext.create('admins.view.Php', { title: 'PHP Info' })
        ];
        this.callParent(arguments);
    }
});

// console.log(this.__proto__['$className']);
