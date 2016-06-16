Ext.define('admins.store.AdminsList', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'adminID', 'username', 'firstname', 'lastname', 'email'
    ],
    pageSize: 999, // We need "infinite" to show all options in combobox (Defaults to 25)
    remoteSort: false, // Default false (javascript sort)
    sorters: [{ property: 'username', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsAdmin&_method=extAdminsList' // reader
        },
        reader: {
            rootProperty: 'data', // php response name
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        }
    }
});
