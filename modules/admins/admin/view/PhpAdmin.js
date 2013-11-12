Ext.define('admins.view.PhpAdmin', {
    extend: 'Ext.ux.IFrame',
    
    initComponent: function() {
        this.src = Admin.getModulesUrl(this)+'/phpminiadmin.php';
        this.callParent(arguments);
    }
});
