<?php
require(__DIR__.'/init.php');

require(ROOT.'/admin/common/header.bootstrap.php');
?>
<link rel="stylesheet" type="text/css" href="<? echo MODULES; ?>/admins/admin/resources/documentation.css" />
</head>
<body id="top">

<div id="header"><h1>Git <span class="myadmin">Help</span></h1></div>
<div id="body">
    <h2>Commands</h2>
    <ul>
        <li>
            <b>Clone Repository</b>
            <pre>git clone https://github.com/Ator9/CMS my_project_folder/</pre>
        </li>
        <li>
            <b>Pull Changes</b>
            <pre>git pull</pre>
        </li>
        <li>
            <b>Add NEW file (not tracked)</b>
            <pre>git add file.xxx<br>git commit -m "comment"<br>git push</pre>
        </li>
        <li>
            <b>Commit all modified files (tracked)</b>
            <pre>git commit -am "comment"<br>git push</pre>
        </li>
        <li>
            <b>Reset file changes</b>
            <pre>git checkout -- file.xxx</pre>
        </li>
        <li>
            <b>Show Status (changes)</b>
            <pre>git status</pre>
        </li>
        <li>
            <b>View Log</b>
            <pre>git log</pre>
        </li>
    </ul>
    <h2>Remotes</h2>
    <ul>
        <li>
            <b>Add remote</b>
            <pre>git remote add framework /path/project.git</pre>
        </li>
        <li>
            <b>Pull from remote</b>
            <pre>git pull framework master</pre>
        </li>
        <li>
            <b>Push to remote</b>
            <pre>git push framework master</pre>
        </li>
        <li>
            <b>Remove remote</b>
            <pre>git remote rm framework</pre>
        </li>
    </ul>
    <h2>Config</h2>
    <ul>
        <li>
            <b>Ignore chmod</b>
            <pre>git config core.fileMode false</pre>
        </li>
        <li>
            <b>Set User</b>
            <pre>git config user.email "email@email.com"</pre>
        </li>
    </ul>
</div>
<ul id="footer">
    <li>© Copyright 2013-<? echo date('Y'); ?> <a href="https://github.com/Ator9/UX-CMS" target="_blank">UX CMS</a></li>
</ul>
</body>
</html>
