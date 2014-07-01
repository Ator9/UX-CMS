Ext.define('admins.view.Developers', {
    extend: 'Ext.tab.Panel',
    
    initComponent: function() {
        var items = [];

        items.push(Ext.create('Ext.ux.IFrame', {
            title: 'phpMiniAdmin',
            src: Admin.getModulesUrl(this)+'/phpminiadmin.php'
        }));

        items.push(Ext.create('Ext.ux.IFrame', {
            title: 'Documentation',
            src: Admin.getModulesUrl(this)+'/documentation.php'
        }));

        items.push(Ext.create('Ext.ux.IFrame', {
            title: 'PHP Info',
            src: Admin.getModulesUrl(this)+'/phpinfo.php'
        }));

        this.items = items;
        this.callParent(arguments);
    }
});
