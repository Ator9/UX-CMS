/**
 * Grid Row Insert plugin
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage: 
 * plugins: [ Ext.create('Ext.grid.plugin.RowEditing') ]
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid }) // Using Ext.grid.plugin.RowEditing
 * 
 * Ext.create('Ext.ux.GridRowInsert') // Automatic grid set
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid, form: this.form }) Using form
 *
 */
 
Ext.define('Ext.ux.GridRowInsert', {
    extend: 'Ext.button.Button',

    text: Admin.t('Add'),
    icon: 'resources/icons/plus.png',
    rowEditingColumn: 1,

    handler: function() {

        if(!this.grid) this.grid = this.up('grid'); // Uses parent grid if not set
        this.grid.getStore().insert(0, {}); // Insert row in grid
        this.grid.getSelectionModel().select(0); // select inserted row

        // If form:
        if(this.form) {
            this.form.getForm().reset();
            this.form.enable();

            // Focus first input.
            this.form.getComponent(0).getComponent(0).focus();
        }

        // RowEditing - Start editing the specified record & column:
        for(var i in this.grid.plugins) {
            if(this.grid.plugins[i].$className == 'Ext.grid.plugin.RowEditing') {
                this.grid.plugins[i].startEdit(0, this.rowEditingColumn);
                break;
            }
        }
    },
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
