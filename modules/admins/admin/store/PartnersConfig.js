Ext.define('admins.store.PartnersConfig', {
    extend: 'Ext.data.Store',
    
    fields: [ 'name', 'value', 'description' ], // Model
    pageSize: 999, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'name', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsPartnersConfig&_method=extGrid', // reader
            update: 'index.php?_class=adminsPartnersConfig&_method=extCreate' // writer (grid RowEditing)
        },
        reader: {
            root: 'data', // php response name (api: read)
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        },
        writer: {
            writeAllFields: true,
            root: 'data', // php submit name (api: destroy, update, create)
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
