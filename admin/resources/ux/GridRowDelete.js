/**
 * Grid Row Delete plugin
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage: 
 * Ext.create('Ext.ux.GridRowDelete') // Automatic grid set
 * Ext.create('Ext.ux.GridRowDelete', { grid: this.grid });
 * Ext.create('Ext.ux.GridRowDelete', { grid: this.grid, form: this.form });
 *
 */
 
Ext.define('Ext.ux.GridRowDelete', {
    extend: 'Ext.button.Button',

    itemId: 'gridDeleteButton',
    text: Admin.t('Delete'),
    icon: 'resources/icons/crosstick-N.png',
    disabled: true,

    handler: function() {

        if(!this.grid) this.grid = this.up('grid'); // Uses parent grid if not set
    
        if(this.grid.getSelectionModel().getSelection().length) {
            Ext.MessageBox.confirm({
                title: 'Confirm',
                msg: Admin.t('Are you sure you want to delete this record?'),
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.INFO,
                scope: this,
                fn: this.rowDelete
            });
        }
        else this.disableComponents();
    },

    rowDelete: function(btn) {
        if(btn=='yes') {
            this.grid.setLoading(); // Show loading mask
            this.grid.getStore().remove(this.grid.getSelectionModel().getSelection()); // remove from grid
            this.grid.getStore().sync({ // Sync store (calling delete method)
                scope: this,
                success: function(form, action) { this.grid.setLoading(false); },
                failure: function(form, action) {
                    this.grid.setLoading(false); // Hide loading mask
                    Admin.Msg('Delete error ocurred', false);
                    this.grid.getStore().reload();
                }
            });
            this.disableComponents();
        }
    },

    disableComponents: function() {
        this.setDisabled(true); // disable button
        if(this.form) this.form.disable(); // disable form
    },
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
