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
        <li><a href="#setup_script">Setup script</a></li>
        <li><a href="#config">Configuration</a></li>
        <li><a href="#transformations">Transformations</a></li>
        <li><a href="#faq"><abbr title="Frequently Asked Questions"> FAQ</abbr></a></li>
        <li><a href="#developers">Developers</a></li>
        <li><a href="#copyright">Copyright</a></li>
        <li><a href="#credits">Credits</a></li>
        <li><a href="#extjs_components">Ext JS - Components</a></li>
    </ul>

    <div id="body">
        <h2 id="links">Links</h2>
        <ul>
            <li><a href="https://github.com/Ator9/UX-CMS" target="_blank">Git repositories on Github</a></li>
            <li><a href="https://github.com/Ator9/UX-CMS/commits/master" target="_blank">Changelog</a></li>
        </ul>

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

        <h2 id="intro">Introduction</h2>
        <p>
            UX CMS can ... a
        </p>

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

<!-- CONFIGURATION -->
<h2 id="config">Configuration</h2>

<p> <span class="important">Configuration note:</span>
    Almost all configurable data is placed in <tt>config.inc.php</tt>. If this file
    does not exist, please refer to the <a href="#setup">Quick install</a>
    section to create one. This file only needs to contain the parameters you want to
    change from their corresponding default value in
    <tt>libraries/config.default.php</tt>.</p>

<p> The parameters which relate to design (like colors) are placed in
    <tt>themes/themename/layout.inc.php</tt>. You might also want to create
    <i>config.footer.inc.php</i> and <i>config.header.inc.php</i> files to add
    your site specific code to be included on start and end of each page.</p>

<dl><dt id="cfg_PmaAbsoluteUri">$cfg['PmaAbsoluteUri'] string</dt>
    <dd>Sets here the complete <abbr title="Uniform Resource Locator">URL</abbr>
        (with full path) to your phpMyAdmin installation's directory.
        E.g. <tt>http://www.your_web.net/path_to_your_phpMyAdmin_directory/</tt>.
        Note also that the <abbr title="Uniform Resource Locator">URL</abbr> on
        some web servers are case&#8211;sensitive.
        Don&#8217;t forget the trailing slash at the end.<br /><br />

        Starting with version 2.3.0, it is advisable to try leaving this
        blank. In most cases phpMyAdmin automatically detects the proper
        setting. Users of port forwarding will need to set PmaAbsoluteUri (<a
        href="https://sourceforge.net/tracker/index.php?func=detail&amp;aid=1340187&amp;group_id=23067&amp;atid=377409">more info</a>).
        A good test is to browse a table, edit a row and save it. There should
        be an error message if phpMyAdmin is having trouble auto&#8211;detecting
        the correct value. If you get an error that this must be set or if
        the autodetect code fails to detect your path, please post a bug
        report on our bug tracker so we can improve the code.</dd>

    <dt id="cfg_PmaNoRelation_DisableWarning">$cfg['PmaNoRelation_DisableWarning'] boolean</dt>
    <dd>Starting with version 2.3.0 phpMyAdmin offers a lot of features to work
        with master / foreign &#8211; tables (see
        <a href="#pmadb" class="configrule">$cfg['Servers'][$i]['pmadb']</a>).
        <br />
        If you tried to set this up and it does not work for you, have a look on
        the &quot;Structure&quot; page of one database where you would like to
        use it. You will find a link that will analyze why those features have
        been disabled.<br />
        If you do not want to use those features set this variable to
        <tt>TRUE</tt> to stop this message from appearing.</dd>
</dl>

<!-- FAQ -->
<h2 id="faq">FAQ - Frequently Asked Questions</h2>

<ol><li><a href="#faqserver">Server</a></li>
    <li><a href="#faqconfig">Configuration</a></li>
    <li><a href="#faqlimitations">Known limitations</a></li>
    <li><a href="#faqmultiuser">ISPs, multi-user installations</a></li>
    <li><a href="#faqbrowsers">Browsers or client <abbr title="operating system">OS</abbr></a></li>
    <li><a href="#faqusing">Using phpMyAdmin</a></li>
    <li><a href="#faqproject">phpMyAdmin project</a></li>
    <li><a href="#faqsecurity">Security</a></li>
    <li><a href="#faqsynchronization">Synchronization</a></li>
</ol>

<p> Please have a look at our
    <a href="http://www.phpmyadmin.net/home_page/docs.php">Link section</a> on
    the official phpMyAdmin homepage for in-depth coverage of phpMyAdmin's
    features and or interface.</p>

<h3 id="faqserver">Server</h3>

<h4 id="faq1_1">
    <a href="#faq1_1">1.1 My server is crashing each time a specific
    action is required or phpMyAdmin sends a blank page or a page full of
    cryptic characters to my browser, what can I do?</a></h4>

<p> Try to set the <a href="#cfg_OBGzip" class="configrule">$cfg['OBGzip']</a>
    directive to <tt>FALSE</tt> in your <i>config.inc.php</i> file and the
    <tt>zlib.output_compression</tt> directive to <tt>Off</tt> in your php
    configuration file.<br /></p>

<h4 id="faq1_2">
    <a href="#faq1_2">1.2 My Apache server crashes when using phpMyAdmin.</a></h4>

<p> You should first try the latest versions of Apache (and possibly MySQL).<br />
    See also the
    <a href="#faq1_1"><abbr title="Frequently Asked Questions">FAQ</abbr> 1.1</a>
    entry about PHP bugs with output buffering.<br />
    If your server keeps crashing, please ask for help in the various Apache
    support groups.</p>

<h4 id="faq1_3">
    <a href="#faq1_3">1.3 (withdrawn).</a></h4>

<h4 id="faq1_4">
    <a href="#faq1_4">1.4 Using phpMyAdmin on
    <abbr title="Internet Information Services">IIS</abbr>, I'm displayed the
    error message: &quot;The specified <abbr title="Common Gateway Interface">CGI</abbr>
    application misbehaved by not returning a complete set of
    <abbr title="HyperText Transfer Protocol">HTTP</abbr> headers ...&quot;.</a>
</h4>

<p> You just forgot to read the <i>install.txt</i> file from the PHP distribution.
    Have a look at the last message in this
    <a href="http://bugs.php.net/bug.php?id=12061">bug report</a> from the
    official PHP bug database.</p>

<h4 id="faq1_5">
    <a href="#faq1_5">1.5 Using phpMyAdmin on
    <abbr title="Internet Information Services">IIS</abbr>, I'm facing crashes
    and/or many error messages with the
    <abbr title="HyperText Transfer Protocol">HTTP</abbr>.</a></h4>

<p> This is a known problem with the PHP
    <abbr title="Internet Server Application Programming Interface">ISAPI</abbr>
    filter: it's not so stable. Please use instead the cookie authentication mode.
</p>

<h4 id="faq1_6">
    <a href="#faq1_6">1.6 I can't use phpMyAdmin on PWS: nothing is displayed!</a></h4>

<p> This seems to be a PWS bug. Filippo Simoncini found a workaround (at this
    time there is no better fix): remove or comment the <tt>DOCTYPE</tt>
    declarations (2 lines) from the scripts <i>libraries/header.inc.php</i>,
    <i>libraries/header_printview.inc.php</i>, <i>index.php</i>,
    <i>navigation.php</i> and <i>libraries/common.lib.php</i>.</p>

<h4 id="faq1_7">
    <a href="#faq1_7">1.7 How can I GZip or Bzip a dump or a
    <abbr title="comma separated values">CSV</abbr> export? It does not seem to
    work.</a></h4>

<p> These features are based on the <tt>gzencode()</tt> and <tt>bzcompress()</tt>
    PHP functions to be more independent of the platform (Unix/Windows, Safe Mode
    or not, and so on). So, you must have Zlib/Bzip2
    support (<tt>--with-zlib</tt> and <tt>--with-bz2</tt>).<br /></p>

<h4 id="faq1_8">
    <a href="#faq1_8">1.8 I cannot insert a text file in a table, and I get
    an error about safe mode being in effect.</a></h4>

<p> Your uploaded file is saved by PHP in the &quot;upload dir&quot;, as
    defined in <i>php.ini</i> by the variable <tt>upload_tmp_dir</tt> (usually
    the system default is <i>/tmp</i>).<br />
    We recommend the following setup for Apache servers running in safe mode,
    to enable uploads of files while being reasonably secure:</p>

<ul><li>create a separate directory for uploads: <tt>mkdir /tmp/php</tt></li>
    <li>give ownership to the Apache server's user.group:
        <tt>chown apache.apache /tmp/php</tt></li>
    <li>give proper permission: <tt>chmod 600 /tmp/php</tt></li>
    <li>put <tt>upload_tmp_dir = /tmp/php</tt> in <i>php.ini</i></li>
    <li>restart Apache</li>
</ul>

<h4 id="faq1_9">
    <a href="#faq1_9">1.9 (withdrawn).</a></h4>

<h4 id="faq1_10">
    <a href="#faq1_10">1.10 I'm having troubles when uploading files with
    phpMyAdmin running on a secure server. My browser is Internet Explorer and
    I'm using the Apache server.</a></h4>

<p> As suggested by &quot;Rob M&quot; in the phpWizard forum, add this line to
    your <i>httpd.conf</i>:</p>

    <pre>SetEnvIf User-Agent ".*MSIE.*" nokeepalive ssl-unclean-shutdown</pre>

<p> It seems to clear up many problems between Internet Explorer and SSL.</p>

<h4 id="faq1_11">
    <a href="#faq1_11">1.11 I get an 'open_basedir restriction' while
    uploading a file from the query box.</a></h4>

<p> Since version 2.2.4, phpMyAdmin supports servers with open_basedir
    restrictions. However you need to create temporary directory and 
    configure it as <a href="#cfg_TempDir" class="configrule">$cfg['TempDir']</a>.
    The uploaded files will be moved there, and after execution of your
    <abbr title="structured query language">SQL</abbr> commands, removed.</p>

<h4 id="faq1_12">
    <a href="#faq1_12">1.12 I have lost my MySQL root password, what can I do?</a></h4>

<p> The MySQL manual explains how to
    <a href="http://dev.mysql.com/doc/mysql/en/resetting-permissions.html">
    reset the permissions</a>.</p>

<h4 id="faq1_13">
    <a href="#faq1_13">1.13 (withdrawn).</a></h4>

<h4 id="faq1_14">
    <a href="#faq1_14">1.14 (withdrawn).</a></h4>

<h4 id="faq1_15">
    <a href="#faq1_15">1.15 I have problems with <i>mysql.user</i> column names.</a>
</h4>

<p> In previous MySQL versions, the <tt>User</tt> and <tt>Password</tt>columns 
    were named <tt>user</tt> and <tt>password</tt>. Please modify your column 
    names to align with current standards.</p>

<h4 id="faq1_16">
    <a href="#faq1_16">1.16 I cannot upload big dump files (memory,
    <abbr title="HyperText Transfer Protocol">HTTP</abbr> or timeout problems).</a>
</h4>

<p> Starting with version 2.7.0, the import engine has been re&#8211;written and these
    problems should not occur. If possible, upgrade your phpMyAdmin to the latest version
    to take advantage of the new import features.</p>

<p> The first things to check (or ask your host provider to check) are the
    values of <tt>upload_max_filesize</tt>, <tt>memory_limit</tt> and
    <tt>post_max_size</tt> in the <i>php.ini</i> configuration file.
    All of these three settings limit the maximum size of data that can be
    submitted and handled by PHP. One user also said that
    <tt>post_max_size</tt>
    and <tt>memory_limit</tt> need to be larger than <tt>upload_max_filesize</tt>.<br /> <br />

    There exist several workarounds if your upload is too big or your
    hosting provider is unwilling to change the settings:</p>

<ul><li>Look at the <a href="#cfg_UploadDir" class="configrule">$cfg['UploadDir']</a>
        feature. This allows one to
        upload a file to the server via scp, ftp, or your favorite file transfer
        method. PhpMyAdmin is then able to import the files from the temporary
        directory. More information is available in the <a href="#config">Configuration
        section</a> of this document.</li>
    <li>Using a utility (such as <a href="http://www.ozerov.de/bigdump.php">
        BigDump</a>) to split the files before uploading. We cannot support this
        or any third party applications, but are aware of users having success
        with it.</li>
    <li>If you have shell (command line) access, use MySQL to import the files
        directly. You can do this by issuing the &quot;source&quot; command from
        within MySQL: <tt>source <i>filename.sql</i></tt>.</li>
</ul>

<h4 id="faq1_17">
    <a id="faqmysqlversions" href="#faq1_17">1.17 Which MySQL versions does phpMyAdmin
    support?</a></h4>

<p> Since phpMyAdmin 3.0.x, only MySQL 5.0.1 and newer are supported. For 
    older MySQL versions, you need to use the latest 2.x branch. phpMyAdmin can 
    connect to your MySQL server using PHP's classic
    <a href="http://php.net/mysql">MySQL extension</a> as well as the
    <a href="http://php.net/mysqli">improved MySQL extension (MySQLi)</a> that
    is available in PHP 5.0. The latter one should be used unless you have a
    good reason not to do so.<br />
    When compiling PHP, we strongly recommend that you manually link the MySQL
    extension of your choice to a MySQL client library of at least the same
    minor version since the one that is bundled with some PHP distributions is
    rather old and might cause problems <a href="#faq1_17a">
        (see <abbr title="Frequently Asked Questions">FAQ</abbr> 1.17a)</a>.<br /><br />
    <a href="http://mariadb.org/">MariaDB</a> is also supported
    (versions 5.1 and 5.2 were tested).<br /><br />
    Since phpMyAdmin 3.5 <a href="http://www.drizzle.org/">Drizzle</a> is supported.
    </p>

<h5 id="faq1_17a">
    <a href="#faq1_17a">1.17a I cannot connect to the MySQL server. It always returns the error
    message, &quot;Client does not support authentication protocol requested
    by server; consider upgrading MySQL client&quot;</a></h5>

<p> You tried to access MySQL with an old MySQL client library. The version of
    your MySQL client library can be checked in your phpinfo() output.
    In general, it should have at least the same minor version as your server
    - as mentioned in <a href="#faq1_17">
    <abbr title="Frequently Asked Questions">FAQ</abbr> 1.17</a>.<br /><br />

    This problem is generally caused by using MySQL version 4.1 or newer. MySQL
    changed the authentication hash and your PHP is trying to use the old method.
    The proper solution is to use the <a href="http://www.php.net/mysqli">mysqli extension</a>
    with the proper client library to match your MySQL installation. Your
    chosen extension is specified in <a href="#cfg_Servers_extension" class="configrule">$cfg['Servers'][$i]['extension']</a>.
    More information (and several workarounds) are located in the
    <a href="http://dev.mysql.com/doc/mysql/en/old-client.html">MySQL Documentation</a>.
</p>

<h4 id="faq1_18">
    <a href="#faq1_18">1.18 (withdrawn).</a></h4>

<h4 id="faq1_19">
    <a href="#faq1_19">1.19 I can't run the &quot;display relations&quot; feature because the
    script seems not to know the font face I'm using!</a></h4>

<p> The &quot;FPDF&quot; library we're using for this feature requires some
    special files to use font faces.<br />
    Please refers to the <a href="http://www.fpdf.org/">FPDF manual</a> to build
    these files.</p>

<h4 id="faqmysql">
    <a href="#faqmysql">1.20 I receive the error &quot;cannot load MySQL extension, please
    check PHP Configuration&quot;.</a></h4>

<p> To connect to a MySQL server, PHP needs a set of MySQL functions called
    &quot;MySQL extension&quot;. This extension may be part of the PHP
    distribution (compiled-in), otherwise it needs to be loaded dynamically. Its
    name is probably <i>mysql.so</i> or <i>php_mysql.dll</i>. phpMyAdmin tried
    to load the extension but failed.<br /><br />

    Usually, the problem is solved by installing a software package called
    &quot;PHP-MySQL&quot; or something similar.</p>

<h4 id="faq1_21">
    <a href="#faq1_21">1.21 I am running the
    <abbr title="Common Gateway Interface">CGI</abbr> version of PHP under Unix,
    and I cannot log in using cookie auth.</a></h4>

<p> In <i>php.ini</i>, set <tt>mysql.max_links</tt> higher than 1.</p>

<h4 id="faq1_22">
    <a href="#faq1_22">1.22 I don't see the &quot;Location of text file&quot; field,
    so I cannot upload.</a></h4>

<p> This is most likely because in <i>php.ini</i>, your <tt>file_uploads</tt>
    parameter is not set to &quot;on&quot;.</p>

<h4 id="faq1_23">
    <a href="#faq1_23">1.23 I'm running MySQL on a Win32 machine. Each time I create
    a new table the table and column names are changed to lowercase!</a></h4>

<p> This happens because the MySQL directive <tt>lower_case_table_names</tt>
    defaults to 1 (<tt>ON</tt>) in the Win32 version of MySQL. You can change
    this behavior by simply changing the directive to 0 (<tt>OFF</tt>):<br />
    Just edit your <tt>my.ini</tt> file that should be located in your Windows
    directory and add the following line to the group [mysqld]:</p>

<pre>set-variable = lower_case_table_names=0</pre>

<p> Next, save the file and restart the MySQL service. You can always check the
    value of this directive using the query</p>

<pre>SHOW VARIABLES LIKE 'lower_case_table_names';</pre>

<h4 id="faq1_24">
    <a href="#faq1_24">1.24 (withdrawn).</a></h4>

<h4 id="faq1_25">
    <a href="#faq1_25">1.25 I am running Apache with mod_gzip-1.3.26.1a on Windows XP,
    and I get problems, such as undefined variables when I run a
    <abbr title="structured query language">SQL</abbr> query.</a></h4>

<p> A tip from Jose Fandos: put a comment on the following two lines
    in httpd.conf, like this:</p>

<pre>
# mod_gzip_item_include file \.php$
# mod_gzip_item_include mime "application/x-httpd-php.*"
</pre>

<p> as this version of mod_gzip on Apache (Windows) has problems handling
    PHP scripts. Of course you have to restart Apache.</p>

<h4 id="faq1_26">
    <a href="#faq1_26">1.26 I just installed phpMyAdmin in my document root of
    <abbr title="Internet Information Services">IIS</abbr> but
    I get the error &quot;No input file specified&quot; when trying to
    run phpMyAdmin.</a></h4>

<p> This is a permission problem. Right-click on the phpmyadmin folder
    and choose properties. Under the tab Security, click on &quot;Add&quot;
    and select the user &quot;IUSR_machine&quot; from the list. Now set his
    permissions and it should work.</p>

<h4 id="faq1_27">
    <a href="#faq1_27">1.27 I get empty page when I want to view huge page (eg.
    db_structure.php with plenty of tables).</a></h4>

<p> This is a <a href="http://bugs.php.net/21079">PHP bug</a> that occur when
    GZIP output buffering is enabled. If you turn off it (by
    <a href="#cfg_OBGzip" class="configrule">$cfg['OBGzip'] = false</a>
    in <i>config.inc.php</i>), it should work. This bug will be fixed in
    PHP&nbsp;5.0.0.</p>

<h4 id="faq1_28">
    <a href="#faq1_28">1.28 My MySQL server sometimes refuses queries and returns the
    message 'Errorcode: 13'. What does this mean?</a></h4>

<p> This can happen due to a MySQL bug when having database / table names with
    upper case characters although <tt>lower_case_table_names</tt> is set to 1.
    To fix this, turn off this directive, convert all database and table names
    to lower case and turn it on again. Alternatively, there's a bug-fix
    available starting with MySQL&nbsp;3.23.56 / 4.0.11-gamma.</p>

<h4 id="faq1_29">
    <a href="#faq1_29">1.29 When I create a table or modify a column, I get an error
    and the columns are duplicated.</a></h4>

<p> It is possible to configure Apache in such a way that PHP has problems
    interpreting .php files.</p>

<p> The problems occur when two different (and conflicting) set of directives
    are used:</p>

<pre>
SetOutputFilter PHP
SetInputFilter PHP
</pre>

<p> and</p>

<pre>AddType application/x-httpd-php .php</pre>

<p> In the case we saw, one set of directives was in
    <tt>/etc/httpd/conf/httpd.conf</tt>, while
    the other set was in <tt>/etc/httpd/conf/addon-modules/php.conf</tt>.<br />
    The recommended way is with <tt>AddType</tt>, so just comment out
    the first set of lines and restart Apache:</p>

<pre>
#SetOutputFilter PHP
#SetInputFilter PHP
</pre>

<h4 id="faq1_30">
    <a href="#faq1_30">1.30 I get the error &quot;navigation.php: Missing hash&quot;.</a></h4>

<p> This problem is known to happen when the server is running Turck MMCache
    but upgrading MMCache to version 2.3.21 solves the problem.</p>

<h4 id="faq1_31">
    <a href="#faq1_31">1.31 Does phpMyAdmin support php5?</a></h4>

<p>Yes.</p>
<p>
    Since release 3.0 only PHP 5.2 and newer. For older PHP versions 2.9 branch
    is still maintained.
</p>

<h4 id="faq1_32">
    <a href="#faq1_32">1.32 Can I use <abbr title="HyperText Transfer Protocol">HTTP</abbr> authentication with <abbr title="Internet Information Services">IIS</abbr>?</a></h4>

<p> Yes. This procedure was tested with phpMyAdmin 2.6.1, PHP 4.3.9 in <abbr title="Internet Server Application Programming Interface">ISAPI</abbr>
    mode under <abbr title="Internet Information Services">IIS</abbr> 5.1.</p>

<ol><li>In your <tt>php.ini</tt> file, set <tt>cgi.rfc2616_headers = 0</tt></li>
    <li>In <tt>Web Site Properties -&gt; File/Directory Security -&gt; Anonymous
        Access</tt> dialog box, check the <tt>Anonymous access</tt> checkbox and
        uncheck any other checkboxes (i.e. uncheck <tt>Basic authentication</tt>,
        <tt>Integrated Windows authentication</tt>, and <tt>Digest</tt> if it's
        enabled.) Click <tt>OK</tt>.</li>
    <li>In <tt>Custom Errors</tt>, select the range of <tt>401;1</tt> through
        <tt>401;5</tt> and click the <tt>Set to Default</tt> button.</li>
</ol>

<h4 id="faq1_33">
    <a href="#faq1_33">1.33 (withdrawn).</a></h4>

<h4 id="faq1_34">
    <a href="#faq1_34">1.34 Can I access directly to database or table pages?</a></h4>

<p> Yes. Out of the box, you can use <abbr title="Uniform Resource Locator">URL</abbr>s like
http://server/phpMyAdmin/index.php?server=X&amp;db=database&amp;table=table&amp;target=script. For <tt>server</tt> you use the server number which refers to
the order of the server paragraph in <tt>config.inc.php</tt>.
    Table and script parts are optional. If you want
    http://server/phpMyAdmin/database[/table][/script] <abbr title="Uniform Resource Locator">URL</abbr>s, you need to do
    some configuration. Following lines apply only for <a
    href="http://httpd.apache.org">Apache</a> web server. First make sure,
    that you have enabled some features within global configuration. You need
    <code>Options FollowSymLinks</code> and <code>AllowOverride
    FileInfo</code> enabled for directory where phpMyAdmin is installed and
    you need mod_rewrite to be enabled. Then you just need to create following
    <a href="#glossary"><i>.htaccess</i></a> file in root folder of phpMyAdmin installation
    (don't forget to change directory name inside of it):</p>

<pre>
RewriteEngine On
RewriteBase /path_to_phpMyAdmin
RewriteRule ^([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)/([a-z_]+\.php)$ index.php?db=$1&amp;table=$2&amp;target=$3 [R]
RewriteRule ^([a-zA-Z0-9_]+)/([a-z_]+\.php)$ index.php?db=$1&amp;target=$2 [R]
RewriteRule ^([a-zA-Z0-9_]+)/([a-zA-Z0-9_]+)$ index.php?db=$1&amp;table=$2 [R]
RewriteRule ^([a-zA-Z0-9_]+)$ index.php?db=$1 [R]
</pre>

<h4 id="faq1_35">
    <a href="#faq1_35">1.35 Can I use <abbr title="HyperText Transfer Protocol">HTTP</abbr> authentication with Apache <abbr title="Common Gateway Interface">CGI</abbr>?</a></h4>

<p> Yes. However you need to pass authentication variable to <abbr title="Common Gateway Interface">CGI</abbr> using
    following rewrite rule:</p>

<pre>
RewriteEngine On
RewriteRule .* - [E=REMOTE_USER:%{HTTP:Authorization},L]
</pre>

<h4 id="faq1_36">
    <a href="#faq1_36">1.36 I get an error &quot;500 Internal Server Error&quot;.</a>
</h4>
<p>
    There can be many explanations to this and a look at your server's
    error log file might give a clue.
</p>

<h4 id="faq1_37">
    <a href="#faq1_37">1.37 I run phpMyAdmin on cluster of different machines and
    password encryption in cookie auth doesn't work.</a></h4>

<p> If your cluster consist of different architectures, PHP code used for
    encryption/decryption won't work correct. This is caused by use of
    pack/unpack functions in code. Only solution is to use mcrypt extension
    which works fine in this case.</p>

<h4 id="faq1_38">
    <a href="#faq1_38">1.38 Can I use phpMyAdmin on a server on which Suhosin is enabled?</a></h4>

<p> Yes but the default configuration values of Suhosin are known to cause 
    problems with some operations, for example editing a table with many
    columns and no primary key or with textual primary key.
</p>
<p>
    Suhosin configuration might lead to malfunction in some cases and it can
    not be fully avoided as phpMyAdmin is kind of application which needs to
    transfer big amounts of columns in single HTTP request, what is something
    what Suhosin tries to prevent. Generally all
    <code>suhosin.request.*</code>, <code>suhosin.post.*</code> and
    <code>suhosin.get.*</code> directives can have negative effect on
    phpMyAdmin usability. You can always find in your error logs which limit
    did cause dropping of variable, so you can diagnose the problem and adjust
    matching configuration variable.
</p>
<p>
    The default values for most Suhosin configuration options will work in most 
    scenarios, however you might want to adjust at least following parameters:
</p>

<ul>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.request.max_vars">suhosin.request.max_vars</a> should be increased (eg. 2048)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.post.max_vars">suhosin.post.max_vars</a> should be increased (eg. 2048)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.request.max_array_index_length">suhosin.request.max_array_index_length</a> should be increased (eg. 256)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.post.max_array_index_length">suhosin.post.max_array_index_length</a> should be increased (eg. 256)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.request.max_totalname_length">suhosin.request.max_totalname_length</a> should be increased (eg. 8192)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.post.max_totalname_length">suhosin.post.max_totalname_length</a> should be increased (eg. 8192)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.get.max_value_length">suhosin.get.max_value_length</a> should be increased (eg. 1024)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#suhosin.sql.bailout_on_error">suhosin.sql.bailout_on_error</a> needs to be disabled (the default)</li>
    <li><a href="http://www.hardened-php.net/suhosin/configuration.html#logging_configuration">suhosin.log.*</a> should not include <abbr title="structured query language">SQL</abbr>, otherwise you get big slowdown</li>
</ul>

    <p>
        You can also disable the warning using the <a href="#cfg_SuhosinDisableWarning">
        <tt>SuhosinDisableWarning</tt> directive</a>.
    </p>

<h4 id="faq1_39">
    <a href="#faq1_39">1.39 When I try to connect via https, I can log in, 
    but then my connection is redirected back to http. What can cause this 
    behavior?</a></h4>

<p> Be sure that you have enabled <tt>SSLOptions</tt> and <tt>StdEnvVars</tt>
in your Apache configuration. See <a href="http://httpd.apache.org/docs/2.0/mod/mod_ssl.html#ssloptions">http://httpd.apache.org/docs/2.0/mod/mod_ssl.html#ssloptions</a>.</p>

<h4 id="faq1_40">
    <a href="#faq1_40">1.40 When accessing phpMyAdmin via an Apache reverse proxy, cookie login does not work.</a></h4>

<p>To be able to use cookie auth Apache must know that it has to rewrite the set-cookie headers.<br />
    Example from the Apache 2.2 documentation:</p>
<pre>
ProxyPass /mirror/foo/ http://backend.example.com/
ProxyPassReverse /mirror/foo/ http://backend.example.com/
ProxyPassReverseCookieDomain backend.example.com public.example.com 
ProxyPassReverseCookiePath / /mirror/foo/ 
</pre>

<p>Note: if the backend url looks like http://host/~user/phpmyadmin,
    the tilde (~) must be url encoded as %7E in the ProxyPassReverse* lines.
    This is not specific to phpmyadmin, it's just the behavior of Apache.
    </p>

<pre>
ProxyPass /mirror/foo/ http://backend.example.com/~user/phpmyadmin
ProxyPassReverse /mirror/foo/
http://backend.example.com/%7Euser/phpmyadmin
ProxyPassReverseCookiePath /%7Euser/phpmyadmin /mirror/foo
</pre>

    <p>See <a href="http://httpd.apache.org/docs/2.2/mod/mod_proxy.html">http://httpd.apache.org/docs/2.2/mod/mod_proxy.html</a>
    for more details.</p>

<h4 id="faq1_41">
    <a href="#faq1_41">1.41 When I view a database and ask to see its
           privileges, I get an error about an unknown column.</a></h4>

<p> The MySQL server's privilege tables are not up to date, you need to run
the <tt>mysql_upgrade</tt> command on the server.</p>

<h4 id="faq1_42">
    <a href="#faq1_42">1.42 How can I prevent robots from accessing phpMyAdmin?</a></h4>

<p>You can add various rules to <a href="#glossary"><i>.htaccess</i></a> to filter access
based on user agent field. This is quite easy to circumvent, but could prevent at least
some robots accessing your installation.</p>

<pre>
RewriteEngine on

# Allow only GET and POST verbs
RewriteCond %{REQUEST_METHOD} !^(GET|POST)$ [NC,OR]

# Ban Typical Vulnerability Scanners and others
# Kick out Script Kiddies
RewriteCond %{HTTP_USER_AGENT} ^(java|curl|wget).* [NC,OR]
RewriteCond %{HTTP_USER_AGENT} ^.*(libwww-perl|curl|wget|python|nikto|wkito|pikto|scan|acunetix).* [NC,OR]
RewriteCond %{HTTP_USER_AGENT} ^.*(winhttp|HTTrack|clshttp|archiver|loader|email|harvest|extract|grab|miner).* [NC,OR]

# Ban Search Engines, Crawlers to your administrative panel
# No reasons to access from bots
# Ultimately Better than the useless robots.txt
# Did google respect robots.txt?
# Try google: intitle:phpMyAdmin intext:"Welcome to phpMyAdmin *.*.*" intext:"Log in" -wiki -forum -forums -questions intext:"Cookies must be enabled"
RewriteCond %{HTTP_USER_AGENT} ^.*(AdsBot-Google|ia_archiver|Scooter|Ask.Jeeves|Baiduspider|Exabot|FAST.Enterprise.Crawler|FAST-WebCrawler|www\.neomo\.de|Gigabot|Mediapartners-Google|Google.Desktop|Feedfetcher-Google|Googlebot|heise-IT-Markt-Crawler|heritrix|ibm.com\cs/crawler|ICCrawler|ichiro|MJ12bot|MetagerBot|msnbot-NewsBlogs|msnbot|msnbot-media|NG-Search|lucene.apache.org|NutchCVS|OmniExplorer_Bot|online.link.validator|psbot0|Seekbot|Sensis.Web.Crawler|SEO.search.Crawler|Seoma.\[SEO.Crawler\]|SEOsearch|Snappy|www.urltrends.com|www.tkl.iis.u-tokyo.ac.jp/~crawler|SynooBot|crawleradmin.t-info@telekom.de|TurnitinBot|voyager|W3.SiteSearch.Crawler|W3C-checklink|W3C_Validator|www.WISEnutbot.com|yacybot|Yahoo-MMCrawler|Yahoo\!.DE.Slurp|Yahoo\!.Slurp|YahooSeeker).* [NC]
RewriteRule .* - [F]
</pre>



<h3 id="faqconfig">Configuration</h3>

<h4 id="faq2_1">
    <a href="#faq2_1">2.1 The error message &quot;Warning: Cannot add header information -
    headers already sent by ...&quot; is displayed, what's the problem?</a></h4>

<p> Edit your <i>config.inc.php</i> file and ensure there is nothing
    (I.E. no blank lines, no spaces, no characters...) neither before the
    <tt>&lt;?php</tt> tag at the beginning, neither after the <tt>?&gt;</tt>
    tag at the end. We also got a report from a user under
    <abbr title="Internet Information Services">IIS</abbr>, that used
    a zipped distribution kit: the file <tt>libraries/Config.class.php</tt>
    contained an end-of-line character (hex 0A) at the end; removing this character
    cleared his errors.</p>

<h4 id="faq2_2">
    <a href="#faq2_2">2.2 phpMyAdmin can't connect to MySQL. What's wrong?</a></h4>

<p> Either there is an error with your PHP setup or your username/password is
    wrong. Try to make a small script which uses mysql_connect and see if it
    works. If it doesn't, it may be you haven't even compiled MySQL support
    into PHP.</p>

<h4 id="faq2_3">
    <a href="#faq2_3">2.3 The error message &quot;Warning: MySQL Connection Failed: Can't
    connect to local MySQL server through socket '/tmp/mysql.sock'
    (111) ...&quot; is displayed. What can I do?</a></h4>

<p> For RedHat users, Harald Legner suggests this on the mailing list:</p>

<p> On my RedHat-Box the socket of MySQL is <i>/var/lib/mysql/mysql.sock</i>.
    In your <i>php.ini</i> you will find a line</p>

<pre>mysql.default_socket = /tmp/mysql.sock</pre>

<p> change it to</p>

<pre>mysql.default_socket = /var/lib/mysql/mysql.sock</pre>

<p> Then restart apache and it will work.</p>

<p> Here is a fix suggested by Brad Ummer:</p>

<ul><li>First, you need to determine what socket is being used by MySQL.<br />
        To do this, telnet to your server and go to the MySQL bin directory. In
        this directory there should be a file named <i>mysqladmin</i>. Type
        <tt>./mysqladmin variables</tt>, and this should give you a bunch of
        info about your MySQL server, including the socket
        (<i>/tmp/mysql.sock</i>, for example).</li>
    <li>Then, you need to tell PHP to use this socket.<br /> To do this in
        phpMyAdmin, you need to complete the  socket information in the
        <i>config.inc.php</i>.<br />
        For example:
        <a href="#cfg_Servers_socket" class="configrule">
        $cfg['Servers'][$i]['socket']&nbsp;=&nbsp;'/tmp/mysql.sock';</a>
        <br /><br />

        Please also make sure that the permissions of this file allow to be readable
        by your webserver (i.e. '0755').</li>
</ul>

<p> Have also a look at the
    <a href="http://dev.mysql.com/doc/en/can-not-connect-to-server.html">
         corresponding section of the MySQL documentation</a>.</p>

<h4 id="faq2_4">
    <a href="#faq2_4">2.4 Nothing is displayed by my browser when I try to run phpMyAdmin,
    what can I do?</a></h4>

<p> Try to set the <a href="#cfg_OBGzip" class="configrule">$cfg['OBGZip']</a>
    directive to <tt>FALSE</tt> in the phpMyAdmin configuration file. It helps
    sometime.<br />
    Also have a look at your PHP version number: if it contains &quot;b&quot; or &quot;alpha&quot;
    it means you're running a testing version of PHP. That's not a so good idea,
    please upgrade to a plain revision.</p>

<h4 id="faq2_5">
    <a href="#faq2_5">2.5 Each time I want to insert or change a row or drop a database
    or a table, an error 404 (page not found) is displayed or, with <abbr title="HyperText Transfer Protocol">HTTP</abbr> or
    cookie authentication, I'm asked to log in again. What's wrong?</a></h4>

<p> Check the value you set for the
    <a href="#cfg_PmaAbsoluteUri" class="configrule">$cfg['PmaAbsoluteUri']</a>
    directive in the phpMyAdmin configuration file.</p>

<h4 id="faq2_6">
    <a href="#faq2_6">2.6 I get an &quot;Access denied for user: 'root@localhost' (Using
    password: YES)&quot;-error when trying to access a MySQL-Server on a
    host which is port-forwarded for my localhost.</a></h4>

<p> When you are using a port on your localhost, which you redirect via
    port-forwarding to another host, MySQL is not resolving the localhost
    as expected.<br />
    Erik Wasser explains: The solution is: if your host is &quot;localhost&quot;
    MySQL (the command line tool <code>mysql</code> as well) always tries to use the socket
    connection for speeding up things. And that doesn't work in this configuration
    with port forwarding.<br />
    If you enter "127.0.0.1" as hostname, everything is right and MySQL uses the
    <abbr title="Transmission Control Protocol">TCP</abbr> connection.</p>

<h4 id="faqthemes"><a href="#faqthemes">2.7 Using and creating themes</a></h4>

<p> Themes are configured with
    <a href="#cfg_ThemePath" class="configrule">$cfg['ThemePath']</a>,
    <a href="#cfg_ThemeManager" class="configrule">$cfg['ThemeManager']</a> and
    <a href="#cfg_ThemeDefault" class="configrule">$cfg['ThemeDefault']</a>.<br />
    <br />
    Under <a href="#cfg_ThemePath" class="configrule">$cfg['ThemePath']</a>, you
    should not delete the directory &quot;original&quot; or its underlying
    structure, because this is the system theme used by phpMyAdmin.
    &quot;original&quot; contains all images and styles, for backwards
    compatibility and for all themes that would not include images or css-files.
    <br /><br />

    If <a href="#cfg_ThemeManager" class="configrule">$cfg['ThemeManager']</a>
    is enabled, you can select your favorite theme on the main page. Your
    selected theme will be stored in a cookie.<br /><br /></p>

<p> To create a theme:</p>

<ul><li>make a new subdirectory (for example &quot;your_theme_name&quot;) under
        <a href="#cfg_ThemePath" class="configrule">$cfg['ThemePath']</a>
        (by default <tt>themes</tt>)</li>
    <li>copy the files and directories from &quot;original&quot; to
        &quot;your_theme_name&quot;</li>
    <li>edit the css-files in &quot;your_theme_name/css&quot;</li>
    <li>put your new images in &quot;your_theme_name/img&quot;</li>
    <li>edit <tt>layout.inc.php</tt> in &quot;your_theme_name&quot;</li>
    <li>edit <tt>info.inc.php</tt> in &quot;your_theme_name&quot; to
        contain your chosen theme name, that will be visible in user interface</li>
    <li>make a new screenshot of your theme and save it under
        &quot;your_theme_name/screen.png&quot;</li>
</ul>

<p> In theme directory there is file <tt>info.inc.php</tt> which contains
    theme verbose name, theme generation and theme version. These versions and
    generations are enumerated from 1 and do not have any direct dependence on
    phpMyAdmin version. Themes within same generation should be backwards
    compatible - theme with version 2 should work in phpMyAdmin requiring
    version 1. Themes with different generation are incompatible.</p>

<p> If you do not want to use your own symbols and buttons, remove the
    directory &quot;img&quot; in &quot;your_theme_name&quot;. phpMyAdmin will
    use the default icons and buttons (from the system-theme &quot;original&quot;).
</p>

<h4 id="faqmissingparameters">
    <a href="#faqmissingparameters">2.8 I get &quot;Missing parameters&quot; errors,
    what can I do?</a></h4>

<p> Here are a few points to check:</p>

<ul><li>In <tt>config.inc.php</tt>, try to leave the
        <a href="#cfg_PmaAbsoluteUri" class="configrule">$cfg['PmaAbsoluteUri']</a>
        directive empty. See also
        <a href="#faq4_7"><abbr title="Frequently Asked Questions">FAQ</abbr> 4.7</a>.
    </li>
    <li>Maybe you have a broken PHP installation or you need to upgrade
        your Zend Optimizer. See
        <a href="http://bugs.php.net/bug.php?id=31134">
        http://bugs.php.net/bug.php?id=31134</a>.
    </li>
    <li>If you are using Hardened PHP with the ini directive <tt>varfilter.max_request_variables</tt>
        set to the default (200) or another low value, you could get this
        error if your table has a high number of columns. Adjust this setting
        accordingly. (Thanks to Klaus Dorninger for the hint).
    </li>
    <li>In the <tt>php.ini</tt> directive <tt>arg_separator.input</tt>, a value
        of &quot;;&quot; will cause this error. Replace it with &quot;&amp;;&quot;.
    </li>
    <li>If you are using <a href="http://www.hardened-php.net/">Hardened-PHP</a>,
       you might want to increase
       <a href="http://www.hardened-php.net/hphp/troubleshooting.html">request limits</a>.
    </li>
    <li>The directory specified in the <tt>php.ini</tt> directive <tt>session.save_path</tt> does not exist or is read-only.
    </li>
</ul>

<h4 id="faq2_9">
    <a href="#faq2_9">2.9 Seeing an upload progress bar</a></h4>

<p> To be able to see a progress bar during your uploads, your server must
have either the <a href="http://pecl.php.net/package/APC">APC</a> extension
    or the <a href="http://pecl.php.net/package/uploadprogress">uploadprogress</a>
    one. Moreover, the JSON extension has to be enabled in your PHP.</p>
    <p> If using APC, you must set <tt>apc.rfc1867</tt> to <tt>on</tt> in your php.ini.</p>

<h3 id="faqlimitations">Known limitations</h3>

<h4 id="login_bug">
    <a href="#login_bug">3.1 When using
    <abbr title="HyperText Transfer Protocol">HTTP</abbr> authentication, a user
    who logged out can not log in again in with the same nick.</a></h4>

<p> This is related to the authentication mechanism (protocol) used by
    phpMyAdmin. To bypass this problem: just close all the opened
    browser windows and then go back to phpMyAdmin. You should be able to
    log in again.</p>

<h4 id="faq3_2">
    <a href="#faq3_2">3.2 When dumping a large table in compressed mode, I get a memory
    limit error or a time limit error.</a></h4>

<p> Compressed dumps are built in memory and because of this are limited to
    php's memory limit. For GZip/BZip2 exports this can be overcome since 2.5.4
    using
    <a href="#cfg_CompressOnFly" class="configrule">$cfg['CompressOnFly']</a>
    (enabled by default). Zip exports can not be handled this way, so if you need
    Zip files for larger dump, you have to use another way.</p>

<h4 id="faq3_3">
    <a href="#faq3_3">3.3 With InnoDB tables, I lose foreign key relationships 
    when I rename a table or a column.</a></h4>

<p> This is an InnoDB bug, see <a href="http://bugs.mysql.com/bug.php?id=21704">http://bugs.mysql.com/bug.php?id=21704</a>.</p>

<h4 id="faq3_4">
    <a href="#faq3_4">3.4 I am unable to import dumps I created with the mysqldump tool
    bundled with the MySQL server distribution.</a></h4>

<p> The problem is that older versions of <code>mysqldump</code> created invalid comments like this:</p>

<pre>
-- MySQL dump 8.22
--
-- Host: localhost Database: database
---------------------------------------------------------
-- Server version 3.23.54
</pre>

<p> The invalid part of the code is the horizontal line made of dashes that
    appears once in every dump created with mysqldump. If you want to run your
    dump you have to turn it into valid MySQL. This means, you have to add a
    whitespace after the first two dashes of the line or add a # before it:
    <br />
    <code>
        -- -------------------------------------------------------<br />
    </code>
    or<br />
    <code>
        #---------------------------------------------------------
    </code>
</p>

<h4 id="faq3_5">
    <a href="#faq3_5">3.5 When using nested folders there are some multiple hierarchies
    displayed in a wrong manner?!</a> (<a href="#cfg_LeftFrameTableSeparator"
    class="configrule">$cfg['LeftFrameTableSeparator']</a>)</h4>

<p> Please note that you should not use the separating string multiple times
    without any characters between them, or at the beginning/end of your table
    name. If you have to, think about using another TableSeparator or disabling
    that feature</p>

<h4 id="faq3_6">
    <a href="#faq3_6">3.6 What is currently not supported in phpMyAdmin about InnoDB?</a></h4>

<p> In Relation view, being able to choose a table in another database,
    or having more than one index column in the foreign key.<br /><br/>
    In Query-by-example (Query), automatic generation of the query
    LEFT JOIN from the foreign table.<br /><br/>
</p>

<h4 id="faq3_7">
    <a href="#faq3_7">3.7 I have table with many (100+) columns and when I try to browse table
    I get series of errors like &quot;Warning: unable to parse url&quot;. How
    can this be fixed?</a></h4>
<p>
    Your table neither have a primary key nor an unique one, so we must use a
    long expression to identify this row. This causes problems to parse_url
    function. The workaround is to create a primary or unique key.
    <br />
</p>

<h4 id="faq3_8">
    <a href="#faq3_8">3.8 I cannot use (clickable) HTML-forms in columns where I put
    a MIME-Transformation onto!</a></h4>

<p> Due to a surrounding form-container (for multi-row delete checkboxes), no
    nested forms can be put inside the table where phpMyAdmin displays the results.
    You can, however, use any form inside of a table if keep the parent
    form-container with the target to tbl_row_delete.php and just put your own
    input-elements inside. If you use a custom submit input field, the form will
    submit itself to the displaying page again, where you can validate the
    $HTTP_POST_VARS in a transformation.

    For a tutorial on how to effectively use transformations, see our
    <a href="http://www.phpmyadmin.net/home_page/docs.php">Link section</a>
    on the official phpMyAdmin-homepage.</p>

<h4 id="faq3_9">
    <a href="#faq3_9">3.9 I get error messages when using "--sql_mode=ANSI" for the
    MySQL server</a></h4>

<p> When MySQL is running in ANSI-compatibility mode, there are some major
    differences in how <abbr title="structured query language">SQL</abbr> is
    structured (see <a href="http://dev.mysql.com/doc/mysql/en/ansi-mode.html">
    http://dev.mysql.com/doc/mysql/en/ansi-mode.html</a>). Most important of all,
    the quote-character (") is interpreted as an identifier quote character and
    not as a string quote character, which makes many internal phpMyAdmin
    operations into invalid <abbr title="structured query language">SQL</abbr>
    statements. There is no workaround to this behaviour. News to this item will
    be posted in Bug report
    <a href="https://sourceforge.net/tracker/index.php?func=detail&amp;aid=816858&amp;group_id=23067&amp;atid=377408">#816858</a>
</p>

<h4 id="faq3_10">
    <a href="#faq3_10">3.10 Homonyms and no primary key: When the results of a SELECT display
    more that one column with the same value
    (for example <tt>SELECT lastname from employees where firstname like 'A%'</tt> and two &quot;Smith&quot; values are displayed),
    if I click Edit I cannot be sure that I am editing the intended row.</a></h4>

<p> Please make sure that your table has a primary key, so that phpMyAdmin
    can use it for the Edit and Delete links.</p>

<h4 id="faq3_11">
    <a href="#faq3_11">3.11 The number of rows for InnoDB tables is not correct.</a></h4>

<p> phpMyAdmin uses a quick method to get the row count, and this method
    only returns an approximate count in the case of InnoDB tables. See
    <a href="#cfg_MaxExactCount" class="configrule">$cfg['MaxExactCount']</a> for
    a way to modify those results, but
    this could have a serious impact on performance.</p>

<h4 id="faq3_12">
    <a href="#faq3_12">3.12 (withdrawn).</a></h4>

<h4 id="faq3_13">
    <a href="#faq3_13">3.13 I get an error when entering <tt>USE</tt> followed by a db name
    containing an hyphen.
</a></h4>
<p>
    The tests I have made with MySQL 5.1.49 shows that the
    API does not accept this syntax for the USE command.
</p>

<h4 id="faq3_14">
    <a href="#faq3_14">3.14 I am not able to browse a table when I don't have the right to SELECT one of the columns.</a></h4>
<p>
    This has been a known limitation of phpMyAdmin since the beginning and
    it's not likely to be solved in the future.
</p>

<!-- Begin: Excel import limitations -->

<h4 id="faq3_15">
    <a href="#faq3_15">3.15 (withdrawn).</a></h4>

<h4 id="faq3_16">
    <a href="#faq3_16">3.16 (withdrawn).</a></h4>

<h4 id="faq3_17">
    <a href="#faq3_17">3.17 (withdrawn).</a></h4>

<!-- End: Excel import limitations -->
<!-- Begin: CSV import limitations -->

<h4 id="faq3_18">
    <a href="#faq3_18">3.18 When I import a <abbr title="comma separated values">
    CSV</abbr> file that contains multiple tables, they are lumped together into
    a single table.</a></h4>
<p>
    There is no reliable way to differentiate tables in <abbr title="comma separated values">
    CSV</abbr> format. For the time being, you will have to break apart
    <abbr title="comma separated values">CSV</abbr> files containing multiple tables.
</p>

<!-- End: CSV import limitations -->
<!-- Begin: Import type-detection limitations -->

<h4 id="faq3_19">
    <a href="#faq3_19">3.19 When I import a file and have phpMyAdmin determine the appropriate data structure it only uses int, decimal, and varchar types.</a></h4>
<p>
    Currently, the import type-detection system can only assign these MySQL types to columns. In future, more will likely be added but for the time being 
    you will have to edit the structure to your liking post-import.
    <br /><br />
    Also, you should note the fact that phpMyAdmin will use the size of the largest item in any given column as the column size for the appropriate type. If you 
    know you will be adding larger items to that column then you should manually adjust the column sizes accordingly. This is done for the sake of efficiency.
</p>

<!-- End: Import type-detection limitations -->

<h3 id="faqmultiuser"><abbr title="Internet service provider">ISP</abbr>s, multi-user installations</h3>

<h4 id="faq4_1">
    <a href="#faq4_1">4.1 I'm an <abbr title="Internet service provider">ISP</abbr>. Can I setup one central copy of phpMyAdmin or do I
    need to install it for each customer.
</a></h4>
<p>
    Since version 2.0.3, you can setup a central copy of phpMyAdmin for all
    your users. The development of this feature was kindly sponsored by
    NetCologne GmbH.
    This requires a properly setup MySQL user management and phpMyAdmin
    <abbr title="HyperText Transfer Protocol">HTTP</abbr> or cookie authentication. See the install section on
    &quot;Using <abbr title="HyperText Transfer Protocol">HTTP</abbr> authentication&quot;.
</p>

<h4 id="faq4_2">
    <a href="#faq4_2">4.2 What's the preferred way of making phpMyAdmin secure against evil
    access.
</a></h4>
<p>
    This depends on your system.<br />
    If you're running a server which cannot be accessed by other people, it's
    sufficient to use the directory protection bundled with your webserver
    (with Apache you can use <a href="#glossary"><i>.htaccess</i></a> files, for example).<br />
    If other people have telnet access to your server, you should use
    phpMyAdmin's <abbr title="HyperText Transfer Protocol">HTTP</abbr> or cookie authentication features.
    <br /><br />
    Suggestions:
</p>
<ul>
    <li>
        Your <i>config.inc.php</i> file should be <tt>chmod 660</tt>.
    </li>
    <li>
        All your phpMyAdmin files should be chown -R phpmy.apache, where phpmy
        is a user whose password is only known to you, and apache is the
        group under which Apache runs.
    </li>
    <li>
        Follow security recommendations for PHP and your webserver.
    </li>
</ul>

<h4 id="faq4_3">
    <a href="#faq4_3">4.3 I get errors about not being able to include a file in
    <i>/lang</i> or in <i>/libraries</i>.
</a></h4>
<p>
    Check <i>php.ini</i>, or ask your sysadmin to check it. The
    <tt>include_path</tt> must contain &quot;.&quot; somewhere in it, and
    <tt>open_basedir</tt>, if used, must contain &quot;.&quot; and
    &quot;./lang&quot; to allow normal operation of phpMyAdmin.
</p>

<h4 id="faq4_4">
    <a href="#faq4_4">4.4 phpMyAdmin always gives &quot;Access denied&quot; when using <abbr title="HyperText Transfer Protocol">HTTP</abbr>
    authentication.
</a></h4>

<p> This could happen for several reasons:</p>

<ul><li><a href="#cfg_Servers_controluser" class="configrule">$cfg['Servers'][$i]['controluser']</a>
        and/or
        <a href="#cfg_Servers_controlpass" class="configrule">$cfg['Servers'][$i]['controlpass']</a>
        are wrong.</li>
    <li>The username/password you specify in the login dialog are invalid.</li>
    <li>You have already setup a security mechanism for the
        phpMyAdmin-directory, eg. a <a href="#glossary"><i>.htaccess</i></a> file. This would interfere with
        phpMyAdmin's authentication, so remove it.</li>
</ul>

<h4 id="faq4_5">
    <a href="#faq4_5">4.5 Is it possible to let users create their own databases?</a></h4>

<p> Starting with 2.2.5, in the user management page, you can enter a wildcard
    database name for a user (for example &quot;joe%&quot;),
    and put the privileges you want.  For example,
    adding <tt>SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, INDEX, ALTER</tt>
    would let a user create/manage his/her database(s).</p>

<h4 id="faq4_6">
    <a href="#faq4_6">4.6 How can I use the Host-based authentication additions?</a></h4>

<p> If you have existing rules from an old <a href="#glossary"><i>.htaccess</i></a> file, you can take them
    and add a username between the <tt>'deny'</tt>/<tt>'allow'</tt> and
    <tt>'from'</tt> strings. Using the username wildcard of <tt>'%'</tt> would
    be a major benefit here if your installation is suited to using it. Then
    you can just add those updated lines into the
    <a href="#cfg_Servers_AllowDeny_rules" class="configrule">
        $cfg['Servers'][$i]['AllowDeny']['rules']</a> array.</p>

<p> If you want a pre-made sample, you can try this fragment. It stops the
    'root' user from logging in from any networks other than the private
    network <abbr title="Internet Protocol">IP</abbr> blocks.</p>

<pre>
//block root from logging in except from the private networks
$cfg['Servers'][$i]['AllowDeny']['order'] = 'deny,allow';
$cfg['Servers'][$i]['AllowDeny']['rules'] = array(
    'deny root from all',
    'allow root from localhost',
    'allow root from 10.0.0.0/8',
    'allow root from 192.168.0.0/16',
    'allow root from 172.16.0.0/12',
    );
</pre>

<h4 id="faq4_7">
    <a href="#faq4_7">4.7 Authentication window is displayed more than once, why?</a></h4>

<p> This happens if you are using a <abbr title="Uniform Resource Locator">URL</abbr> to start phpMyAdmin which is
    different than the one set in your
    <a href="#cfg_PmaAbsoluteUri" class="configrule">$cfg['PmaAbsoluteUri']</a>.
    For example, a missing &quot;www&quot;, or entering with an <abbr title="Internet Protocol">IP</abbr> address
    while a domain name is defined in the config file.</p>

<h4 id="faq4_8">
    <a href="#faq4_8">4.8 Which parameters can I use in the URL that starts phpMyAdmin?</a></h4>

<p>When starting phpMyAdmin, you can use the <tt>db</tt>, <tt>pma_username</tt>, <tt>pma_password</tt> and <tt>server</tt> parameters. This last one can contain either the numeric host index (from <tt>$i</tt> of the configuration file) or one of the host names present in the configuration file. Using <tt>pma_username</tt> and <tt>pma_password</tt> has been tested along with the usage of 'cookie' <tt>auth_type</tt>.</p>

<h3 id="faqbrowsers">Browsers or client <abbr title="operating system">OS</abbr></h3>

<h4 id="faq5_1">
    <a href="#faq5_1">5.1 I get an out of memory error, and my controls are non-functional,
    when trying to create a table with more than 14 columns.
</a></h4>
<p>
    We could reproduce this problem only under Win98/98SE. Testing under
    WinNT4 or Win2K, we could easily create more than 60 columns.
    <br />
    A workaround is to create a smaller number of columns, then come back to
    your table properties and add the other columns.
</p>

<h4 id="faq5_2">
    <a href="#faq5_2">5.2 With Xitami 2.5b4, phpMyAdmin won't process form fields.</a></h4>
<p>
    This is not a phpMyAdmin problem but a Xitami known bug: you'll face it
    with each script/website that use forms.<br />
    Upgrade or downgrade your Xitami server.
</p>

<h4 id="faq5_3">
    <a href="#faq5_3">5.3 I have problems dumping tables with Konqueror (phpMyAdmin 2.2.2).</a></h4>
<p>
    With Konqueror 2.1.1: plain dumps, zip and GZip dumps work ok, except that
    the proposed file name for the dump is always 'tbl_dump.php'. Bzip2 dumps
    don't seem to work.<br />

    With Konqueror 2.2.1: plain dumps work; zip dumps are placed into
    the user's temporary directory, so they must be moved before closing
    Konqueror, or else they disappear. GZip dumps give an error message.<br />

    Testing needs to be done for Konqueror 2.2.2.<br />
</p>

<h4 id="faq5_4">
    <a href="#faq5_4">5.4 I can't use the cookie authentication mode because Internet
    Explorer never stores the cookies.
</a></h4>
<p>
    MS Internet Explorer seems to be really buggy about cookies, at least till
    version 6.
</p>

<h4 id="faq5_5">
    <a href="#faq5_5">5.5 In Internet Explorer 5.0, I get JavaScript errors when browsing my
    rows.
</a></h4>
<p>
    Upgrade to at least Internet Explorer 5.5 SP2.<br />
</p>

<h4 id="faq5_6">
    <a href="#faq5_6">5.6 In Internet Explorer 5.0, 5.5 or 6.0, I get an error (like "Page not found")
    when trying to modify a row in a table with many columns, or with a text
    column 
</a></h4>
<p>
    Your table neither have a primary key nor an unique one, so we must use a
    long <abbr title="Uniform Resource Locator">URL</abbr> to identify this row. There is a limit on the length of the <abbr title="Uniform Resource Locator">URL</abbr> in
    those browsers, and this not happen in Netscape, for example. The
    workaround is to create a primary or unique key, or use another browser.
    <br />
</p>

<h4 id="faq5_7">
    <a href="#faq5_7">5.7 I refresh (reload) my browser, and come back to the welcome
    page.
</a></h4>
<p>
    Some browsers support right-clicking into the frame you want to refresh,
    just do this in the right frame.<br />
</p>

<h4 id="faq5_8">
    <a href="#faq5_8">5.8 With Mozilla 0.9.7 I have problems sending a query modified in the
    query box.
</a></h4>
<p>
    Looks like a Mozilla bug: 0.9.6 was OK. We will keep an eye on future
    Mozilla versions.<br />
</p>

<h4 id="faq5_9">
    <a href="#faq5_9">5.9 With Mozilla 0.9.? to 1.0 and Netscape 7.0-PR1 I can't type a
    whitespace in the <abbr title="structured query language">SQL</abbr>-Query edit area: the page scrolls down.
</a></h4>
<p>
    This is a Mozilla bug (see bug #26882 at
    <a href="http://bugzilla.mozilla.org/">BugZilla</a>).<br />
</p>

<h4 id="faq5_10">
    <a href="#faq5_10">5.10 With Netscape 4.75 I get empty rows between each row of data in a
    <abbr title="comma separated values">CSV</abbr> exported file.
</a></h4>
<p>
    This is a known Netscape 4.75 bug: it adds some line feeds when exporting
    data in octet-stream mode. Since we can't detect the specific Netscape
    version, we cannot workaround this bug.
</p>

<h4 id="faq5_11">
    <a href="#faq5_11">5.11 Extended-ASCII characters like German umlauts are displayed
    wrong.</a></h4>

<p> Please ensure that you have set your browser's character set to the one of the
    language file you have selected on phpMyAdmin's start page.
    Alternatively, you can try the auto detection mode that is supported by the
    recent versions of the most browsers.</p>

<h4 id="faq5_12">
    <a href="#faq5_12">5.12 <acronym title="Apple Macintosh">Mac</acronym> <abbr title="operating system">OS</abbr> X: Safari browser changes special characters to
    &quot;?&quot;.</a></h4>

<p> This issue has been reported by a <abbr title="operating system">OS</abbr> X user, who adds that Chimera,
    Netscape and Mozilla do not have this problem.</p>

<h4 id="faq5_13">
    <a href="#faq5_13">5.13 With Internet Explorer 5.5 or 6, and <abbr title="HyperText Transfer Protocol">HTTP</abbr> authentication type,
    I cannot manage two servers: I log in to the first one, then the other one,
    but if I switch back to the first, I have to log in on each operation.</a></h4>

<p> This is a bug in Internet Explorer, other browsers do not behave this way.</p>

<h4 id="faq5_14">
    <a href="#faq5_14">5.14 Using Opera6, I can manage to get to the authentication,
    but nothing happens after that, only a blank screen.</a></h4>

<p> Please upgrade to Opera7 at least.</p>

<h4 id="faq5_15">
    <a href="#faq5_15">5.15 I have display problems with Safari.</a></h4>

<p> Please upgrade to at least version 1.2.3.</p>

<h4 id="faq5_16">
    <a href="#faq5_16">5.16 With Internet Explorer, I get &quot;Access is denied&quot;
    Javascript errors. Or I cannot make phpMyAdmin work under Windows.</a></h4>

<p> Please check the following points:</p>
    <ul><li>Maybe you have defined your <tt>PmaAbsoluteUri</tt> setting
            in <tt>config.inc.php</tt> to an <abbr title="Internet Protocol">IP</abbr>
            address and you are starting
            phpMyAdmin with a <abbr title="Uniform Resource Locator">URL</abbr>
            containing a domain name, or the reverse situation.</li>
        <li>Security settings in IE and/or Microsoft Security Center are
            too high, thus blocking scripts execution.</li>
        <li>The Windows Firewall is blocking Apache and MySQL. You must
            allow <abbr title="HyperText Transfer Protocol">HTTP</abbr> ports
            (80 or 443) and MySQL port (usually 3306)
            in the &quot;in&quot; and &quot;out&quot; directions.</li>
    </ul>

<h4 id="faq5_17">
    <a href="#faq5_17">5.17 With Firefox, I cannot delete rows of data or drop a database.</a></h4>
<p> Many users have confirmed that the Tabbrowser Extensions plugin they
    installed in their Firefox is causing the problem.</p>

<h4 id="faq5_18">
<a href="#faq5_18">5.18 With Konqueror 4.2.x an invalid <tt>LIMIT</tt>
    clause is generated when I browse a table.</a></h4>
<p> This happens only when both of these conditions are met: using the 
    <tt>http</tt> authentication mode and <tt>register_globals</tt> being set 
    to <tt>On</tt> on the server. It seems to be a browser-specific problem; 
    meanwhile use the <tt>cookie</tt> authentication mode.</p>

<h4 id="faq5_19">
<a href="#faq5_19">5.19 I get JavaScript errors in my browser.</a></h4>
<p> Issues have been reported with some combinations of browser extensions. 
To troubleshoot, disable all extensions then clear your browser cache
to see if the problem goes away.</p>

<h3 id="faqusing">Using phpMyAdmin</h3>

<h4 id="faq6_1">
    <a href="#faq6_1">6.1 I can't insert new rows into a table / I can't create a table
    - MySQL brings up a <abbr title="structured query language">SQL</abbr>-error.
</a></h4>
<p>
    Examine the <abbr title="structured query language">SQL</abbr> error with care. Often the problem is caused by
    specifying a wrong column-type.<br />
    Common errors include:
</p>
<ul>
    <li>Using <tt>VARCHAR</tt> without a size argument</li>
    <li>Using <tt>TEXT</tt> or <tt>BLOB</tt> with a size argument</li>
</ul>
<p>
    Also, look at the syntax chapter in the MySQL manual to confirm that your
    syntax is correct.
</p>

<h4 id="faq6_2">
    <a href="#faq6_2">6.2 When I create a table, I set an index for two
        columns and
    phpMyAdmin generates only one index with those two columns.
</a></h4>
<p>
    This is the way to create a multi-columns
    index. If you want two indexes, create the first one when creating the
    table, save, then display the table properties and click the Index link to
    create the other index.
</p>

<h4 id="faq6_3">
    <a href="#faq6_3">6.3 How can I insert a null value into my table?</a></h4>
<p>
    Since version 2.2.3, you have a checkbox for each column that can be null.
    Before 2.2.3, you had to enter &quot;null&quot;, without the quotes, as the
    column's value. Since version 2.5.5, you have to use the checkbox to get
    a real NULL value, so if you enter &quot;NULL&quot; this means you want
    a literal NULL in the column, and not a NULL value (this works in PHP4).
</p>

<h4 id="faq6_4">
    <a href="#faq6_4">6.4 How can I backup my database or table?</a></h4>

<p> Click on a database or table name in the left frame, the properties will be
    displayed.  Then on the menu, click &quot;Export&quot;, you can dump
    the structure, the data, or both. This will generate standard <abbr title="structured query language">SQL</abbr>
    statements that can be used to recreate your database/table.
    <br /><br />
    You will need to choose &quot;Save as file&quot;, so that phpMyAdmin can
    transmit the resulting dump to your station. Depending on your PHP
    configuration, you will see options to compress the dump. See also the
    <a href="#cfg_ExecTimeLimit" class="configrule">$cfg['ExecTimeLimit']</a>
    configuration variable.<br /><br />

    For additional help on this subject, look for the word &quot;dump&quot; in
    this document.</p>

<h4 id="faq6_5">
    <a href="#faq6_5">6.5 How can I restore (upload) my database or table using a dump?
    How can I run a &quot;.sql&quot; file?
</a></h4>

<p> Click on a database name in the left frame, the properties will be
    displayed. Select &quot;Import&quot; from the list
    of tabs in the right&#8211;hand frame (or &quot;<abbr title="structured query language">SQL</abbr>&quot; if your phpMyAdmin
    version is previous to 2.7.0). In the &quot;Location of the text file&quot; section, type in
    the path to your dump filename, or use the Browse button. Then click Go.
    <br /><br />
    With version 2.7.0, the import engine has been re&#8211;written, if possible it is suggested
    that you upgrade to take advantage of the new features.
    <br /><br />
    For additional help on this subject, look for the word &quot;upload&quot;
    in this document.
</p>

<h4 id="faq6_6">
    <a href="#faq6_6">6.6 How can I use the relation table in Query-by-example?</a></h4>

<p> Here is an example with the tables persons, towns and countries, all
    located in the database mydb. If you don't have a <tt>pma_relation</tt>
    table, create it as explained in the configuration section. Then create the
    example tables:</p>

<pre>
CREATE TABLE REL_countries (
    country_code char(1) NOT NULL default '',
    description varchar(10) NOT NULL default '',
    PRIMARY KEY (country_code)
) TYPE=MyISAM;

INSERT INTO REL_countries VALUES ('C', 'Canada');

CREATE TABLE REL_persons (
    id tinyint(4) NOT NULL auto_increment,
    person_name varchar(32) NOT NULL default '',
    town_code varchar(5) default '0',
    country_code char(1) NOT NULL default '',
    PRIMARY KEY (id)
) TYPE=MyISAM;

INSERT INTO REL_persons VALUES (11, 'Marc', 'S', '');
INSERT INTO REL_persons VALUES (15, 'Paul', 'S', 'C');

CREATE TABLE REL_towns (
    town_code varchar(5) NOT NULL default '0',
    description varchar(30) NOT NULL default '',
    PRIMARY KEY (town_code)
) TYPE=MyISAM;

INSERT INTO REL_towns VALUES ('S', 'Sherbrooke');
INSERT INTO REL_towns VALUES ('M', 'Montr&eacute;al');
</pre>

<p> To setup appropriate links and display information:</p>

<ul><li>on table &quot;REL_persons&quot; click Structure, then Relation view</li>
    <li>in Links, for &quot;town_code&quot; choose &quot;REL_towns-&gt;code&quot;</li>
    <li>in Links, for &quot;country_code&quot; choose &quot;REL_countries-&gt;country_code&quot;</li>
    <li>on table &quot;REL_towns&quot; click Structure, then Relation view</li>
    <li>in &quot;Choose column to display&quot;, choose &quot;description&quot;</li>
    <li>repeat the two previous steps for table &quot;REL_countries&quot;</li>
</ul>

<p> Then test like this:</p>

<ul><li>Click on your db name in the left frame</li>
    <li>Choose &quot;Query&quot;</li>
    <li>Use tables: persons, towns, countries</li>
    <li>Click &quot;Update query&quot;</li>
    <li>In the columns row, choose persons.person_name and click the
        &quot;Show&quot; tickbox </li>
    <li>Do the same for towns.description and countries.descriptions in the
        other 2 columns</li>
    <li>Click &quot;Update query&quot; and you will see in the query box that
        the correct joins have been generated</li>
    <li>Click &quot;Submit query&quot;</li>
</ul>

<h4 id="faqdisplay">
    <a href="#faqdisplay">6.7 How can I use the &quot;display column&quot; feature?</a></h4>
<p>
    Starting from the previous example, create the pma_table_info as explained
    in the configuration section, then browse your persons table,
    and move the mouse over a town code or country code.
    <br /><br />
    See also <a href="#faq6_21"><abbr title="Frequently Asked Questions">FAQ</abbr> 6.21</a> for an additional feature that &quot;display column&quot;
    enables: drop-down list of possible values.
</p>

<h4 id="faqpdf">
    <a href="#faqpdf">6.8 How can I produce a <abbr title="Portable Document Format">PDF</abbr> schema of my database?</a></h4>
<p>
    First the configuration variables &quot;relation&quot;,
    &quot;table_coords&quot; and &quot;pdf_pages&quot; have to be filled in.
    <br /><br />
    Then you need to think about your schema layout. Which tables will go on
    which pages?
</p>
<ul>
    <li>Select your database in the left frame.</li>
    <li>Choose &quot;Operations&quot; in the navigation bar at the top.</li>
    <li>Choose &quot;Edit <abbr title="Portable Document Format">PDF</abbr>
        Pages&quot; near the bottom of the page.</li>
    <li>Enter a name for the first <abbr title="Portable Document Format">PDF</abbr>
        page and click Go. If you like, you
        can use the &quot;automatic layout,&quot; which will put all your
        linked tables onto the new page.</li>
    <li>Select the name of the new page (making sure the Edit radio button
        is selected) and click Go.</li>
    <li>Select a table from the list, enter its coordinates and click Save.<br />
        Coordinates are relative; your diagram will
        be automatically scaled to fit the page. When initially placing tables
        on the page, just pick any coordinates -- say, 50x50. After clicking
        Save, you can then use the <a href="#wysiwyg">graphical editor</a> to
        position the element correctly.</li>
    <li>When you'd like to look at your <abbr title="Portable Document Format">PDF</abbr>,
        first be sure to click the Save
        button beneath the list of tables and coordinates, to save any changes
        you made there. Then scroll all the way down, select the
        <abbr title="Portable Document Format">PDF</abbr> options
        you want, and click Go.</li>
    <li>Internet Explorer for Windows may suggest an incorrect filename when
        you try to save a generated <abbr title="Portable Document Format">PDF</abbr>.
        When saving a generated <abbr title="Portable Document Format">PDF</abbr>, be
        sure that the filename ends in &quot;.pdf&quot;, for example
        &quot;schema.pdf&quot;. Browsers on other operating systems, and other
        browsers on Windows, do not have this problem.</li>
</ul>

<h4 id="faq6_9">
    <a href="#faq6_9">6.9 phpMyAdmin is changing the type of one of my
    columns!</a></h4>

<p> No, it's MySQL that is doing
    <a href="http://dev.mysql.com/doc/en/silent-column-changes.html">silent
    column type changing</a>.</p>

<h4 id="underscore">
    <a href="#underscore">6.10 When creating a privilege, what happens with
    underscores in the database name?</a></h4>

<p> If you do not put a backslash before the underscore, this is a wildcard
    grant, and the underscore means &quot;any character&quot;. So, if the
    database name is &quot;john_db&quot;, the user would get rights to john1db,
    john2db ...<br /><br />

    If you put a backslash before the underscore, it means that the database
    name will have a real underscore.</p>

<h4 id="faq6_11">
    <a href="#faq6_11">6.11 What is the curious symbol &oslash; in the
    statistics pages?</a></h4>

<p> It means &quot;average&quot;.</p>

<h4 id="faqexport">
    <a href="#faqexport">6.12 I want to understand some Export options.</a></h4>

<p><b>Structure:</b></p>

<ul><li>&quot;Add DROP TABLE&quot; will add a line telling MySQL to
        <a href="http://dev.mysql.com/doc/mysql/en/drop-table.html">drop the table</a>,
        if it already exists during the import. It does NOT drop the table after
        your export, it only affects the import file.</li>
    <li>&quot;If Not Exists&quot; will only create the table if it doesn't exist.
        Otherwise, you may get an error if the table name exists but has a
        different structure.</li>
    <li>&quot;Add AUTO_INCREMENT value&quot; ensures that AUTO_INCREMENT value
        (if any) will be included in backup.</li>
    <li>&quot;Enclose table and column names with backquotes&quot; ensures that
        column and table names formed with special characters are protected.</li>
    <li>&quot;Add into comments&quot; includes column comments, relations, and MIME
        types set in the pmadb in the dump as
        <abbr title="structured query language">SQL</abbr> comments (<i>/* xxx */</i>).
       </li>
</ul>

<p><b>Data:</b></p>

<ul><li>&quot;Complete inserts&quot; adds the column names on every INSERT
        command, for better documentation (but resulting file is bigger).</li>
    <li>&quot;Extended inserts&quot; provides a shorter dump file by using only
        once the INSERT verb and the table name.</li>
    <li>&quot;Delayed inserts&quot; are best explained in the
        <a href="http://dev.mysql.com/doc/mysql/en/insert-delayed.html">MySQL manual</a>.
       </li>
    <li>&quot;Ignore inserts&quot; treats errors as a warning instead. Again,
        more info is provided in the
        <a href="http://dev.mysql.com/doc/mysql/en/insert.html">MySQL manual</a>,
        but basically with this selected, invalid values are adjusted and
        inserted rather than causing the entire statement to fail.</li>
</ul>

<h4 id="faq6_13">
    <a href="#faq6_13">6.13 I would like to create a database with a dot
    in its name.</a></h4>

<p> This is a bad idea, because in MySQL the syntax &quot;database.table&quot;
    is the normal way to reference a database and table name. Worse, MySQL
    will usually let you create a database with a dot, but then you cannot
    work with it, nor delete it.</p>

<h4 id="faqsqlvalidator">
    <a href="#faqsqlvalidator">6.14 How do I set up the
    <abbr title="structured query language">SQL</abbr> Validator?</a></h4>

<p> 
    To use SQL Validator, you need PHP with 
    <abbr title="Extensible Markup Language">XML</abbr>,
    <abbr title="Perl Compatible Regular Expressions">PCRE</abbr> and
    <abbr title="PHP Extension and Application Repository">PEAR</abbr> support.
    In addition you need a <abbr title="Simple Object Access
    Protocol">SOAP</abbr> support, either as a PHP extension or as a PEAR SOAP
    module.
</p>

<p>
    To install <abbr title="PHP Extension and Application
    Repository">PEAR</abbr> <abbr title="Simple Object Access
    Protocol">SOAP</abbr> module, run <tt>"pear install Net_Socket Net_URL
    HTTP_Request Mail_Mime Net_DIME SOAP"</tt> to get the necessary <abbr
    title="PHP Extension and Application Repository">PEAR</abbr> modules for
    usage.
</p>

<p>
    If you use the Validator, you should be aware that any
    <abbr title="structured query language">SQL</abbr> statement you
    submit will be stored anonymously (database/table/column names,
    strings, numbers replaced with generic values). The Mimer
    <abbr title="structured query language">SQL</abbr>
    Validator itself, is &copy; 2001 Upright Database Technology.
    We utilize it as free SOAP service.
</p>

<h4 id="faq6_15">
    <a href="#faq6_15">6.15 I want to add a BLOB column and put an index on
    it, but MySQL says &quot;BLOB column '...' used in key specification without
    a key length&quot;.</a></h4>

<p> The right way to do this, is to create the column without any indexes,
    then display the table structure and use the &quot;Create an index&quot;
    dialog. On this page, you will be able to choose your BLOB column, and
    set a size to the index, which is the condition to create an index on
    a BLOB column.</p>

<h4 id="faq6_16">
    <a href="#faq6_16">6.16 How can I simply move in page with plenty
    editing fields?</a></h4>

<p> You can use Ctrl+arrows (Option+Arrows in Safari) for moving on most pages
    with many editing fields (table structure changes, row editing, etc.).</p>

<h4 id="faq6_17">
    <a href="#faq6_17">6.17 Transformations: I can't enter my own mimetype!
    WTF is this feature then useful for?</a></h4>

<p> Slow down :). Defining mimetypes is of no use, if you can't put transformations
    on them. Otherwise you could just put a comment on the column. Because entering
    your own mimetype will cause serious syntax checking issues and validation,
    this introduces a high-risk false-user-input situation. Instead you have to
    initialize mimetypes using functions or empty mimetype definitions.<br />
    Plus, you have a whole overview of available mimetypes. Who knows all those
    mimetypes by heart so he/she can enter it at will?</p>

<h4 id="faqbookmark">
    <a href="#faqbookmark">6.18 Bookmarks: Where can I store bookmarks? Why
    can't I see any bookmarks below the query box? What is this variable for?
</a></h4>

<p> Any query you have executed can be stored as a bookmark on the page where the
    results are displayed. You will find a button labeled 'Bookmark this query'
    just at the end of the page.<br />
    As soon as you have stored a bookmark, it is related to the database you run
    the query on. You can now access a bookmark dropdown on each page, the query
    box appears on for that database.<br /><br />

    Since phpMyAdmin 2.5.0 you are also able to store variables for the bookmarks.
    Just use the string <b>/*[VARIABLE]*/</b> anywhere in your query. Everything
    which is put into the <i>value</i> input box on the query box page will
    replace the string &quot;/*[VARIABLE]*/&quot; in your stored query. Just be
    aware of that you HAVE to create a valid query, otherwise your query won't be
    even able to be stored in the database.<br />
    Also remember, that everything else inside the <b>/*[VARIABLE]*/</b> string
    for your query will remain the way it is, but will be stripped of the /**/
    chars. So you can use:<br /><br />

    <code>/*, [VARIABLE] AS myname */</code><br /><br />

    which will be expanded to<br /><br />

    <code>, VARIABLE as myname</code><br /><br />

    in your query, where VARIABLE is the string you entered in the input box. If
    an empty string is provided, no replacements are made.<br /><br />

    A more complex example. Say you have stored this query:<br /><br />
    <code>SELECT Name, Address FROM addresses WHERE 1 /* AND Name LIKE '%[VARIABLE]%' */</code>
    <br /><br />

    Say, you now enter &quot;phpMyAdmin&quot; as the variable for the stored query,
    the full query will be:<br /><br />

    <code>SELECT Name, Address FROM addresses WHERE 1 AND Name LIKE '%phpMyAdmin%'</code>
    <br /><br />

    You can use multiple occurrences of <b>/*[VARIABLE]*/</b> in a single query (that is, multiple occurrences of the <i>same</i> variable).<br />
    <b>NOTE THE ABSENCE OF SPACES</b> inside the &quot;/**/&quot; construct. Any
    spaces inserted there
    will be later also inserted as spaces in your query and may lead to unexpected
    results especially when
    using the variable expansion inside of a &quot;LIKE ''&quot; expression.<br />
    Your initial query which is going to be stored as a bookmark has to yield at
    least one result row so
    you can store the bookmark. You may have that to work around using well
    positioned &quot;/**/&quot; comments.</p>

<h4 id="faq6_19">
    <a href="#faq6_19">6.19 How can I create simple L<sup>A</sup>T<sub><big>E</big></sub>X document to
    include exported table?</a></h4>

<p> You can simply include table in your L<sup>A</sup>T<sub><big>E</big></sub>X documents, minimal sample
    document should look like following one (assuming you have table
    exported in file <code>table.tex</code>):</p>

<pre>
\documentclass{article} % or any class you want
\usepackage{longtable}  % for displaying table
\begin{document}        % start of document
\include{table}         % including exported table
\end{document}          % end of document
</pre>

<h4 id="faq6_20">
    <a href="#faq6_20">6.20 I see a lot of databases which are not mine, and cannot
    access them.
</a></h4>

<p> You have one of these global privileges: CREATE
    TEMPORARY TABLES, SHOW DATABASES, LOCK TABLES. Those privileges also
    enable users to see all the database names.
    See this <a href="http://bugs.mysql.com/179">bug report</a>.<br /><br />

    So if your users do not need those privileges, you can remove them and their
    databases list will shorten.</p>

<h4 id="faq6_21">
    <a href="#faq6_21">6.21 In edit/insert mode, how can I see a list of
    possible values for a column, based on some foreign table?</a></h4>

<p> You have to setup appropriate links between the tables, and also
    setup the &quot;display column&quot; in the foreign table. See
    <a href="#faq6_6"><abbr title="Frequently Asked Questions">FAQ</abbr>
    6.6</a> for an example. Then, if there are 100 values or less in the
    foreign table, a drop-down list of values will be available.
    You will see two lists of values, the first list containing the key
    and the display column, the second list containing the display column 
    and the key. The reason for this is to be able to type the first
    letter of either the key or the display column.<br /><br />

    For 100 values or more, a distinct window will appear, to browse foreign
    key values and choose one. To change the default limit of 100, see
    <tt><a href="#cfg_ForeignKeyMaxLimit" class="configrule">$cfg['ForeignKeyMaxLimit']</a></tt>.</p>

<h4 id="faq6_22">
    <a href="#faq6_22">6.22 Bookmarks: Can I execute a default bookmark
    automatically when entering Browse mode for a table?</a></h4>

<p> Yes. If a bookmark has the same label as a table name and it's not a public bookmark, it will be executed.
</p>

<h4 id="faq6_23">
    <a href="#faq6_23">6.23 Export: I heard phpMyAdmin can export Microsoft Excel files?</a></h4>

<p> You can use
    <abbr title="comma separated values">CSV</abbr> for Microsoft Excel,
    which works out of the box.<br />
    Since phpMyAdmin 3.4.5 support for direct export to Microsoft Excel 
    version 97 and newer was dropped.
</p>

<h4 id="faq6_24">
    <a href="#faq6_24">6.24 Now that phpMyAdmin supports native MySQL 4.1.x column comments,
    what happens to my column comments stored in pmadb?</a></h4>

<p> Automatic migration of a table's pmadb-style column comments to the native
    ones is done whenever you enter Structure page for this table.</p>

<h4 id="faq6_25">
    <a href="#faq6_25">6.25 How does BLOB streaming work in phpMyAdmin?</a></h4>

<p> For general information about BLOB streaming on MySQL, visit <a href="http://blobstreaming.org">blobstreaming.org</a>. You need the following components:</p>
<ul>
    <li>PBMS BLOB Streaming Daemon for MySQL (0.5.15 or later)</li>
    <li>Streaming enabled PBXT Storage engine for MySQL (1.0.11-6 or
    later)</li>
    <li>PBMS Client Library for MySQL (0.5.15 or later)</li>
    <li>PBMS PHP Extension for MySQL (0.1.1 or later)</li>
</ul>

<p>Here are details about configuration and operation:</p>

<ol>
    <li>In <tt>config.inc.php</tt> your host should be defined with a FQDN (fully qualified domain name) instead of &quot;localhost&quot;.</li>
    <li>Ensure that your target table is under the <tt>PBXT</tt> storage engine and has a <tt>LONGBLOB</tt> column (which must be nullable if you want to remove the BLOB reference from it).</li>
    <li>When you insert or update a row in this table, put a checkmark on the &quot;Upload to BLOB repository&quot; optional choice; otherwise, the upload will be done directly in your LONGBLOB column instead of the repository.</li>
    <li>Finally when you browse your table, you'll see in your column a link to stream your data, for example &quot;View image&quot;. A header containing the correct MIME-type will be sent to your browser; this MIME-type was stored at upload time.</li> 
</ol>    

<h4 id="faq6_26">
    <a href="#faq6_26">6.26 How can I select a range of rows?</a></h4>

<p> Click the first row of the range, hold the shift key and click the last row of the range. This works everywhere you see rows, for example in Browse mode or on the Structure page.</p>


<h4 id="faq6_27">
    <a href="#faq6_27">6.27 What format strings can I use?</a></h4>

<p>
    In all places where phpMyAdmin accepts format strings, you can use
    <code>@VARIABLE@</code> expansion and 
    <a href="http://php.net/strftime">strftime</a> format strings. The
    expanded variables depend on a context (for example, if you haven't chosen a 
    table, you can not get the table name), but the following variables can be used:
</p>
<dl>
    <dt><code>@HTTP_HOST@</code></dt>
        <dd>HTTP host that runs phpMyAdmin</dd>
    <dt><code>@SERVER@</code></dt>
        <dd>MySQL server name</dd>
    <dt><code>@VERBOSE@</code></dt>
        <dd>Verbose MySQL server name as defined in <a href="#cfg_Servers_verbose">server configuration</a></dd>
    <dt><code>@VSERVER@</code></dt>
        <dd>Verbose MySQL server name if set, otherwise normal</dd>
    <dt><code>@DATABASE@</code></dt>
        <dd>Currently opened database</dd>
    <dt><code>@TABLE@</code></dt>
        <dd>Currently opened table</dd>
    <dt><code>@COLUMNS@</code></dt>
        <dd>Columns of the currently opened table</dd>
    <dt><code>@PHPMYADMIN@</code></dt>
        <dd>phpMyAdmin with version</dd>
</dl>

<h4 id="wysiwyg">
    <a href="#wysiwyg">6.28 How can I easily edit relational schema for export?</a></h4>

    <p> 
        By clicking on the button 'toggle scratchboard' on the page
        where you edit x/y coordinates of those elements you can activate a
        scratchboard where all your elements are placed. By clicking on an
        element, you can move them around in the pre-defined area and the x/y
        coordinates will get updated dynamically. Likewise, when entering a
        new position directly into the input field, the new position in the
        scratchboard changes after your cursor leaves the input field.
    </p>
    <p>
        You have to click on the 'OK'-button below the tables to save the new
        positions.  If you want to place a new element, first add it to the
        table of elements and then you can drag the new element around.
    </p>
    <p>
        By changing the paper size and the orientation you can change the size
        of the scratchboard as well. You can do so by just changing the
        dropdown field below, and the scratchboard will resize automatically,
        without interfering with the current placement of the elements.
    </p>
    <p>
        If ever an element gets out of range you can either enlarge the paper
        size or click on the 'reset' button to place all elements below each
        other.
    </p>


    <h2 id="extjs_components">Ext JS - Components List</h2>
    <a href="http://extjs.com/deploy/dev/docs/?class=Ext.Component" target="_blank">Sencha.com - Ext.Component List</a>
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
        <li><a href="#">Donate</a></li>
    </ul>
</body>
</html>
