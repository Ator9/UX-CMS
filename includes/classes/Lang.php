<?php
/**
 * Language Class. CSV format
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 * Usage 1. Load file & translate:
 * $lang = new Lang('es');
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
	public $lang = 'es';     // Current lang
	public $words = array(); // Loaded translations
	

	// ------------------------------------------------------------------------------- //


    /*
    * Construct
    *
    * Set language
    */
	public function __construct($lang = '')
    {
        if($lang != '') $this->lang = $lang;
    }
    
    
    /**
     * Translate
     *
     * Allows "key" & "module.key" format.
     *
     * Example 1: $lang->t('yes');
     * Example 2: $lang->t('admins.yes');
     *
     * @return String
     */ 
    public function t($key)
    {
        if(strpos($key, '.') !== false)
        {
            list($module, $key) = explode('.', $key);
            $data = $this->loadModule($module, false);
            
            if(array_key_exists($key, $data)) return $data[$key];
        }
        
        if(array_key_exists($key, $this->words)) return $this->words[$key];
        return $key;
    }
    
    
    /**
     * Loads module locale
     *
     * Example 1: $lang->loadModule('admins');
     *
     * @return Array
     */ 
	public function loadModule($module='', $merge_words=true)
	{
	    return $this->load(ROOT.'/modules/'.$module.'/locale/'.$this->lang.'.csv', $merge_words);
	}
	
	
	/**
     * Loads locale csv
     *
     * @return Array
     */ 
	public function load($file='', $merge_words=true)
	{
		if(file_exists($file))
		{
		    if(($handle = fopen($file, 'r')) !== FALSE)
            {
                while(($data = fgetcsv($handle, 1000)) !== FALSE) if($data[0] != '') $words[$data[0]] = $data[1];
                fclose($handle);
                
                if($merge_words) $this->words = array_merge($this->words, (array) $words);
            }
		}
		return (array) $words;
	}
}


