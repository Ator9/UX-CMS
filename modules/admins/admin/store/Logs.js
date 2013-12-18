Ext.define('admins.store.Logs', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'logID', 'logID', 'task', 'comment', 'username', 'ip',
        { name: 'date_created', type: 'date', dateFormat: 'c' } // dateFormat fix explorer bug
    ],
    pageSize: 50, // Defaults to 25
    remoteSort: true, // Default: false (javascript sort)
    sorters: [{ property: 'logID', direction: 'DESC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsLog&_method=extGrid' // reader
        },
        reader: {
            type: 'json',
            root: 'data', // php response name (api: read)
            totalProperty: 'totalCount' // PagingToolbar (php response)
        }
    }
});
