Ext.define('admins.store.PartnersAdmins', {
    extend: 'Ext.data.Store',
    
    fields: [ // Model
        'adminID', 'username', 'email',
        { name: 'last_login', type: 'date', dateFormat: 'c' } // It is strongly recommended that you always specify an explicit date format
    ],
    pageSize: 25, // Defaults to 25
    remoteSort: true, // Default false (javascript sort)
    sorters: [{ property: 'username', direction: 'ASC' }],
    proxy: {
        type: 'ajax',
        simpleSortMode: true, // Default false (enable multiple sorts)
        api: {
            read: 'index.php?_class=adminsPartnersAdmins&_method=extGrid', // reader
            destroy: 'index.php?_class=adminsPartnersAdmins&_method=extDelete' // writer
        },
        reader: {
            root: 'data', // php response name (api: read)
            totalProperty: 'totalCount' // PagingToolbar (php response name)
        },
        writer: {
            writeAllFields: true,
            root: 'data', // extjs 4/5 - php submit name (api: destroy, update, create)
            rootProperty: 'data', // extjs 6 - php submit name (api: destroy, update, create)
            encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
        }
    }
});
