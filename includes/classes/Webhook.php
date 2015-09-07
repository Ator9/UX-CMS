<?php
/**
 * Webhook Bitbucket / GitHub
 *
 *
 * Usage:
 * $params = [
 *     'git_dir'  => '/var/www/acc.adverit.com/private',
 *     'work_dir' => '/var/www/acc.adverit.com/web'
 *  ];
 * $webhook = new Webhook($params);
 * $webhook->run();
 *
 *
 * Add:
 *     git remote add origin git@bitbucket.org:username/project.git
 *     sudo chmod -R 777 private/
 *
 * Fix for "--bare" repositories (adds clone configuration):
 *     git config merge.defaultToUpstream true
 *     git branch --track master origin/master
 *
 */
class Webhook
{
    private $git_dir  = ''; // /var/www/sitedir/private
    private $work_dir = ''; // /var/www/sitedir/web
    // private whitelisted_ips = [ '131.103.20.04' ];


    // ------------------------------------------------------------------------------- //


    /**
     * Construct - Set config
     */
    public function __construct($params = [])
    {
        foreach($params as $key => $value)
        {
            if(isset($this->$key)) $this->$key = $value;
        }
    }


    public function run()
    {
        if($this->git_dir == '' || $this->work_dir == '') exit('Invalid dir config');

        echo 'Starting Git Sync...<br><br>';
        echo 'Current User: '.exec('whoami').'<br><br>';
        echo 'Current Path: '.exec('pwd').'<br><br>';
        
        echo $command = 'git --work-tree=/var/www/acc.adverit.com/web --git-dir=/var/www/acc.adverit.com/private checkout -f';
        exec($command, $output);
        vd($output);

        echo $command = 'git --work-tree=/var/www/acc.adverit.com/web --git-dir=/var/www/acc.adverit.com/private pull';
        echo '<br><br>';
        passthru($command);
    }
}
