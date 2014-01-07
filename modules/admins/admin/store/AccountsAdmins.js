Ext.define('admins.store.AccountsAdmins', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'adminID', 'username',
        { name: 'last_login', type: 'date', dateFormat: 'c' } // It is strongly recommended that you always specify an explicit date format
    ],
    pageSize: 25, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'username', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsAccountsAdmins&_method=extGrid', // reader
            destroy: 'index.php?_class=adminsAccountsAdmins&_method=extDelete' // writer
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
