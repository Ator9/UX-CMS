Ext.define('admins.store.Roles', {
    extend: 'Ext.data.Store',
    fields: [ 'roleID', 'name', 'permission' ], // Model
    pageSize: 999, // We need "infinite" to show all options in combobox (Defaults to 25)
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'roleID', direction: 'DESC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            //create: '1nit.php',
            read: '1nit.php?_class=AdminsRoles&_method=extGrid',
            //update: '1nit.php?_class=Admins&_method=extUpdate',
            destroy: '1nit.php?_class=AdminsRoles&_method=extDelete'
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
