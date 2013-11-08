Ext.define('admins.store.Accounts', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'accountID', 'name', 'active', 
        { name: 'date_created', type: 'date', dateFormat: 'c' } // dateFormat fix explorer bug'
    ],
    pageSize: 50, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'name', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=AdminsAccounts&_method=extGrid', // reader
            destroy: 'index.php?_class=AdminsAccounts&_method=extDelete' // writer
        },
        reader: {
            type: 'json',
            root: 'data', // php response name
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        },
        writer: {
            type: 'json',
            root: 'data', // php submit name (destroy)
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
