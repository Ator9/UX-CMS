Ext.define('admins.view.Documentation', {
    extend: 'Ext.ux.IFrame',
    
    initComponent: function() {
        this.src = Admin.getModulesUrl(this)+'/documentation.php';
        this.callParent(arguments);
    }
});
