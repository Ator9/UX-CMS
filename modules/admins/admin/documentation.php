<?php
require(__DIR__.'/init.php');

require(ROOT.'/admin/common/header.bootstrap.php');
?>
<link rel="stylesheet" type="text/css" href="<? echo MODULES; ?>/admins/admin/resources/documentation.css" />
</head>
<body id="top">

<div id="header"><h1>UX <span class="myadmin">CMS</span></h1></div>
<ul class="header">
    <li><a href="#top">Top</a></li>
    <li><a href="#db">Database Class</a></li>
    <li><a href="#php">Framework Hints</a></li>
    <li><a href="#links">Links</a></li>
</ul>

<div id="body">
    <h2 id="db">Database Class</h2>
    <ul>
        <li><b>Class Creation</b>
            <pre>
class myClass extends Conn
{
    public $_table  = '';      // Table name
    public $_index  = '';      // Table primary Key
}</pre>
        </li>
        <li><b>Simple Query</b>
            <pre>$conn = new myClass();
            
$res = $conn->query('SELECT * FROM admins');
if($res->num_rows > 0)
{
    while($row = $res->fetch_assoc())
    {
        vd($row);
    }
}</pre>
        </li>
        <li><b>Update</b>
            <pre>$conn = new myClass();
            
if($conn->get( $_GET['key']) )
{
    $conn->firstname = 'name';
    $conn->lastname  = 'lastname';
    if($conn->update())
    {
        echo 'Record updated successfully ID: '.$conn->getID();
    }
    else echo 'Error while trying to update';
}
else echo 'Record not found';</pre>
        </li>
        <li><b>Insert</b>
            <pre>$conn = new myClass();
            
$conn->firstname = 'name';
$conn->lastname  = 'lastname';
if($conn->insert())
{
    echo 'Record inserted successfully. ID: '.$conn->getID();
}
else echo 'Error while trying to insert';</pre>
        </li>
        <li><b>Save (Update or Insert)</b> If primary key exists, record is updated. If primary key is not set, inserts new record.
            <pre>$conn = new myClass();
            
$conn->get($_POST['key']); // Get primary key
$conn->set($_POST)) // Set all data
if($conn->save())
{
    echo 'Record saved successfully. ID: '.$conn->getID();
}
else echo 'Error while trying to save';</pre>
        </li>
    </ul>
    
    <h2 id="php">Framework Hints</h2>
    <ul>
        <li><a href="#phpconstants">Site Constants</a></li>
        <li><a href="#phpadminsglobals">Admin GLOBALS</a></li>
        <li><a href="#phprobots">Default robots.txt</a></li>
    </ul>
    <h3 id="phpconstants">Site Constants</h3>
    <ul>
        <li>
            <b>Environment - Local / Online</b>
            <pre>LOCAL (true | false)</pre>
        </li>
        <li>
            <b>Database</b>
            <pre>DB_HOST<br>DB_USER<br>DB_PASS<br>DB_NAME</pre>
        </li>
        <li>
            <b>External URLs - http://www.example.com (HOST)</b>
            <pre>HOST<br>ADMIN (/admin)<br>MODULES (/modules)<br>RESOURCES (/resources)<br>UPLOAD (/upload)</pre>
        </li>
        <li>
            <b>Internal Paths - /var/www/example.com (ROOT)</b>
            <pre>ROOT<br>COMMON (/common)<br>INCLUDES (/includes)</pre>
        </li>
    </ul>
    <h3 id="phpadminsglobals">Admin GLOBALS</h3>
    <ul>
        <li>
            <b>Misc</b>
            <pre>$GLOBALS['admin']['title']</pre>
        </li>
        <li>
            <b>Logged Admin Data</b>
            <pre>$GLOBALS['admin']['data']<br>$GLOBALS['admin']['data']['adminID']<br>$GLOBALS['admin']['data']['roleID']<br>$GLOBALS['admin']['data']['superuser']<br>...</pre>
        </li>
        <li>
            <b>Logged Admin Partners</b>
            <pre>$GLOBALS['admin']['data']['partners']<br>$GLOBALS['admin']['data']['partnerID']</pre>
        </li>
    </ul>
    <h3 id="phprobots">Default robots.txt</h3>
    <pre>User-agent: *<br>Allow: /</pre>

    <? /*
    <p class="important">
        phpMyAdmin does not apply any special security methods to the MySQL database
        server. It is still the system administrator's job to grant permissions on
        the MySQL databases properly. phpMyAdmin's &quot;Privileges&quot; page can
        be used for this.
    </p>
    */?>
    
    <h2 id="links">Links</h2>
    <ul>
        <li><a href="https://github.com/Ator9/UX-CMS" target="_blank">Git repositories on Github</a></li>
        <li><a href="https://github.com/Ator9/UX-CMS/commits/master" target="_blank">Changelog</a></li>
    </ul>
</div>
<ul id="footer">
    <li>© Copyright 2013-<? echo date('Y'); ?> <a href="https://github.com/Ator9/UX-CMS" target="_blank">UX CMS</a></li>
</ul>
</body>
</html>
