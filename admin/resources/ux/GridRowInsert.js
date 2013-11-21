/**
 * Grid Row Insert plugin
 *
 * @author Sebastián Gasparri
 * @version 21/11/2013 20:19:30
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage: 
 * plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ]
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid }) // Using Ext.grid.plugin.RowEditing
 * 
 * Ext.create('Ext.ux.GridRowInsert') // Automatic grid (parent)
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid, form: this.form }) Using form
 *
 */
 
Ext.define('Ext.ux.GridRowInsert', {
    extend: 'Ext.button.Button',

    text: 'Add',
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

        // Starts editing the specified record & column:
        if(this.grid.getPlugin('rowediting')) this.grid.getPlugin('rowediting').startEdit(0, this.rowEditingColumn);
    },
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
