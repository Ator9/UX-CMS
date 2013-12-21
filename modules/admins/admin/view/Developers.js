Ext.define('admins.view.Developers', {
    extend: 'Ext.tab.Panel',
    
    initComponent: function() {

        var php = Ext.create('Ext.ux.IFrame', {
            title: 'PHP Info',
            src: Admin.getModulesUrl(this)+'/phpinfo.php'
        });

        var db = Ext.create('Ext.ux.IFrame', {
            title: 'phpMiniAdmin',
            src: Admin.getModulesUrl(this)+'/phpminiadmin.php'
        });

        var docs = Ext.create('Ext.ux.IFrame', {
            title: 'Documentation',
            src: Admin.getModulesUrl(this)+'/documentation.php'
        });
    
        this.items = [ php, db, docs ];
        this.callParent(arguments);
    }
});
