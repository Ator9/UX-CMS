<?php
/**
 * Lang Class. CSV format
 *
 * @author Sebastián Gasparri
 * @version 08/04/2014 15:46:13
 * http://www.linkedin.com/in/sgasparri
 *
 * Usage 1. Load file & translate:
 * $lang = new Lang;
 * $lang->load($path_to_csv_locale);
 * $lang->t('add');
 *
 * Usage 2. Load module & translate:
 * $lang = new Lang;
 * $lang->loadModule('admins');
 * $lang->t('add');
 *
 * Usage 3. Automatic module load & translate:
 * $lang = new Lang;
 * $lang->t('admins.add');
 * 
 */
class Lang
{
	public $lang = 'es'; // Current lang
	public $words = array(); // Loaded translations
	

	// ------------------------------------------------------------------------------- //


    /*
    * Construct
    *
    * Set language or loads admin locale if $aSession exists
    */
	public function __construct($lang = '')
    {
        if($lang != '') $this->lang = $lang;
        else
        {
            global $aSession; // Admin session
            if(is_object($aSession))
            {
                $this->lang = $aSession->get('locale');
                $this->load(ROOT.'/admin/locale/'.$this->lang.'_core.csv'); // Loads admin core locale
                $this->load(ROOT.'/admin/locale/'.$this->lang.'.csv'); // Loads admin custom locale
            }
        }
    }
    
    
    /**
     * Translate
     *
     * Allows "key" & "module.key" format.
     *
     * Example 1: $lang->t('yes');
     * Example 2: $lang->t('admins.yes');
     *
     * @return string
     */ 
    public function t($key)
    {
        if(strpos($key, '.') !== false)
        {
            list($module, $key) = explode('.', $key);
            $data = $this->load(ROOT.'/modules/'.$module.'/locale/'.$this->lang.'.csv', true);
            
            if(array_key_exists($key, $data)) return $data[$key];
            return $key;
        }
        
        if(array_key_exists($key, $this->data)) return $this->data[$key];
        return $key;
    }
    
    
    /**
     * Loads module locale
     *
     * Example 1: $lang->loadModule('admins');
     *
     * @return void
     */ 
	public function loadModule($module='')
	{
	    $this->load(ROOT.'/modules/'.$module.'/locale/'.$this->lang.'.csv');
	}
	
	
	/**
     * Loads locale csv
     *
     * @return void
     */ 
	public function load($file='', $return=false)
	{
		if(file_exists($file))
		{
		    if(($handle = fopen($file, 'r')) !== FALSE)
            {
                $words = array();
                while(($data = fgetcsv($handle, 1000)) !== FALSE) $words[$data[0]] = $data[1];
                fclose($handle);
                
                if($return) return $words;
                $this->data = array_merge($this->data, $words);
            }
		}
	}
}


