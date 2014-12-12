Ext.define('admins.store.Partners', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'partnerID', 'name', 'active', 
        { name: 'date_created', type: 'date', dateFormat: 'c' } // It is strongly recommended that you always specify an explicit date format
    ],
    pageSize: 50, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'name', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsPartners&_method=extGrid', // reader
            create: 'index.php?_class=adminsPartners&_method=extCreate', // writer (grid RowEditing)
            update: 'index.php?_class=adminsPartners&_method=extCreate', // writer (grid RowEditing)
            destroy: 'index.php?_class=adminsPartners&_method=extDelete' // writer
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
