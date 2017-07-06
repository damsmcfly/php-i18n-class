<?php
/**
 * 
 * damsmcfly/php-i18n-class
 * A simple PHP class to help you easily translate your website from JSON files.
 * 
 * @link https://github.com/damsmcfly/php-i18n-class
 * 
 * @author	Damien Gosset
 * 
 */


// example constant to use for message files
define('PATH', dirname(__FILE__).DIRECTORY_SEPARATOR."../locales");

class i18n {	
	protected $path;
	protected $lang = "en";
	protected $file = "layout/get";
	protected $_phrases = array();	

	/**
	 * Constructor
	 * @param String $lang 		Language file to load (en=messages_en.txt, etc)
	 * @param String $path 		Path to translation directory
	 * @param String $file 		Directory/file (without .json extension) to the language file
	 */
	public function __construct($lang, $file, $path = PATH)
	{
		$this->setLang($lang);
		$this->setPath($path);
		$this->setFile($file);
		$this->loadPhrases();
	}
	
	/**
	 * Path setter
	 * @param String $path Path
	 */
	protected function setPath($path)
	{
		$this->path= $path;
	}
	
	/**	
	 * Lang setter
	 * @param String $lang Lang
	 */
	protected function setLang($lang)
	{
		$this->lang = $lang;
	}

	/**
	 * File setter
	 * @param String $file File
	 */
	protected function setFile($file)
	{
		$this->file = $file;
	}	
		
	/**
	 * Load phrases from JSON file
	 * 
	 * @return boolean
	 */
	protected function loadPhrases()
	{
		$filename = $this->path."/".$this->lang."/".$this->file.".json";
		if(!file_exists($filename)) {
			return false;
		}		
		$string = file_get_contents($filename);
		$json = json_decode($string, true);
		foreach ($json as $name => $category){
			$this->_phrases[$name] = $category;
		}
	}
		
	/**
	 * Returns a translated phrase from its key
	 * 
	 * The JSON translation files have key/value pairs.
	 * The value may contain curly placeholders for variable parts, like this :
	 * 		"welcomemsg" : "Wilkommen !",
	 * 		"sayhello" : "Guten Tag {0} {1}.",
	 * 
	 * Method call :	
	 * 					$i->getPhrase("welcomemsg");
	 * 					$i->getPhrase("sayhello", "Jane", "Doe");
	 * Return :			
	 * 					Wilkommen !
	 * 					Guten Tag Jane Doe.
	 * 
	 * @var string $string Key of the phrase you're looking for, ie "sayhello"
	 * 
	 * @return string $phrase The translated phrase (or null if phrase isn't found)
	 */
	public function getPhrase($string)
	{
		$args = func_get_args();
		array_shift($args);
		if(strpos($string, '.') !== false) {
			list($key, $value) = explode('.', $string);	
			if(!array_key_exists($key, $this->_phrases))
			{
				return null;
			}
			$phrase= $this->_phrases[$key][$value];
		}
		else{
			if(!array_key_exists($string, $this->_phrases))
			{
				return null;
			}
			$phrase= $this->_phrases[$string];
		}
		foreach($args as $key=>$arg)
		{
			$phrase= str_replace("{".$key."}", $arg, $phrase);
		}
		return $phrase;
	}
	
	/**
	 * Returns a translated plural phrase from its key
	 *
	 * The JSON translation files have key/value pairs.
	 * The value may contain curly placeholders for variable parts, like this :
	 * 		"usersonline" :{
	 * 			"sing": "There is {0} user online.",
	 * 			"plur": "There are {0} users online."
	 * 		}
	 *
	 * Method call : 	$i->getPlural("usersonline", 1);
	 * Return : 		There is 1 user online.
	 * 
	 * Method call : 	$i->getPlural("usersonline", 666);
	 * Return :  		There are 666 users online.		
	 *
	 * @var string $string Key of the phrase you're looking for, ie "sayhello"
	 *
	 * @return string $phrase The translated pluralized version of your phrase (or null if phrase isn't found)
	 */
	public function getPlural($string)
	{
		$args = func_get_args();
		array_shift($args);
		if(strpos($string, '.') !== false) {
			list($key, $value) = explode('.', $string);
			if(!array_key_exists($key, $this->_phrases))
			{
				return null;
			}
			// array containing singular (0) and plural (1)
			$singplur = $this->_phrases[$key][$value];
		}
		else{
			if(!array_key_exists($string, $this->_phrases))
			{
				return null;
			}
			$singplur = $this->_phrases[$string];
		}
		foreach($args as $key=>$arg)
		{
			// plural
			if($arg>1) $text = str_replace("{".$key."}", $arg, $singplur['plur']);
			// singular
			else $text = str_replace("{".$key."}", $arg, $singplur['sing']);
		}
		return $text;	
		
		
	}
	
	/*
	 * Alias of getPhrase
	 */
	public function ph($string)
	{
		return $this->getPhrase($string);
	}
	
	/*
	 * Alias of getPlural
	 */
	public function pl($string)
	{
		$args = func_get_args();
		return $this->getPlural($string, $args[1]);
	}
	
}

