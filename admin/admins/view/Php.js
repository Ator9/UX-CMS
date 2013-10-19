Ext.define('admins.view.Php', {
    extend: 'Ext.ux.IFrame',
    
    initComponent: function() {

        this.src = 'admins/phpinfo.php';
        this.callParent(arguments);
    }
});
