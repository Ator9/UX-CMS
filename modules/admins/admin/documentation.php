<?php
require(dirname(__FILE__).'/1nit.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>UX CMS - Documentation</title>
<link rel="stylesheet" type="text/css" href="<? echo MODULES; ?>/admins/admin/resources/documentation.css" />
</head>
<body id="top">

<div id="header"><h1>UX <span class="myadmin">CMS</span></h1></div>
<ul class="header">
    <li><a href="#top">Top</a></li>
    <li><a href="#links">Links</a></li>
    <li><a href="#require">Requirements</a></li>
    <li><a href="#intro">Introduction</a></li>
    <li><a href="#setup">Installation</a></li>
    <li><a href="#faq"><abbr title="Frequently Asked Questions"> FAQ</abbr></a></li>
    <li><a href="#extjs_components">Ext JS</a></li>
</ul>

<div id="body">
    <h2 id="links">Links</h2>
    <ul>
        <li><a href="https://github.com/Ator9/UX-CMS" target="_blank">Git repositories on Github</a></li>
        <li><a href="https://github.com/Ator9/UX-CMS/commits/master" target="_blank">Changelog</a></li>
        <li><a href="#">Donate</a></li>
    </ul>

    <h2 id="intro">Introduction</h2>
    <p>
        UX CMS can ... a
    </p>

    <h2 id="require">Requirements</h2>
    <ul>
        <li>
            <b>PHP</b> 5.3.0 or newer
            <ul>
                <li>To support uploading of ZIP files, you need the PHP <tt>zip</tt> extension.</li>
                <li>For proper support of multibyte strings (eg. UTF-8, which is
                    currently the default), you should install the mbstring and ctype
                    extensions.
                </li>
                <li>
                    You need GD2 support in PHP to display inline
                    thumbnails of JPEGs (&quot;image/jpeg: inline&quot;) with their
                    original aspect ratio
                </li>
            </ul>
        </li>
        <li><b>MySQL</b> 5.0 or newer</li>
    </ul>

    <h2 id="setup">Installation</h2>
    <ol><li><a href="#quick_install">Quick Install</a></li>
        <li><a href="#setup_script">Setup script usage</a></li>
        <li><a href="#linked-tables">phpMyAdmin configuration storage</a></li>
        <li><a href="#upgrading">Upgrading from an older version</a></li>
        <li><a href="#authentication_modes">Using authentication modes</a></li>
    </ol>

    <p class="important">
        phpMyAdmin does not apply any special security methods to the MySQL database
        server. It is still the system administrator's job to grant permissions on
        the MySQL databases properly. phpMyAdmin's &quot;Privileges&quot; page can
        be used for this.
    </p>

    <h2 id="faq">FAQ - Frequently Asked Questions</h2>
    <ul>
        <li><a href="#faqrobots">Default robots.txt</a></li>
    </ul>
    <h3 id="faqrobots">Default robots.txt</h3>
    <pre>
    User-agent: *
    Allow: /</pre>
    

    <h2 id="extjs_components">Ext JS</h2>
    <ul>
        <li><a href="#ext_componenets">Component List</a></li>
    </ul>
    <h3 id="ext_componenets">Component List | <a href="http://extjs.com/deploy/dev/docs/?class=Ext.Component" target="_blank">List@Sencha.com</a></h3>
    
    <pre>
    xtype            Class
    -------------    ------------------
    box              <a href="#!/api/Ext.BoxComponent" rel="Ext.BoxComponent" class="docClass">Ext.BoxComponent</a>
    button           <a href="#!/api/Ext.Button" rel="Ext.Button" class="docClass">Ext.Button</a>
    buttongroup      <a href="#!/api/Ext.ButtonGroup" rel="Ext.ButtonGroup" class="docClass">Ext.ButtonGroup</a>
    colorpalette     <a href="#!/api/Ext.ColorPalette" rel="Ext.ColorPalette" class="docClass">Ext.ColorPalette</a>
    component        <a href="#!/api/Ext.Component" rel="Ext.Component" class="docClass">Ext.Component</a>
    container        <a href="#!/api/Ext.Container" rel="Ext.Container" class="docClass">Ext.Container</a>
    cycle            <a href="#!/api/Ext.CycleButton" rel="Ext.CycleButton" class="docClass">Ext.CycleButton</a>
    dataview         <a href="#!/api/Ext.DataView" rel="Ext.DataView" class="docClass">Ext.DataView</a>
    datepicker       <a href="#!/api/Ext.DatePicker" rel="Ext.DatePicker" class="docClass">Ext.DatePicker</a>
    editor           <a href="#!/api/Ext.Editor" rel="Ext.Editor" class="docClass">Ext.Editor</a>
    editorgrid       <a href="#!/api/Ext.grid.EditorGridPanel" rel="Ext.grid.EditorGridPanel" class="docClass">Ext.grid.EditorGridPanel</a>
    flash            <a href="#!/api/Ext.FlashComponent" rel="Ext.FlashComponent" class="docClass">Ext.FlashComponent</a>
    grid             <a href="#!/api/Ext.grid.GridPanel" rel="Ext.grid.GridPanel" class="docClass">Ext.grid.GridPanel</a>
    listview         Ext.ListView
    multislider      <a href="#!/api/Ext.slider.MultiSlider" rel="Ext.slider.MultiSlider" class="docClass">Ext.slider.MultiSlider</a>
    panel            <a href="#!/api/Ext.Panel" rel="Ext.Panel" class="docClass">Ext.Panel</a>
    progress         <a href="#!/api/Ext.ProgressBar" rel="Ext.ProgressBar" class="docClass">Ext.ProgressBar</a>
    propertygrid     <a href="#!/api/Ext.grid.PropertyGrid" rel="Ext.grid.PropertyGrid" class="docClass">Ext.grid.PropertyGrid</a>
    slider           <a href="#!/api/Ext.slider.SingleSlider" rel="Ext.slider.SingleSlider" class="docClass">Ext.slider.SingleSlider</a>
    spacer           <a href="#!/api/Ext.Spacer" rel="Ext.Spacer" class="docClass">Ext.Spacer</a>
    splitbutton      <a href="#!/api/Ext.SplitButton" rel="Ext.SplitButton" class="docClass">Ext.SplitButton</a>
    tabpanel         <a href="#!/api/Ext.TabPanel" rel="Ext.TabPanel" class="docClass">Ext.TabPanel</a>
    treepanel        <a href="#!/api/Ext.tree.TreePanel" rel="Ext.tree.TreePanel" class="docClass">Ext.tree.TreePanel</a>
    viewport         Ext.ViewPort
    window           <a href="#!/api/Ext.Window" rel="Ext.Window" class="docClass">Ext.Window</a>

    Toolbar components
    ---------------------------------------
    paging           <a href="#!/api/Ext.PagingToolbar" rel="Ext.PagingToolbar" class="docClass">Ext.PagingToolbar</a>
    toolbar          <a href="#!/api/Ext.Toolbar" rel="Ext.Toolbar" class="docClass">Ext.Toolbar</a>
    tbbutton         Ext.Toolbar.Button        (deprecated; use button)
    tbfill           <a href="#!/api/Ext.Toolbar.Fill" rel="Ext.Toolbar.Fill" class="docClass">Ext.Toolbar.Fill</a>
    tbitem           <a href="#!/api/Ext.Toolbar.Item" rel="Ext.Toolbar.Item" class="docClass">Ext.Toolbar.Item</a>
    tbseparator      <a href="#!/api/Ext.Toolbar.Separator" rel="Ext.Toolbar.Separator" class="docClass">Ext.Toolbar.Separator</a>
    tbspacer         <a href="#!/api/Ext.Toolbar.Spacer" rel="Ext.Toolbar.Spacer" class="docClass">Ext.Toolbar.Spacer</a>
    tbsplit          Ext.Toolbar.SplitButton   (deprecated; use splitbutton)
    tbtext           <a href="#!/api/Ext.Toolbar.TextItem" rel="Ext.Toolbar.TextItem" class="docClass">Ext.Toolbar.TextItem</a>

    Menu components
    ---------------------------------------
    menu             <a href="#!/api/Ext.menu.Menu" rel="Ext.menu.Menu" class="docClass">Ext.menu.Menu</a>
    colormenu        <a href="#!/api/Ext.menu.ColorMenu" rel="Ext.menu.ColorMenu" class="docClass">Ext.menu.ColorMenu</a>
    datemenu         <a href="#!/api/Ext.menu.DateMenu" rel="Ext.menu.DateMenu" class="docClass">Ext.menu.DateMenu</a>
    menubaseitem     <a href="#!/api/Ext.menu.BaseItem" rel="Ext.menu.BaseItem" class="docClass">Ext.menu.BaseItem</a>
    menucheckitem    <a href="#!/api/Ext.menu.CheckItem" rel="Ext.menu.CheckItem" class="docClass">Ext.menu.CheckItem</a>
    menuitem         <a href="#!/api/Ext.menu.Item" rel="Ext.menu.Item" class="docClass">Ext.menu.Item</a>
    menuseparator    <a href="#!/api/Ext.menu.Separator" rel="Ext.menu.Separator" class="docClass">Ext.menu.Separator</a>
    menutextitem     <a href="#!/api/Ext.menu.TextItem" rel="Ext.menu.TextItem" class="docClass">Ext.menu.TextItem</a>

    Form components
    ---------------------------------------
    form             <a href="#!/api/Ext.form.FormPanel" rel="Ext.form.FormPanel" class="docClass">Ext.form.FormPanel</a>
    checkbox         <a href="#!/api/Ext.form.Checkbox" rel="Ext.form.Checkbox" class="docClass">Ext.form.Checkbox</a>
    checkboxgroup    <a href="#!/api/Ext.form.CheckboxGroup" rel="Ext.form.CheckboxGroup" class="docClass">Ext.form.CheckboxGroup</a>
    combo            <a href="#!/api/Ext.form.ComboBox" rel="Ext.form.ComboBox" class="docClass">Ext.form.ComboBox</a>
    compositefield   <a href="#!/api/Ext.form.CompositeField" rel="Ext.form.CompositeField" class="docClass">Ext.form.CompositeField</a>
    datefield        <a href="#!/api/Ext.form.DateField" rel="Ext.form.DateField" class="docClass">Ext.form.DateField</a>
    displayfield     <a href="#!/api/Ext.form.DisplayField" rel="Ext.form.DisplayField" class="docClass">Ext.form.DisplayField</a>
    field            <a href="#!/api/Ext.form.Field" rel="Ext.form.Field" class="docClass">Ext.form.Field</a>
    fieldset         <a href="#!/api/Ext.form.FieldSet" rel="Ext.form.FieldSet" class="docClass">Ext.form.FieldSet</a>
    hidden           <a href="#!/api/Ext.form.Hidden" rel="Ext.form.Hidden" class="docClass">Ext.form.Hidden</a>
    htmleditor       <a href="#!/api/Ext.form.HtmlEditor" rel="Ext.form.HtmlEditor" class="docClass">Ext.form.HtmlEditor</a>
    label            <a href="#!/api/Ext.form.Label" rel="Ext.form.Label" class="docClass">Ext.form.Label</a>
    numberfield      <a href="#!/api/Ext.form.NumberField" rel="Ext.form.NumberField" class="docClass">Ext.form.NumberField</a>
    radio            <a href="#!/api/Ext.form.Radio" rel="Ext.form.Radio" class="docClass">Ext.form.Radio</a>
    radiogroup       <a href="#!/api/Ext.form.RadioGroup" rel="Ext.form.RadioGroup" class="docClass">Ext.form.RadioGroup</a>
    textarea         <a href="#!/api/Ext.form.TextArea" rel="Ext.form.TextArea" class="docClass">Ext.form.TextArea</a>
    textfield        <a href="#!/api/Ext.form.TextField" rel="Ext.form.TextField" class="docClass">Ext.form.TextField</a>
    timefield        <a href="#!/api/Ext.form.TimeField" rel="Ext.form.TimeField" class="docClass">Ext.form.TimeField</a>
    trigger          <a href="#!/api/Ext.form.TriggerField" rel="Ext.form.TriggerField" class="docClass">Ext.form.TriggerField</a>
    twintrigger      <a href="#!/api/Ext.form.TwinTriggerField" rel="Ext.form.TwinTriggerField" class="docClass">Ext.form.TwinTriggerField</a>

    Chart components
    ---------------------------------------
    chart            <a href="#!/api/Ext.chart.Chart" rel="Ext.chart.Chart" class="docClass">Ext.chart.Chart</a>
    barchart         <a href="#!/api/Ext.chart.BarChart" rel="Ext.chart.BarChart" class="docClass">Ext.chart.BarChart</a>
    cartesianchart   <a href="#!/api/Ext.chart.CartesianChart" rel="Ext.chart.CartesianChart" class="docClass">Ext.chart.CartesianChart</a>
    columnchart      <a href="#!/api/Ext.chart.ColumnChart" rel="Ext.chart.ColumnChart" class="docClass">Ext.chart.ColumnChart</a>
    linechart        <a href="#!/api/Ext.chart.LineChart" rel="Ext.chart.LineChart" class="docClass">Ext.chart.LineChart</a>
    piechart         <a href="#!/api/Ext.chart.PieChart" rel="Ext.chart.PieChart" class="docClass">Ext.chart.PieChart</a>

    Store xtypes
    ---------------------------------------
    arraystore       <a href="#!/api/Ext.data.ArrayStore" rel="Ext.data.ArrayStore" class="docClass">Ext.data.ArrayStore</a>
    directstore      <a href="#!/api/Ext.data.DirectStore" rel="Ext.data.DirectStore" class="docClass">Ext.data.DirectStore</a>
    groupingstore    <a href="#!/api/Ext.data.GroupingStore" rel="Ext.data.GroupingStore" class="docClass">Ext.data.GroupingStore</a>
    jsonstore        <a href="#!/api/Ext.data.JsonStore" rel="Ext.data.JsonStore" class="docClass">Ext.data.JsonStore</a>
    simplestore      Ext.data.SimpleStore      (deprecated; use arraystore)
    store            <a href="#!/api/Ext.data.Store" rel="Ext.data.Store" class="docClass">Ext.data.Store</a>
    xmlstore         <a href="#!/api/Ext.data.XmlStore" rel="Ext.data.XmlStore" class="docClass">Ext.data.XmlStore</a>
    </pre>
</div>
<ul id="footer">
    <li>Copyright 2013 <a href="https://github.com/Ator9/UX-CMS" target="_blank">UX CMS</a></li>
</ul>

</body>
</html>
