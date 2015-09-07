<?php
/**
 * Webhook Bitbucket / GitHub
 *
 *
 * Usage:
 * $params = [
 *     'git_dir'  => '/var/www/domain.com/private',
 *     'work_dir' => '/var/www/domain.com/web'
 *  ];
 * $webhook = new Webhook($params);
 * $webhook->run();
 *
 *
 * Repo config:
 *     git remote add origin git@bitbucket.org:username/project.git
 *     sudo chown -R user:group .
 * 
 * Simulate user:
 *     sudo -u web15 git...
 *
 * Fix for "--bare" repositories (adds clone configuration):
 *     git branch --track master origin/master
 *     git config merge.defaultToUpstream true
 *     
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
        echo 'Current User: '.exec('whoami').'<br>';
        echo 'Current Path: '.exec('pwd').'<br><br>';
        
        echo $command = 'git --work-tree='.$this->work_dir.' --git-dir='.$this->git_dir.' checkout -f';
        exec($command, $output);
        vd($output);

        echo $command = 'git --work-tree='.$this->work_dir.' --git-dir='.$this->git_dir.' pull origin master';
        exec($command, $output);
        vd($output);
    }
}
