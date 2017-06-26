/**
 * Filesystem Panel
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Example:
 * Ext.create('Ext.ux.Filesystem', { title: Admin.t('Files'), upload_dir: 'upload/products', parent_class: 'className' }),
 *
 */

Ext.define('Ext.ux.Filesystem', {
    extend: 'Ext.grid.Panel',

    border: false,
    upload_dir:   '', // files read path
    parent_class: '', // php class with "ExtjsFilesystem" trait

    initComponent: function() {

        this.store = this.getStore();
        this.store.getProxy().extraParams = { upload_dir: this.upload_dir };
        this.store.load();

        this.columns = [
            { header: Admin.t('Name'), dataIndex: 'path', width: 250, editor: { allowBlank: false } },
            { header: Admin.t('Size'), dataIndex: 'size', width: 100, align: 'right' },
            { header: Admin.t('Path'), dataIndex: 'linkpath', flex: 1 },
            { header: Admin.t('Date Created'), dataIndex: 'timestamp', xtype: 'datecolumn', format: 'd/m/Y H:i:s', width: 120 }
        ];

        this.tbar = [{
            text: Admin.t('Add')+'...',
            icon: 'resources/icons/plus.png',
            scope: this,
            handler: this.addFile,
            store: this.store
        }, '-', Ext.create('Ext.ux.GridRowDelete') ];

        this.plugins = [ Ext.create('Ext.grid.plugin.RowEditing') ];
        this.viewConfig = { enableTextSelection: true };
        this.bbar       = Ext.create('Ext.toolbar.Paging', { store: this.store, displayInfo: true });
        this.listeners  = {
            edit: function(editor, context, eOpts) {
                context.store.sync({ // Synchronizes the store with its proxy (new, updated and deleted records)
                    failure: function(form, action) {
                        var json = JSON.parse(form.operations[0].getResponse().responseText);
                        Admin.Msg(json.message, false);
                    }
                });
                context.store.reload(); // bug cuando se renombra y se intenta borrar (queda seleccionado raro)
            },
            itemclick: {
                fn: function(view, record, item, index, e) {
                    this.down('#gridDeleteButton').setDisabled(false); // Enable delete button
                }
            }
        };

        this.callParent(arguments);
    },

    getStore: function() {

        return Ext.create('Ext.data.Store', {
            fields: [ // Model
                'name', 'type', 'size', 'path', 'linkpath', 'dirname', 'extension',
                { name: 'timestamp', type: 'date', dateFormat: 'timestamp' } // It is strongly recommended that you always specify an explicit date format
            ],
            pageSize: 999, // Defaults to 25
            remoteSort: false, // Default false (javascript sort)
            sorters: [{ property: 'name', direction: 'ASC' }],
            proxy: {
                type: 'ajax',
                simpleSortMode: true, // Default false (enable multiple sorts)
                api: {
                    read: 'index.php?_class='+this.parent_class+'&_method=extGridFilesystem', // reader
                    update: 'index.php?_class='+this.parent_class+'&_method=extGridFilesystemRename', // writer (grid RowEditing)
                    destroy: 'index.php?_class='+this.parent_class+'&_method=extGridFilesystemDelete' // writer
                },
                reader: {
                    rootProperty: 'data', // php response name (api: read)
                    totalProperty: 'totalCount' // PagingToolbar (php response name)
                },
                writer: {
                    writeAllFields: true,
                    rootProperty: 'data', // extjs 6 - php submit name (api: destroy, update, create)
                    encode: true // True to send record data as a JSON encoded HTTP parameter named by the root configuration.
                }
            }
        });
    },

    addFile: function() {

        return Ext.create('Ext.Window', {
            title: Admin.t('Files'),
            width: 400,
            border: false,
            store: this.store,
            closeAction: 'hide',
            modal: true,
            items: {
                xtype: 'form',
                url: 'index.php?_class='+this.parent_class+'&_method=extGridFilesystemUpload',
                bodyPadding: 10,
                items: [
                    { name: 'upload_dir', xtype: 'hidden', value: this.upload_dir },
                    {
                        xtype: 'filefield',
                        name: 'files[]',
                        anchor: '100%',
                        allowBlank: false,
                        listeners: {
                            afterrender: function () {
                                this.fileInputEl.set({ multiple: true });
                            }
                        }
                    }
                ],
                buttons: ['->', {
                    text: Admin.t('Upload'),
                    icon: 'resources/icons/drive-upload.png',
                    handler: function() {
                        var form = this.up('form').getForm();
                        if(form.isValid()) {
                            form.submit({
                                waitMsg: 'Subiendo...',
                                scope: this,
                                success: function(form, action) {
                                    this.up('window').store.reload();
                                    this.up('window').hide();
                                },
                                failure: function(form, action) {
                                    this.up('window').store.reload();
                                    Admin.Msg('Error: '+action.result.message, false);
                                }
                            });
                        }
                        else Admin.Msg('Please complete required fields', false);
                    }
                }]
            }
        }).show();
    }
});
