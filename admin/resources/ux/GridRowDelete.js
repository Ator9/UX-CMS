/**
 * Grid Row Delete (button) plugin
 *
 * @author Sebastián Gasparri
 * @version 15/05/2013 15:13:07
 *
 * Usage: 
 * Ext.create('Admin.extjs.GridRowDelete', { grid: this.grid })
 * Ext.create('Admin.extjs.GridRowDelete', { grid: this.grid, form: this.form })
 *
 */
 
Ext.define('Ext.ux.GridRowDelete', {
    extend: 'Ext.button.Button',

    text: 'Delete',
    itemId: 'gridDeleteButton',
    icon: 'resources/icons/crosstick-N.png',
    disabled: true,

    handler: function() {
        if(this.grid.getSelectionModel().getSelection().length) {
            Ext.MessageBox.confirm({
                title: 'Confirm',
                msg: 'Are you sure you want to delete this record?',
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
            this.grid.getStore().remove(this.grid.getSelectionModel().getSelection()); // remove from grid
            this.grid.getStore().sync(); // sync store (calling delete method)
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
