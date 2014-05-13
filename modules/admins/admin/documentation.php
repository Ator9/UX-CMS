<?php
require(dirname(__FILE__).'/init.php');

require(ROOT.'/admin/common/header.bootstrap.php');
?>
<link rel="stylesheet" type="text/css" href="<? echo MODULES; ?>/admins/admin/resources/documentation.css" />
</head>
<body id="top">

<div id="header"><h1>UX <span class="myadmin">CMS</span></h1></div>
<ul class="header">
    <li><a href="#top">Top</a></li>
    <li><a href="#php">Framework Hints</a></li>
    <li><a href="#git">Git Commands</a></li>
    <li><a href="#extjs">Ext JS</a></li>
    <li><a href="#links">Links</a></li>
</ul>

<div id="body">
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
            <b>External URLs - http://www.example.com (HOST)</b>
            <pre>HOST<br>ADMIN (/admin)<br>MODULES (/modules)<br>RESOURCES (/resources)<br>UPLOAD (/upload)</pre>
        </li>
        <li>
            <b>Internal Paths - /var/www/example.com (ROOT)</b>
            <pre>ROOT<br>COMMON (/common)<br>INCLUDES (/includes)</pre>
        </li>
        <li>
            <b>Database</b>
            <pre>DB_HOST<br>DB_USER<br>DB_PASS<br>DB_NAME</pre>
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

    <h2 id="git">Git Commands</h2>
    <ul>
        <li>
            <b>Clone Repository</b>
            <pre>$ git clone https://github.com/Ator9/CMS my_project_folder/</pre>
        </li>
        <li>
            <b>Pull Changes</b>
            <pre>(@project_folder) $ git pull</pre>
        </li>
        <li>
            <b>Commit NEW file (not tracked)</b>
            <pre>(@project_folder) $ git add file.xxx<br>(@project_folder) $ git commit -m "comment"<br>(@project_folder) $ git push</pre>
        </li>
        <li>
            <b>Commit all modified files (tracked)</b>
            <pre>(@project_folder) $ git commit -a -m "comment"<br>(@project_folder) $ git push</pre>
        </li>
        <li>
            <b>Reset single file changes</b>
            <pre>(@project_folder) $ git checkout -- file.xxx</pre>
        </li>
        <li>
            <b>Show Status (changes)</b>
            <pre>(@project_folder) $ git status</pre>
        </li>
        <li>
            <b>View Logs (GUI)</b>
            <pre>$ sudo apt-get install gitk<br>(@project_folder) $ gitk</pre>
        </li>
        <li>
            <b>Config - Ignore chmod changes</b>
            <pre>(@project_folder) $ git config core.fileMode false</pre>
        </li>
        <li>
            <b>Config - Set User (push requirement)</b>
            <pre>(@project_folder) $ git config user.email "email@email.com"</pre>
        </li>
    </ul>

    <? /*
    <p class="important">
        phpMyAdmin does not apply any special security methods to the MySQL database
        server. It is still the system administrator's job to grant permissions on
        the MySQL databases properly. phpMyAdmin's &quot;Privileges&quot; page can
        be used for this.
    </p>
    */?>
    
    <h2 id="extjs">Ext JS</h2>
    <ul>
        <li><a href="http://docs.sencha.com/extjs/" target="_blank">Documentation</a></li>
        <li><a href="http://extjs.com/deploy/dev/docs/?class=Ext.Component" target="_blank">Component List</a></li>
    </ul>
    
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
