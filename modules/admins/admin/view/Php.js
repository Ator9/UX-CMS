Ext.define('admins.view.Php', {
    extend: 'Ext.ux.IFrame',
    
    initComponent: function() {
        this.src = Admin.getModulesUrl(this)+'/phpinfo.php';
        this.callParent(arguments);
    }
});
