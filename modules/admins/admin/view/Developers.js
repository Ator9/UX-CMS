Ext.define('admins.view.Developers', {
    extend: 'Ext.tab.Panel',
    
    initComponent: function() {

        var docs = Ext.create('Ext.ux.IFrame', {
            title: 'Documentation',
            src: Admin.getModulesUrl(this)+'/documentation.php'
        });

        var php = Ext.create('Ext.ux.IFrame', {
            title: 'PHP Info',
            src: Admin.getModulesUrl(this)+'/phpinfo.php'
        });

        var db = Ext.create('Ext.ux.IFrame', {
            title: 'phpMiniAdmin',
            src: Admin.getModulesUrl(this)+'/phpminiadmin.php'
        });

        this.items = [ docs, php, db ];
        this.callParent(arguments);
    }
});
