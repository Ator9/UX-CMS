Ext.define('admins.store.Admins', {
    extend: 'Ext.data.Store',
    //idProperty: 'adminID',
    fields: [ // Model
        'adminID', 'roleID', 'username', 'email', 'firstname', 'lastname','superuser', 'active',
        { name: 'last_login', type: 'date', dateFormat: 'c' } // dateFormat fix explorer bug
    ],
    pageSize: 50, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'adminID', direction: 'DESC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: '1nit.php?_class=Admins&_method=extGrid',
            destroy: '1nit.php?_class=Admins&_method=extDelete'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty: 'totalCount' // PagingToolbar
        },
        writer: {
            type: 'json',
            root: 'data',
            writeAllFields: true,
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
