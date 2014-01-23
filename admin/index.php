<?php
require(dirname(__FILE__).'/common/init.php');

$tree = getAdminTree(); // Get module list to build tree panel
foreach($tree as $values) $modules[] = $values['panel'];

require(ROOT.'/admin/common/header.extjs.php');
?>
<script>
var LOCAL = <? echo var_export(LOCAL); ?>;
Ext.Loader.setConfig({
    disableCaching: LOCAL
}); 

Ext.application({
    name: 'Admin',
    paths: { 'Ext.ux': 'resources/ux', 'Extensible': 'resources/ux/extensible/src' <? echo getAdminPaths(); ?> },
    
    launch: function() {
        Admin = this;
        Admin.modules = <? echo json_encode($modules); ?>;
        Admin.firstModule = (location.hash !== '') ? Ext.Array.indexOf(Admin.modules, location.hash.substr(1)) : <? echo (int) $GLOBALS['admin']['default_module']; ?>;
        Admin.loadedModules = []; // Fills with loaded modules
        
        Admin.cards = Ext.create('Ext.panel.Panel', { region: 'center', layout: 'card', margin: '5 0 5 0', border: false } );

        Admin.tree = Ext.create('Ext.tree.Panel', {
            region: 'west',
            title: 'Módulos',
            width: 160,
            margin: '5 5 5 0',
            collapsible: true, // True to make the panel collapsible and have an expand/collapse toggle Tool added into the header tool button area
            rootVisible: false, // Show root node
            root: { children: <? echo json_encode(array_values($tree)); ?> },
            fbar: [ <? echo getAdminTreeButtons(); ?> ], // Footer Bar
            listeners: {
                itemclick: function(view, record, item, index, e) {
                    if(Ext.Array.indexOf(Admin.loadedModules, index) === -1) {
                        Admin.loadedModules[Admin.loadedModules.length] = index;
                        Admin.cards.add( Ext.create(record.raw.panel+'.app', { title: record.raw.text }) );
                    }
                    Admin.cards.layout.setActiveItem(Ext.Array.indexOf(Admin.loadedModules, index));
                    location.hash = record.raw.panel;
                },
                afterrender: function(view, model) {
                    this.getSelectionModel().select(Admin.firstModule); // select firstModule
                    this.fireEvent('itemclick', this, this.getSelectionModel().getLastSelected(), '', Admin.firstModule); // activate firstModule
                }
            }
            <? if($GLOBALS['admin']['accounts_enabled']===true) getAdminAccounts(); ?>
        });

        // Global renderers/functions:
        Admin.getStatusIcon = function(value) { return '<span class="status-'+value+'"></span>'; }; // status-Y/N icons
        Admin.getModulesUrl = function(module) {
            var current_module = (module) ? '/'+module.$className.split('.')[0]+'/admin' : '';
            return '<? echo MODULES; ?>'+current_module;
        };
        Admin.Msg = function(msg, type) {
            var title = (type) ? 'OK :)' : 'Error :(';
            var icon  = (type) ? Ext.Msg.INFO : Ext.Msg.ERROR;
            Ext.Msg.show({ title: title, msg: msg, buttons: Ext.Msg.OK, icon: icon });
        }
    
        Ext.create('Ext.container.Viewport', {
            layout: 'border',
            items: [{
                title: '<? echo $GLOBALS['admin']['title']; ?>', // HTML is allowed
                region: 'north',
                border: false,
                tools: [{ type: 'close', handler: function(event, toolEl, panel) { location.href = 'login.php?logout=1'; } }]
            }, this.tree, this.cards ]
        });  
    }
});

// Check admin session (redirects if necessary):
Ext.Ajax.on('requestexception', function(conn, response, options, eOpts) {
    if(response.status === 401) window.location = 'login.php';
});
</script>
</head>
<body></body>
</html>
