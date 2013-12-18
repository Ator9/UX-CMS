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
            read: 'index.php?_class=adminsAccounts&_method=extGrid', // reader
            create: 'index.php?_class=adminsAccounts&_method=extCreate', // writer (grid RowEditing)
            update: 'index.php?_class=adminsAccounts&_method=extCreate', // writer (grid RowEditing)
            destroy: 'index.php?_class=adminsAccounts&_method=extDelete' // writer
        },
        reader: {
            type: 'json',
            root: 'data', // php response name (api: read)
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        },
        writer: {
            type: 'json',
            root: 'data', // php submit name (api: destroy, update, create)
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
