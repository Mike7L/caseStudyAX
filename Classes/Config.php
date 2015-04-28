<?php
/**
 * Description of Config
 */
class Config {

    /**
    *
    * @var Config: one instance is enough
    */
    private static $_instance;
    
    /**
     * Application settings. Public acces
     * @var array 
     */
    public $settings;

    /**
     * Creates Config
     */
    private function __construct()
    {
         $settingsINI = new Zend_Config_INI(dirname(__FILE__).'/../Config/settings.ini');
         $this->settings = $settingsINI->toArray();
    }

    /**
     * Returns an instance, if there is no instance created yet, creates one
     * @return Config
     */
    public static function getInstance()
    {
      if ( is_null( self::$_instance ) )
      {
        self::$_instance = new self();
      }
      return self::$_instance;
    }
}
