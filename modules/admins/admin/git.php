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
            <b>Pull Changes</b>
            <pre>git pull</pre>
        </li>
        <li>
            <b>Commit NEW file (not tracked)</b>
            <pre>git add file.xxx<br>git commit -m "comment"</pre>
        </li>
        <li>
            <b>Commit all modified files (tracked)</b>
            <pre>git commit -am "comment"</pre>
        </li>
        <li>
            <b>Push / Push Online</b>
            <pre>git push<br>git push online master</pre>
        </li>
    </ul>
    <h2>Extras</h2>
    <ul>
        <li>
            <b>Reset file changes</b>
            <pre>git checkout -- file.xxx</pre>
        </li>
        <li>
            <b>Show Status (changes)</b>
            <pre>git status</pre>
        </li>
        <li>
            <b>View Log / Shortlog</b>
            <pre>git log<br>git shortlog</pre>
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
            <pre>git config user.name "Your Name"<br>git config user.email "your@email.com"</pre>
        </li>
    </ul>
</div>
<ul id="footer">
    <li>© Copyright 2013-<? echo date('Y'); ?> <a href="https://github.com/Ator9/UX-CMS" target="_blank">UX CMS</a></li>
</ul>
</body>
</html>
