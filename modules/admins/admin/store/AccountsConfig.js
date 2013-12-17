Ext.define('admins.store.AccountsConfig', {
    extend: 'Ext.data.Store',
    
    fields: [ 'name', 'value' ], // Model
    pageSize: 999, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'name', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsAccountsConfig&_method=extGridConfigs' // reader
        },
        reader: {
            type: 'json',
            root: 'data', // php response name
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        }
    }
});
