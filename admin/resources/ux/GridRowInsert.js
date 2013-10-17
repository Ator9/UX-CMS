/**
 * Grid Row Insert (button) plugin
 *
 * @author Sebastián Gasparri
 * @version 15/05/2013 15:13:07
 *
 * Usage: 
 * Ext.create('Admin.extjs.GridRowInsert', { grid: this.grid, form: this.form })
 *
 */
 
Ext.define('Ext.ux.GridRowInsert', {
    extend: 'Ext.button.Button',

    text: 'Add',
    icon: 'resources/icons/plus.png',

    handler: function() {
        this.form.getForm().reset();
        this.form.enable();

        this.grid.getStore().insert(0, {}); // Insert row in grid
        this.grid.getSelectionModel().select(0); // select inserted row

        // Focus first input
        this.form.getComponent(0).getComponent(0).focus(); // Examines this container's items property and gets a direct child component of this container.
    },
    
    initComponent: function() {
        this.callParent();
    }
});
