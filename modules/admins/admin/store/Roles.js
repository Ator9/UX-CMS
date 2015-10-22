Ext.define('admins.store.Roles', {
    extend: 'Ext.data.Store',
    
    fields: [ 'roleID', 'name', 'permission' ], // Model
    pageSize: 999, // We need "infinite" to show all options in combobox (Defaults to 25)
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'name', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsRoles&_method=extGrid', // reader
            destroy: 'index.php?_class=adminsRoles&_method=extDelete' // writer
        },
        reader: {
            root: 'data', // php response name (api: read)
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        },
        writer: {
            writeAllFields: true,
            root: 'data', // php submit name (api: destroy, update, create)
            rootProperty: 'data', // extjs 6 - php submit name (api: destroy, update, create)
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
