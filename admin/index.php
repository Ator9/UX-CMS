<?php
require(dirname(__FILE__).'/common/1nit.php');

$tree = getAdminTree(); // Traigo los modulos para armar el arbol del admin
foreach($tree as $values) { 
    $modules[] = $values['panel'];
    if($values['panel'] != 'admins') $paths.= ", '".$values['panel']."': '../modules/".$values['panel']."/admin'";
}

require(dirname(__FILE__).'/common/header.extjs.php');
?>
<script>
Ext.Loader.setConfig({
    disableCaching: <? echo (LOCAL) ? 'true' : 'false'; ?>
}); 

Ext.application({
    name: 'Admin',
    appFolder: 'admin', // The path to the directory which contains application's classes. Defaults to: 'app'
    paths: { 'Ext.ux': 'resources/ux'<? echo $paths; ?> },
    
    launch: function() {
        Admin = this;
        Admin.modules = <? echo json_encode($modules); ?>;
        Admin.firstModule = (location.hash!='') ? Ext.Array.indexOf(Admin.modules, location.hash.substr(1)) : <? echo (int) $GLOBALS['admin']['default_module']; ?>;
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
                itemclick: {
                    fn: function(view, record, item, index, e) {
                        if(Ext.Array.indexOf(Admin.loadedModules, index) == -1) {
                            Admin.loadedModules[Admin.loadedModules.length] = index;
                            Admin.cards.add( Ext.create(record.raw.panel+'.app', { title: record.raw.text }) );
                        }
                        Admin.cards.layout.setActiveItem(Ext.Array.indexOf(Admin.loadedModules, index));
                        location.hash = record.raw.panel;
                    }
                },
                afterrender: {
                    fn: function(view, model) {
                        this.getSelectionModel().select(Admin.firstModule); // select firstModule
                        this.fireEvent('itemclick', this, this.getSelectionModel().getLastSelected(), '', Admin.firstModule); // activate firstModule
                    }
                }
            }
        });

        // Global Renderers:
        Admin.getStatusIcon = function(value) { return '<span class="status-'+value+'"></span>'; }; // status-Y/N icons
    
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
</script>
</head>
<body></body>
</html>
