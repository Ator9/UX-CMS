/**
 * Grid Search plugin
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage: 
 * Ext.create('Ext.ux.GridSearch') // Automatic store set
 * Ext.create('Ext.ux.GridSearch', { store: this.store })
 * Ext.create('Ext.ux.GridSearch', { store: this.store, columns: [ 'adminID', 'username' ] })
 *
 */
 
Ext.define('Ext.ux.GridSearch', {
    extend: 'Ext.toolbar.Toolbar',

    border: false,
    inputWidth: 200,
    paramName: 'search',
    columns: [], // Search columns. Empty = database index
    tooltip: '', // Custom textfield tooltip. If not set, it will use columns data.
    
    initComponent: function() {
        this.field = Ext.create('Ext.form.TwinTriggerField', {
            width          : this.inputWidth,
            inputAttrTpl   : 'data-qtip="'+((this.tooltip != '') ? this.tooltip : this.columns)+'"',
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

    onRender: function() {
        if(!this.store) this.store = this.up('grid').getStore(); // Uses grid store if not set
    
        // Install key map ENTER:
        new Ext.util.KeyMap({
            target: this.field.id,
            key: 13, // ENTER
            fn: this.onTriggerSearch,
            scope: this
        });
        
        this.callParent(arguments);
    }
});
