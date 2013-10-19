/**
 * Search plugin
 *
 * @author Sebastián Gasparri
 * @version 09/05/2013 20:45:21
 *
 * Usage: 
 * this.tbar = [ Ext.create('Admin.extjs.Search', { store: this.store }) ];
 * this.tbar = [ Ext.create('Admin.extjs.Search', { store: this.store, columns: [ 'adminID', 'username' ] }) ];
 *
 */
 
Ext.define('Ext.ux.Search', {
    extend: 'Ext.toolbar.Toolbar',

    border: false,
    inputWidth: 200,
    paramName: 'search',
    columns: [], // Search columns. Empty = database index
    
    initComponent: function() {
        this.field = Ext.create('Ext.form.TwinTriggerField', {
            width          : this.inputWidth,
            trigger1Cls    : 'x-form-clear-trigger',
            trigger2Cls    : 'x-form-search-trigger',
            onTrigger1Click: Ext.bind(this.onTriggerClear, this),
            onTrigger2Click: Ext.bind(this.onTriggerSearch, this)
        });
        this.items = [ 'Search', this.field ];
        
        this.callParent(arguments);
    },
    
    // Clear function:
    onTriggerClear: function() {
        this.field.setValue('');
        this.field.focus();
        delete(this.store.getProxy().extraParams[this.paramName]);
        
        this.store.loadPage(1); // Reload
    },

    // Search function:
    onTriggerSearch: function() {
        var store = this.store;
        var proxy = store.getProxy();

        // Add extra params:
        proxy.extraParams['columns[]']    = this.columns;
        proxy.extraParams[this.paramName] = this.field.getValue();

        store.loadPage(1); // Reload
    },

    onRender: function(){
        // Install key map:
        new Ext.util.KeyMap({
            target: this.field.id,
            key: Ext.EventObject.ENTER,
            fn: this.onTriggerSearch,
            scope: this
        });
        
        this.callParent(arguments);
    }
});
