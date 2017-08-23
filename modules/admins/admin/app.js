Ext.define('admins.app', {
    extend: 'Ext.tab.Panel',
    
    config: {
        module: 'admins'
    },
    
    initComponent: function() {
        var roleStore = Ext.create(this.module+'.store.Roles').load(); // Shared store: try to avoid filters (pageSize/restrictions)
        
        this.title = '';
        this.items = [
            Ext.create(this.module+'.view.Admins', { title: Admin.t('Admins'), roleStore: roleStore }),
            Ext.create(this.module+'.view.Roles', { title: Admin.t('Roles'), store: roleStore }),
            Ext.create(this.module+'.view.Partners', { title: Admin.t('Partners') }),
            Ext.create(this.module+'.view.Logs', { title: Admin.t('Logs') }),
            Ext.create(this.module+'.view.Developers', { title: Admin.t('Developers') })
        ];
        
        this.callParent(arguments);
    }
});
