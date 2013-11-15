/**
 * Grid Row Insert plugin
 *
 * @author Sebastián Gasparri
 * @version 10/11/2013 22:33:38 
 *
 * Usage: 
 * plugins: [ Ext.create('Ext.grid.plugin.RowEditing', { pluginId: 'rowediting' }) ]
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid }) // Using Ext.grid.plugin.RowEditing
 * 
 * Ext.create('Ext.ux.GridRowInsert', { grid: this.grid, form: this.form }) Using form
 *
 */
 
Ext.define('Ext.ux.GridRowInsert', {
    extend: 'Ext.button.Button',

    text: 'Add',
    icon: 'resources/icons/plus.png',
    rowEditingColumn: 1,

    handler: function() {
        if(this.form) {
            this.form.getForm().reset();
            this.form.enable();
        }

        this.grid.getStore().insert(0, {}); // Insert row in grid
        this.grid.getSelectionModel().select(0); // select inserted row

        // Focus first input
        if(this.form) this.form.getComponent(0).getComponent(0).focus(); // Examines this container's items property and gets a direct child component of this container.
        else if(this.grid.getPlugin('rowediting')) this.grid.getPlugin('rowediting').startEdit(0, this.rowEditingColumn); // Starts editing the specified record & column
    },

    // TODO
    /*
    onRender: function(){

        this.grid = this.up('grid');
        this.form = this.grid.up().down('form');
        console.log(this.grid);
        console.log(this.form);


        this.callParent(arguments);
    },*/
    
    initComponent: function() {
        this.callParent(arguments);
    }
});
